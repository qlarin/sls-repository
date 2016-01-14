<?php
/**
 * Author: Stanisław Śledziona
 */

namespace Anime\Form;

use Zend\InputFilter\InputFilter;

class AddAnimeToListFilter extends InputFilter
{
    public function __construct()
    {

        $this->add(array(
            'name' => 'status',
            'required' => true,
            'filters' => array(
            ),
            'validators' => array(
            ),
        ));

        $this->add(array(
            'name' => 'rating',
            'required' => false,
            'filters' => array(
            ),
            'validators' => array(
            ),
        ));

        $this->add(array(
            'name' => 'episode',
            'required' => true,
            'filters' => array(
            ),
            'validators' => array(
            ),
        ));
    }
}