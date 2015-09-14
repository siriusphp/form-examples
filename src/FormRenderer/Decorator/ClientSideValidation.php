<?php

namespace Sirius\FormExamples\FormRenderer\Decorator;


use Sirius\FormRenderer\Renderer;
use Sirius\FormRenderer\Widget\Form;
use Sirius\Html\Tag;
use Sirius\Validation\Rule\AbstractRule;

/**
 * Implementing client side validation depends on the javascript library being used. Some let you use a configuration
 * object which have different formats, others allow you to used HTML attributes which follow specific patterns.
 * The implementation below appends a script that used the jQuery Validation plugin http://jqueryvalidation.org/
 *
 * Alternatively you can build a view helper that generates the necessary javascript code.
 */

class ClientSideValidation
{

    protected $clientSideRules = [
        'Sirius\Validation\Rule\Required'  => 'required',
        'Sirius\Validation\Rule\Email'     => 'email',
        'Sirius\Validation\Rule\MinLength' => 'minlength',
    ];

    public function __invoke(Tag $tag, Renderer $renderer)
    {
        if ($tag instanceof Form) {
            $tag->set('novalidate', 'novalidate');
            $this->appendScript($tag, $renderer);
        }

        return $tag;
    }

    protected function appendScript(Tag $tag, Renderer $renderer)
    {
        /* @var $form \Sirius\Input\InputFilter */
        $form     = $tag->get('_form');
        $rules    = array();
        $messages = array();
        foreach ($form->getValidator()->getRules() as $selector => $valueValidator) {
            /* @var $valueValidator \Sirius\Validation\ValueValidator */
            foreach ($valueValidator->getRules() as $rule) {
                /* @var $rule \Sirius\Validation\Rule\AbstractRule */
                $clientSideRule = $this->getClientSideRule($rule);
                if ($clientSideRule) {
                    $rules[$selector][$clientSideRule['name']]    = $clientSideRule['options'];
                    $messages[$selector][$clientSideRule['name']] = $rule->getPotentialMessage()->__toString();
                }
            }
        }
        if ( ! $tag->get('id')) {
            $tag->set('id', 'f' . rand(1, 1000));
        }
        $formId   = $tag->get('id');
        $rules    = json_encode($rules);
        $messages = json_encode($messages);
        $script   = <<<JSCRIPT
<script>
jQuery && jQuery('#$formId').validate({
    rules: $rules,
    messages: $messages,
    errorElement: 'div',
    errorClass: 'error',
    errorPlacement: function(error, element) {
        // Append error within linked label
        error.addClass('alert alert-danger');
        $( element ).closest( ".form-group" ).prepend( error );
    },
});
</script>
JSCRIPT;
        $tag->after($script);
    }

    protected function getClientSideRule(AbstractRule $rule)
    {
        if (isset($this->clientSideRules[get_class($rule)])) {
            $options = true;
            if (get_class($rule) == 'Sirius\\Validation\\Rule\\MinLength') {
                $options = $rule->getOption('min');
            }

            return [
                'name'    => $this->clientSideRules[get_class($rule)],
                'options' => $options
            ];
        }

        return false;
    }


}