<?php

/**
 * Author: Stanisław Śledziona
 */

namespace User\Form;

use Zend\Form\Form;

class LoginForm extends Form
{
    public function __construct($name = null)
    {
        parent::__construct('Login');
        $this->setAttribute('method', 'post');
        $this->setAttribute('enctype','multipart/form-data');

        $this->add(array(
            'name' => 'email',
            'attributes' => array(
                'type'  => 'Email',
                'required' => 'required',
                'placeholder' => 'Your email',
                'class' => 'form-control col-xs-12 email',
            ),
            'options' => array(
                'label' => '',
            ),
        ));

        $this->add(array(
            'name' => 'password',
            'attributes' => array(
                'type'  => 'Password',
                'required' => 'required',
                'placeholder' => 'Your password',
                'class' => 'form-control col-xs-12 password',
            ),
            'options' => array(
                'label' => '',
            ),
        ));

        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'Login'
            ),
        ));
    }

}