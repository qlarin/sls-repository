<?php
/**
 * Author: Stanisław Śledziona
 */

namespace Anime\Form;

use Zend\Form\Form;

class AnimeSearchForm extends Form
{
    public function __construct($name = null)
    {
        parent::__construct('Search');
        $this->setAttribute('method', 'post');
        $this->setAttribute('enctype', 'multipart/form-data');

        $this->add(array(
            'name' => 'input',
            'attributes' => array(
                'type'  => 'Text',
                'class' => 'form-control',
            ),
            'options' => array(
                'label' => '',
            ),
        ));

        $this->add(array(
            'name' => 'submit',
            'type'  => 'submit',
            'attributes' => array(
                'value' => 'Search anime',
                'class' => 'btn btn-default'
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