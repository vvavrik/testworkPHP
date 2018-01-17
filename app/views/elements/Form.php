<?php

namespace views\elements;

class Form {

    public $formName;
    public $actionFile;
    public $actionKey;
    public $html;

    public function __construct($formName, $action, $title, $text, $submitButtonTitle) {
        $this->submitButtonTitle = $submitButtonTitle;
        $html = '<FORM name="'.$formName.'" method="POST" action="'.$action.'" enctype="multipart/form-data">';
        if (!empty($title)) {
            $html .= '<h2>'.$title.'</h2>';
        }
        if (!empty($text)) {
            $html .= '<span>'.$text.'</span>';
        }
        $this->html = $html;
    }

    public function addInput($name, $title, $type, $value, $minLength, $maxLength, $flag) {
        $html = '<DIV><INPUT type="'.$type.'" name="'.$name.'" value="'.$value.'" ';
        if ((integer)$minLength > 0) {
            $html .= 'minlength='.(integer)$minLength.' ';
        }

        if ((integer)$maxLength > 0) {
            $html .= 'maxlength='.(integer)$maxLength.' ';
        }

        if ($flag == 'required') {
            $html .= 'required ';
        }
        elseif ($flag == 'readonly') {
            $html .= 'readonly ';
        }
        elseif ($flag == 'required readonly') {
            $html .= 'required readonly ';
        }
        else {}
        $html .= '><LABEL for="'.$name.'">'.$title.'</LABEL></DIV>';
        $this->html .= $html;
    }

    public function addSelect($name, $title, $value_title, $selected) {
        $html = '<DIV><SELECT name="'.$name.'">';
        foreach ($value_title as $key => $value) {
            $html .= '<OPTION value = '.$key;
            if ($selected == $key)
            {
                $html .= ' SELECTED ';
            }
            $html .= '>'.$value.'</OPTION>';
        }
        $html .= '</SELECT>';
        $html .= '<LABEL for = "'.$name.'">'.$title.'</LABEL>';
        $html .= '</DIV>';
        $this->html .= $html;
    }

    public function addSelectOptgroup($name, $content) {
        $html = '<DIV><SELECT name="'.$name.'">';
        $html .= $content;
        $html .= '</SELECT></DIV>';
        $this->html .= $html;
    }

    public function getForm() {
        $this->html .='<INPUT type="submit" value="'.$this->submitButtonTitle.'"></FORM>';
        return $this->html;
    }

    public function makeOptgroup($optLabel, $content) {
        $html  = '<OPTGROUP LABEL="'.$optLabel.'">';
        $html .= $content;
        $html .= '</OPTGROUP>';
        return $html;
    }

    public function makeOption($value, $title, $selected) {
        $html = '<OPTION value = '.$value;
        if ($selected == $value) {
            $html .= ' SELECTED ';
        }
        $html .= '>'.$title.'</OPTION>';
        return $html;
    }
}
?>
