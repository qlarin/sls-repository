<?php
/**
 * Author: Stanisław Śledziona
 */

namespace User\Form;

use Zend\InputFilter\InputFilter;

class MessageFilter extends InputFilter
{
    public function __construct()
    {
        $this->add(array(
            'name' => 'body',
            'required' => true,
            'filters' => array(
                array(
                    'name' => 'StripTags',
                ),
            ),
            'validators' => array(
            ),
        ));

        $this->add(array(
            'name' => 'topic',
            'required' => true,
            'filters' => array(
                array(
                    'name' => 'StripTags',
                ),
            ),
            'validators' => array(
            ),
        ));

        $this->add(array(
            'name' => 'userId',
            'required' => true,
            'filters' => array(
            ),
            'validators' => array(
            ),
        ));
    }
}