<?php
/**
 * Author: Stanisław Śledziona
 */

namespace User\Form;


use Zend\InputFilter\InputFilter;

class UserEditFilter extends InputFilter
{
    public function __construct()
    {
        $this->add(array(
            'name'       => 'name',
            'required' => false,
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
            'name'       => 'surname',
            'required' => false,
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
            'name'       => 'dob',
            'required' => false,
            'filters'    => array(
                array(
                    'name' => 'StringTrim',
                ),
            ),
            'validators' => array(
                array(
                    'name'    => 'StringLength',
                    'options' => array(
                        'encoding' => 'UTF-8',
                        'min'      => 0,
                        'max'      => 20,
                    ),
                ),
                array(
                    'name' => 'Date',
                    'options' => array(
                        'format' => 'Y-m-d',
                    ),
                ) ,
            ),
        ));

        $this->add(array(
            'name'       => 'location',
            'required' => false,
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
                        'max'      => 255,
                    ),
                ),
            ),
        ));

        $this->add(array(
            'name' => 'avatarUrl',
            'required' => false,
            'filters' => array(
                array(
                    'name' => 'filerenameupload',
                    'options' => array(
                        'target' => 'public/img/user/',
                        'use_upload_name' => true,
                        'randomize' => true,
                    ),
                ),
            ),
            'validators' => array(
                array(
                    'name' => 'NotEmpty',
                ),
                array(
                    'name' => 'fileextension',
                    'options' => array(
                        'extension' => array('jpg', 'jpeg', 'png', 'svg'),
                    ),
                ),
            ),
        ));
    }
}