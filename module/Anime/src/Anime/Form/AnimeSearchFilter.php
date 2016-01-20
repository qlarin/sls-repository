<?php
/**
 * Author: Stanisław Śledziona
 */

namespace Anime\Form;

use Zend\InputFilter\InputFilter;

class AnimeSearchFilter extends InputFilter
{
    public function __construct()
    {
        $this->add(array(
            'name' => 'input',
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