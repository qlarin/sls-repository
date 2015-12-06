<?php
/**
 * Author: Stanisław Śledziona
 */

namespace User\Form;

use Zend\InputFilter\InputFilter;

class RegisterFilter extends InputFilter
{
    public function __construct()
    {
        $this->add(array(
            'name'       => 'email',
            'required'   => true,
            'validators' => array(
                array(
                    'name'    => 'EmailAddress',
                    'options' => array(
                        'domain' => true,
                    ),
                ),
            ),
        ));
        $this->add(array(
            'name'       => 'username',
            'required'   => true,
            'filters'    => array(
                array(
                    'name'    => 'StripTags',
                ),
            ),
            'validators' => array(
                array(
                    'name'    => 'StringLength',
                    'options' => array(
                        'encoding' => 'UTF-8',
                        'min'      => 4,
                        'max'      => 100,
                    ),
                ),
            ),
        ));
        $this->add(array(
            'name'       => 'password',
            'required'   => true,
            'filters'    => array(
                array(
                    'name'    => 'StringTrim',
                ),
            ),
            'validators' => array(
                array(
                    'name'    => 'StringLength',
                    'options' => array(
                        'encoding' => 'UTF-8',
                        'min'      => 4,
                        'max'      => 100,
                    ),
                ),
            ),
        ));
        $this->add(array(
            'name'       => 'confirmPassword',
            'required'   => true,
            'filters'    => array(
                array(
                    'name'    => 'StringTrim',
                ),
            ),
            'validators' => array(
                array(
                    'name'    => 'Identical',
                    'options' => array(
                        'token' => 'password',
                    ),
                ),
            ),
        ));
    }
}