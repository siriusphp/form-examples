<?php

namespace Sirius\FormExamples\FormRenderer\Decorator;

use Sirius\FormRenderer\Renderer;
use Sirius\FormRenderer\Tag\Label;
use Sirius\FormRenderer\Widget\AbstractWidget;
use Sirius\FormRenderer\Widget\Form;
use Sirius\FormRenderer\Widget\Group;
use Sirius\Html\Tag;
use Sirius\Html\Tag\Input;
use Sirius\Input\Specs;


/**
 * This depends heavily on the form layout. If you already use a grid to display the form (eg: Wordpress edit post page)
 * some widgets may be displayed horizontally, others may not. You may not know the context of a widget (is it placed
 * inside a wide area or not?) you might need a more complex logic for a decorator or move the logic in the tag
 * renderer (eg: when you build the tag's children you add additional props to the children about the rendering context)
 */

class HorizontalForm
{

    public function __invoke(Tag $tag, Renderer $renderer)
    {
        if ($tag instanceof Form) {
            $tag->addClass('form-horizontal');
        }
        if ($tag instanceof AbstractWidget && ! $tag instanceof Group
            && $tag->getLabel() && $tag->getInput()
        ) {
            $tag->getLabel()->addClass('col-sm-3');
            $tag->getInput()->wrap('<div class="col-sm-9">', '</div>');
            if ($tag->getHint()) {
                $tag->getHint()->addClass('col-sm-9 col-sm-push-3');
            }
        }

        return $tag;
    }

}