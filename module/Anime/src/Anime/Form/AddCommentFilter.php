<?php
/**
 * Author: Stanisław Śledziona
 */

namespace Anime\Form;

use Zend\InputFilter\InputFilter;

class AddCommentFilter extends InputFilter
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