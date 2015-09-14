<?php

namespace Sirius\FormExamples\FormRenderer\Decorator;

use Sirius\FormRenderer\Renderer;
use Sirius\FormRenderer\Tag\Error;
use Sirius\FormRenderer\Tag\Label;
use Sirius\FormRenderer\Tag\Radioset;
use Sirius\FormRenderer\Widget\AbstractWidget;
use Sirius\FormRenderer\Widget\Button;
use Sirius\FormRenderer\Widget\Checkboxset;
use Sirius\FormRenderer\Widget\Form;
use Sirius\FormRenderer\Widget\Reset;
use Sirius\FormRenderer\Widget\Submit;
use Sirius\Html\Tag;
use Sirius\Html\Tag\Input;
use Sirius\Input\Specs;
use Sirius\Validation\ErrorMessage;

/**
 * This depends on the translation implementation.
 * You can inject a callback into the translator, a translator object etc.
 */

class Translator
{
    public function __invoke(Tag $tag, Renderer $renderer)
    {
        if ($tag instanceof AbstractWidget) {
            $this->translateLabel($tag, $renderer);
            $this->translateError($tag, $renderer);
            $this->translateHint($tag, $renderer);
            $this->translateInputOptions($tag, $renderer);
        }
        if ($tag instanceof Button) {
            $this->translateButton($tag, $renderer);
        }

        return $tag;
    }

    protected function getStringTranslation($str, $lang)
    {
        return sprintf('%s [%s] ', $str, strtoupper($lang));
    }

    protected function getErrorMessageTranslation(ErrorMessage $msg, $lang)
    {
        $newMsg = clone($msg);
        $newMsg->setTemplate($this->getStringTranslation($newMsg->getTemplate(), $lang));
        $vars = $newMsg->getVariables();
        foreach ($vars as $k => $v) {
            if (is_string($v)) {
                $vars[$k] = $this->getStringTranslation($v, $lang);
            }
        }
        $newMsg->setVariables($vars);

        return $newMsg;
    }

    protected function translateLabel(AbstractWidget $tag, Renderer $renderer)
    {
        $labelTag = $tag->getLabel();
        if ($labelTag) {
            $newLabel = $this->getStringTranslation($labelTag->getContent()[0], $renderer->getOption('language'));
            $labelTag->setContent($newLabel);
        }
    }

    protected function translateError(AbstractWidget $tag, Renderer $renderer)
    {
        $errorTag = $tag->getError();
        if ($errorTag) {
            $newError = $this->getErrorMessageTranslation($errorTag->getContent()[0], $renderer->getOption('language'));
            $errorTag->setContent($newError);
        }
    }

    protected function translateHint(AbstractWidget $tag, Renderer $renderer)
    {
        $hintTag = $tag->getHint();
        if ($hintTag) {
            $newHint = $this->getStringTranslation($hintTag->getContent()[0], $renderer->getOption('language'));
            $hintTag->setContent($newHint);
        }
    }

    protected function translateInputOptions(AbstractWidget $tag, Renderer $renderer)
    {
        $input = $tag->getInput();
        if ($input && $input->get('_first_option')) {
            $newOption = $this->getStringTranslation($input->get('_first_option'), $renderer->getOption('language'));
            $input->set('_first_option', $newOption);
        }
        if ($input && $input->get('_options')) {
            $newOptions = [ ];
            foreach ($input->get('_options') as $k => $v) {
                $newOptions[$k] = $this->getStringTranslation($v, $renderer->getOption('language'));
            }
            $input->set('_options', $newOptions);
        }
    }

    protected function translateButton(Tag $tag, Renderer $renderer)
    {
        $tag->setContent($this->getStringTranslation($tag->getContent()[0], $renderer->getOption('language')));
    }
}