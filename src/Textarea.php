<?php

namespace Module\Fields;

class Textarea extends Field
{
    public function render(): ?string
    {
        listen('field.textarea.render', null, $this);
        return $this->label() . "<textarea {$this->attributes()}>{$this->getValue()}</textarea>";
    }
}