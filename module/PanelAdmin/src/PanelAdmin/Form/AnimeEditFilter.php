<?php
/**
 * Author: Stanisław Śledziona
 */

namespace PanelAdmin\Form;

use Zend\InputFilter\InputFilter;

class AnimeEditFilter extends InputFilter
{
    public function __construct()
    {
        $this->add(array(
            'name' => 'title',
            'required' => true,
            'filters' => array(
                array(
                    'name' => 'StripTags',
                ),
            ),
            'validators' => array(
                array(
                    'name' => 'StringLength',
                    'options' => array(
                        'encoding' => 'UTF-8',
                        'min' => 1,
                        'max' => 100,
                    ),
                ),
            ),
        ));

        $this->add(array(
            'name' => 'synopsis',
            'required' => false,
            'filters' => array(
                array(
                    'name' => 'StripTags',
                ),
            ),
            'validators' => array(
            ),
        ));

        $this->add(array(
            'name' => 'tags',
            'required' => false,
            'filters' => array(
                array(
                    'name' => 'StripTags',
                ),
            ),
            'validators' => array(
                array(
                    'name' => 'StringLength',
                    'options' => array(
                        'encoding' => 'UTF-8',
                    ),
                ),
            ),
        ));

        $this->add(array(
            'name' => 'prequel',
            'required' => false,
            'filters' => array(
                array(
                    'name' => 'StripTags',
                ),
            ),
            'validators' => array(
                array(
                    'name' => 'StringLength',
                    'options' => array(
                        'encoding' => 'UTF-8',
                    ),
                ),
            ),
        ));

        $this->add(array(
            'name' => 'sequel',
            'required' => false,
            'filters' => array(
                array(
                    'name' => 'StripTags',
                ),
            ),
            'validators' => array(
                array(
                    'name' => 'StringLength',
                    'options' => array(
                        'encoding' => 'UTF-8',
                    ),
                ),
            ),
        ));

        $this->add(array(
            'name' => 'spinoff',
            'required' => false,
            'filters' => array(
                array(
                    'name' => 'StripTags',
                ),
            ),
            'validators' => array(
                array(
                    'name' => 'StringLength',
                    'options' => array(
                        'encoding' => 'UTF-8',
                    ),
                ),
            ),
        ));

        $this->add(array(
            'name' => 'episodes',
            'required' => false,
            'filters' => array(
            ),
            'validators' => array(
            ),
        ));

        $this->add(array(
            'name' => 'imageUrl',
            'required' => false,
            'filters' => array(
                array(
                    'name' => 'filerenameupload',
                    'options' => array(
                        'target' => 'public/img/anime/',
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
                        'extension' => array('jpg', 'jpeg', 'png'),
                    ),
                ),
            ),
        ));
    }
}