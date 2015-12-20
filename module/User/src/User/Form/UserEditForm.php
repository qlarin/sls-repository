<?php
/**
 * Author: Stanisław Śledziona
 */

namespace User\Form;


use Zend\Form\Form;

class UserEditForm extends Form
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
                'placeholder' => 'Your firstname',
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
                'placeholder' => 'Your lastname',
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
                'placeholder' => 'Your date of birth',
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
                'placeholder' => 'Your location',
                'class' => 'form-control col-xs-12 location',
            ),
            'options' => array(
                'label' => '',
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