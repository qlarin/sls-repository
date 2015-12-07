<?php
/**
 * Author: Stanisław Śledziona
 */

namespace User\Form;

use Zend\Form\Form;
use Zend\Form\Element;
use Zend\Captcha;

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
                'placeholder' => 'Your name',
                'class' => 'form-control col-xs-12 username',
            ),
            'options' => array(
                'label' => '',
            ),
        ));

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
            'name' => 'confirmPassword',
            'attributes' => array(
                'type'  => 'Password',
                'required' => 'required',
                'placeholder' => 'Confirm password',
                'class' => 'form-control col-xs-12 confirmPassword',
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
            'type' => 'Zend\Form\Element\Captcha',
            'name' => 'captcha',
            'options' => array(
                'label' => 'Please verify you are human',
                'captcha' => new Captcha\Dumb(),
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