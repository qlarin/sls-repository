<?php
/**
 * Author: Stanisław Śledziona
 */

namespace Anime\Form;

use Zend\Form\Form;

class AddAnimeToListForm extends Form
{
    public function __construct($name = null)
    {
        parent::__construct('Add anime to list');
        $this->setAttribute('method', 'post');
        $this->setAttribute('enctype', 'multipart/form-data');

        $this->add(array(
            'name' => 'id',
            'attributes' => array(
                'type' => 'hidden',
            ),
        ));

        $this->add(array(
            'name' => 'status',
            'type' => 'Zend\Form\Element\Select',
            'attributes' => array(
                'class' => 'form-control',
            ),
            'options' => array(
                'label' => 'Status',
                'value_options' => array(
                    '0' => 'Plan to watch',
                    '1' => 'Watching',
                    '2' => 'Finished',
                    '3' => 'On hold',
                    '4' => 'Dropped',
                ),
            ),
        ));

        $this->add(array(
            'name' => 'rating',
            'type' => 'Zend\Form\Element\Number',
            'attributes' => array(
                'class' => 'form-control',
                'min' => '0',
                'max' => '10',
                'step' => '1',
            ),
            'options' => array(
                'label' => 'Rating',
            ),
        ));

        $this->add(array(
            'name' => 'episode',
            'type' => 'Zend\Form\Element\Number',
            'attributes' => array(
                'class' => 'form-control',
                'min' => '0',
                'max' => '2000',
                'step' => '1',
            ),
            'options' => array(
                'label' => 'Episode',
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