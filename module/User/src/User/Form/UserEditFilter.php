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
            'name'       => 'surname',
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
            'name'       => 'location',
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
                        'max'      => 255,
                    ),
                ),
            ),
        ));

    }
}