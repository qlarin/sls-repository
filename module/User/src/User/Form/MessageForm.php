<?php
/**
 * Author: Stanisław Śledziona
 */

namespace User\Form;

use Zend\Form\Form;

class MessageForm extends Form
{
    public function __construct($name = null)
    {
        parent::__construct('New ticket');
        $this->setAttribute('method', 'post');
        $this->setAttribute('enctype', 'multipart/form-data');

        $this->add(array(
            'name' => 'id',
            'attributes' => array(
                'type' => 'hidden',
            ),
        ));

        $this->add(array(
            'name' => 'authorId',
            'attributes' => array(
                'type' => 'hidden',
            ),
        ));

        $this->add(array(
            'name' => 'userId',
            'type' => 'Zend\Form\Element\Select',
            'attributes' => array(
                'class' => 'form-control',
            ),
            'options' => array(
                'label' => 'To:',
                'empty_option' => 'Please choose an admin to contact',
                'value_options' => array(
                    'Admin' => 'Admin',
                    'Second' => 'Second',
                ),
            ),
        ));

        $this->add(array(
            'name' => 'body',
            'type' => 'Zend\Form\Element\Textarea',
            'attributes' => array(
                'class' => 'form-control',
                'rows' => '6',
                'cols' => '12',
            ),
            'options' => array(
                'label' => 'Message:',
            ),
        ));

        $this->add(array(
            'name' => 'topic',
            'attributes' => array(
                'type'  => 'Text',
                'class' => 'form-control',
            ),
            'options' => array(
                'label' => 'Topic:',
            ),
        ));

        $this->add(array(
            'name' => 'submit',
            'type'  => 'submit',
            'attributes' => array(
                'value' => 'Submit'
            ),
        ));

        $this->add(array(
            'type' => 'Zend\Form\Element\Csrf',
            'name' => 'csrf',
            'options' => array(
                'csrf_options' => array(
                    'timeout' => 600
                )
            )
        ));
    }
}