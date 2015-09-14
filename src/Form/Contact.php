<?php

namespace Sirius\FormExamples\Form;

use Sirius\Input\Specs;

class Contact extends \Sirius\Input\InputFilter
{

    public function init()
    {
        parent::init();
        $this->addElement('name', [
            Specs::LABEL      => 'Your name',
            Specs::FILTERS    => [
                'stringtrim'
            ],
            Specs::VALIDATION => [
                'required'
            ]
        ]);

        $this->addElement('email', [
            Specs::WIDGET     => 'email',
            Specs::LABEL      => 'Your email',
            Specs::FILTERS    => [
                'stringtrim'
            ],
            Specs::VALIDATION => [
                'required',
                'email'
            ]
        ]);

        $this->addElement('phone', [
            Specs::LABEL   => 'Phone',
            Specs::FILTERS => [
                'stringtrim'
            ]
        ]);

        $this->addElement('source', [
            Specs::LABEL   => 'Where did you hear about us?',
            Specs::WIDGET  => 'radioset',
            Specs::OPTIONS => [
                'search_engine' => 'Search engine (Google, Yahoo, Bing)',
                'newsletter'    => 'Newsletter',
                'friend'        => 'Friend',
                'unknown'       => 'Don\'t recall',
            ]
        ]);

        $this->addElement('message', [
            Specs::WIDGET     => 'textarea',
            Specs::LABEL      => 'Message',
            Specs::HINT       => 'Please be as explicit as possible',
            Specs::ATTRIBUTES => [ 'rows' => 5 ],
            Specs::FILTERS    => [
                'stringtrim'
            ],
            Specs::VALIDATION => [
                'required',
                [ 'minlength', [ 'min' => 10 ] ]
            ]
        ]);
        $this->addElement('buttons', [
            Specs::TYPE => 'group'
        ]);

        $this->addElement('submit', [
            Specs::WIDGET => 'submit',
            Specs::LABEL  => 'Send inquiry',
            Specs::GROUP  => 'buttons'
        ]);
        $this->addElement('reset', [
            Specs::WIDGET => 'reset',
            Specs::LABEL  => 'Reset',
            Specs::GROUP  => 'buttons'
        ]);
    }


}