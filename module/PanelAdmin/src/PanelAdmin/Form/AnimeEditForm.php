<?php
/**
 * Author: Stanisław Śledziona
 */

namespace PanelAdmin\Form;

use Zend\Form\Form;

class AnimeEditForm extends Form
{
    public function __construct($name = null)
    {
        parent::__construct('Edit Anime');
        $this->setAttribute('method', 'post');
        $this->setAttribute('enctype', 'multipart/form-data');

        $this->add(array(
            'name' => 'id',
            'attributes' => array(
                'type' => 'hidden',
            ),
        ));

        $this->add(array(
            'name' => 'title',
            'attributes' => array(
                'type' => 'text',
                'placeholder' => 'Title',
                'class' => 'form-control col-xs-12 title',
            ),
            'options' => array(
                'label' => '',
            ),
        ));

        $this->add(array(
            'name' => 'synopsis',
            'attributes' => array(
                'type' => 'Zend\Form\Element\Textarea',
            ),
            'options' => array(
                'label' => 'Synopsis',
            ),
        ));

        $this->add(array(
            'name' => 'tags',
            'attributes' => array(
                'type' => 'text',
                'placeholder' => 'Tags',
                'class' => 'form-control col-xs-12 tags',
            ),
            'options' => array(
                'label' => '',
            ),
        ));

        $this->add(array(
            'name' => 'prequel',
            'attributes' => array(
                'type' => 'text',
                'placeholder' => 'Prequel',
                'class' => 'form-control col-xs-12 prequel',
            ),
            'options' => array(
                'label' => '',
            ),
        ));

        $this->add(array(
            'name' => 'sequel',
            'attributes' => array(
                'type' => 'text',
                'placeholder' => 'Sequel',
                'class' => 'form-control col-xs-12 sequel',
            ),
            'options' => array(
                'label' => '',
            ),
        ));

        $this->add(array(
            'name' => 'spinoff',
            'attributes' => array(
                'type' => 'text',
                'placeholder' => 'Spinoff',
                'class' => 'form-control col-xs-12 spinoff',
            ),
            'options' => array(
                'label' => '',
            ),
        ));

        $this->add(array(
            'name' => 'episodes',
            'attributes' => array(
                'type' => 'Zend\Form\Element\Number',
                'min' => '0',
                'max' => '2000',
                'step' => '1',
            ),
            'options' => array(
                'label' => 'Episodes',
            ),
        ));
    }
}