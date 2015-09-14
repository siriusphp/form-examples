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
use Sirius\FormRenderer\Widget\Group;
use Sirius\FormRenderer\Widget\Reset;
use Sirius\FormRenderer\Widget\Submit;
use Sirius\Html\Tag;
use Sirius\Html\Tag\Input;
use Sirius\Input\Specs;


/**
 * Depending on the complexity of you custom widgets this kind of decorator may require more work.
 */
class Bootstrap
{

    public function __invoke(Tag $tag, Renderer $renderer)
    {
        $this->addButtonClass($tag);
        $this->addWidgetClass($tag);
        if ($tag instanceof AbstractWidget) {
            $this->addLabelClass($tag);
            $this->addInputClass($tag);
            $this->addErrorClass($tag);
        }

        return $tag;
    }

    protected function addLabelClass(Tag $tag)
    {
        if ($tag->getLabel()) {
            $tag->getLabel()->addClass('form-label');
        }
    }

    protected function addInputClass(Tag $tag)
    {
        $input = $tag->getInput();
        // if input but not radioset or checboxset
        if ($input instanceof Input && ! $input instanceof Radioset && ! $input instanceof Checkboxset) {
            $input->addClass('form-control');
        } elseif ($input instanceof Radioset || $input instanceof Checkboxset) {
            // for items with less then 4 items the list is inline
            if (4 > count($tag->get('_element')->get(Specs::OPTIONS))) {
                $input->addClass('list-unstyled');
            } else {
                $input->addClass('list-inline');
            }
        }
    }

    protected function addButtonClass(Tag $tag)
    {
        if ($tag instanceof Button) {
            $tag->addClass('btn');
        }
        if ($tag instanceof Submit) {
            $tag->addClass('btn-primary');
        }
        if ($tag instanceof Reset) {
            $tag->addClass('btn-link');
        }
    }

    protected function addErrorClass(Tag $tag)
    {
        if ($tag->getError()) {
            $tag->getError()->addClass('alert');
            $tag->getError()->addClass('alert-danger');
        }
    }

    protected function addWidgetClass(Tag $tag)
    {
        if ($tag instanceof AbstractWidget && ! $tag instanceof Form && ! $tag instanceof Group) {
            $tag->addClass('form-group');
        }
    }
}