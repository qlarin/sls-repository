<?php
/**
 * Author: Stanisław Śledziona
 */

namespace User\Form;

use Zend\Form\Form;

class RegisterForm extends Form
{
    public function __construct($name = null)
    {
        parent::__construct('Register');
        $this->setAttribute('method', 'post');
        $this->setAttribute('enctype','multipart/form-data');

        $this->add(array(
            'name' => 'username',
            'attributes' => array(
                'type'  => 'text',
                'required' => 'required',
                'placeholder' => 'Your name'
            ),
            'options' => array(
                'label' => '',
            ),
        ));

        $this->add(array(
            'name' => 'email',
            'attributes' => array(
                'type'  => 'email',
                'required' => 'required',
                'placeholder' => 'Email',
                'class' => 'form-control col-xs-12 email',
            ),
            'options' => array(
                'label' => '',
            ),
        ));

        $this->add(array(
            'name' => 'password',
            'attributes' => array(
                'type'  => 'password',
                'required' => 'required',
                'placeholder' => 'Your password'
            ),
            'options' => array(
                'label' => '',
            ),
        ));
        $this->add(array(
            'name' => 'confirmPassword',
            'attributes' => array(
                'type'  => 'password',
                'required' => 'required',
                'placeholder' => 'Password'
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
    }
}