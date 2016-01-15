<?php
/**
 * Author: Stanisław Śledziona
 */

namespace Anime\Form;

use Zend\Form\Form;

class AddCommentForm extends Form
{
    public function __construct($name = null)
    {
        parent::__construct('Add comment');
        $this->setAttribute('method', 'post');
        $this->setAttribute('enctype', 'multipart/form-data');
    }
}