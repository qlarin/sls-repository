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
            'name' => 'name',
            'attributes' => array(
                'type'  => 'text',
                'required' => 'required',
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
                'required' => 'required',
                'placeholder' => 'Your lastname',
                'class' => 'form-control col-xs-12 lastname',
            ),
            'options' => array(
                'label' => '',
            ),
        ));

        $this->add(array(
            'name' => 'dob',
            'attributes' => array(
                'type'  => 'Date',
                'required' => 'required',
                'placeholder' => 'Your date of birth',
                'min'  => '1912-01-01',
                'max'  => '2912-01-01',
                'step' => '1',
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
                'required' => 'required',
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
                'type'  => 'Submit',
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