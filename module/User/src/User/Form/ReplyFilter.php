<?php
/**
 * Author: Stanisław Śledziona
 */

namespace User\Form;

use Zend\InputFilter\InputFilter;

class ReplyFilter extends InputFilter
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
    }
}