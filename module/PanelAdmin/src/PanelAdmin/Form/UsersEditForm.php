<?php

/**
 * Author: Stanisław Śledziona
 */
namespace PanelAdmin\Form;

use Zend\Form\Form;

class UsersEditForm extends Form
{
    public function __construct($name = null)
    {
        parent::__construct('Edit User');
        $this->setAttribute('method', 'post');
        $this->setAttribute('enctype','multipart/form-data');

        $this->add(array(
            'name' => 'id',
            'attributes' => array(
                'type'  => 'hidden',
            ),
        ));

        $this->add(array(
            'name' => 'name',
            'attributes' => array(
                'type'  => 'text',
                'placeholder' => 'Firstname',
                'class' => 'form-control col-xs-12 name',
            ),
            'options' => array(
                'label' => '',
            ),
        ));

        $this->add(array(
            'name' => 'surname',
            'attributes' => array(
                'type'  => 'text',
                'placeholder' => 'Lastname',
                'class' => 'form-control col-xs-12 surname',
            ),
            'options' => array(
                'label' => '',
            ),
        ));

        $this->add(array(
            'name' => 'dob',
            'attributes' => array(
                'type'  => 'Zend\Form\Element\DateTime',
                'placeholder' => 'Date of birth',
                'required' => false,
                'class' => 'form-control col-xs-12 dob',
            ),
            'options' => array(
                'label' => '',
                'format' => 'Y-m-d'
            ),
        ));

        $this->add(array(
            'name' => 'location',
            'attributes' => array(
                'type'  => 'Textarea',
                'placeholder' => 'Location',
                'class' => 'form-control col-xs-12 location',
            ),
            'options' => array(
                'label' => '',
            ),
        ));

        $this->add(array(
            'type' => 'Zend\Form\Element\Checkbox',
            'name' => 'isAdmin',
            'options' => array(
                'label' => 'is Admin?',
                'use_hidden_element' => true,
                'checked_value' => '1',
                'unchecked_value' => '0'
                )
            )
        );

        $this->add(array(
            'name' => 'avatarUrl',
            'attributes' => array(
                'type'  => 'hidden',
            ),
        ));

        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type'  => 'submit',
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