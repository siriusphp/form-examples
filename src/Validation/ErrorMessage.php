<?php

namespace Sirius\FormExamples\Validation;

class ErrorMessage extends \Sirius\Validation\ErrorMessage
{

    public function getTemplate()
    {
        return $this->template;
    }


    public function getVariables()
    {
        return $this->variables;
    }
}