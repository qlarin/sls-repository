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
            'type' => 'text',
            'attributes' => array(
                'placeholder' => 'Title',
                'class' => 'form-control col-xs-4 title',
            ),
            'options' => array(
                'label' => 'Title',
            ),
        ));

        $this->add(array(
            'name' => 'synopsis',
            'type' => 'Zend\Form\Element\Textarea',
            'attributes' => array(
                'class' => 'form-control',
                'rows' => '6',
                'cols' => '12',
            ),
            'options' => array(
                'label' => 'Synopsis',
            ),
        ));

        $this->add(array(
            'name' => 'tags',
            'type' => 'text',
            'attributes' => array(
                'placeholder' => 'Tags',
                'class' => 'form-control col-xs-12 tags',
            ),
            'options' => array(
                'label' => 'Tags',
            ),
        ));

        $this->add(array(
            'name' => 'prequel',
            'type' => 'text',
            'attributes' => array(
                'placeholder' => 'Prequel',
                'class' => 'form-control col-xs-3 prequel',
            ),
            'options' => array(
                'label' => 'Prequel',
            ),
        ));

        $this->add(array(
            'name' => 'sequel',
            'type' => 'text',
            'attributes' => array(
                'placeholder' => 'Sequel',
                'class' => 'form-control col-xs-3 sequel',
            ),
            'options' => array(
                'label' => 'Sequel',
            ),
        ));

        $this->add(array(
            'name' => 'spinoff',
            'type' => 'text',
            'attributes' => array(
                'placeholder' => 'Spinoff',
                'class' => 'form-control col-xs-3 spinoff',
            ),
            'options' => array(
                'label' => 'Spinoff',
            ),
        ));

        $this->add(array(
            'name' => 'episodes',
            'type' => 'Zend\Form\Element\Number',
            'attributes' => array(
                'class' => 'form-control',
                'min' => '0',
                'max' => '2000',
                'step' => '1',
            ),
            'options' => array(
                'label' => 'Episodes',
            ),
        ));

        $this->add(array(
            'name' => 'imageUrl',
            'type' => 'Zend\Form\Element\File',
            'attributes' => array(
                'id' => 'imageUrl',
            ),
            'options' => array(
                'label' => 'Image Upload',
                'label_attributes' => array (
                    'class' => 'col-sm-3 text-right',
                ),
            ),
        ));

        $this->add(array(
            'name' => 'submit',
            'type'  => 'submit',
            'attributes' => array(
                'value' => 'Submit'
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