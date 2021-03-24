<?php

namespace app\widgets;

use yii\widgets\ActiveField;

class MyActiveField extends ActiveField
{

    public $template = '{label} {input}<br />';

    public function init()
    {
        $this->options['tag'] = false;
        $this->inputOptions = [];
        parent::init();
    }

    public function label($label = null, $options = [])
    {
        if ($label === false) {
            $this->parts['{label}'] = '';
            return $this;
        }
        $this->parts['{label}'] = $this->model->getAttributeLabel($this->attribute);
        return $this;
    }

    public function textInput($options = [])
    {
        if($this->model->hasErrors($this->attribute)){
            if(!isset($options['class'])){
                $options['class'] = 'error';
            } else {
                $options['class'] = $options['class'] . ' error';
            }
        }
        return parent::textInput($options);
    }

    public function passwordInput($options = [])
    {
        if($this->model->hasErrors($this->attribute)){
            if(!isset($options['class'])){
                $options['class'] = 'error';
            } else {
                $options['class'] = $options['class'] . ' error';
            }
        }
        return parent::passwordInput($options);
    }

    public function textarea($options = [])
    {
        if($this->model->hasErrors($this->attribute)){
            if(!isset($options['class'])){
                $options['class'] = 'error';
            } else {
                $options['class'] = $options['class'] . ' error';
            }
        }
        return parent::textarea($options);
    }

}