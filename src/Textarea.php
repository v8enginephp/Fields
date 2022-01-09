<?php

namespace Rp76\Fields;

class Textarea extends Field
{
    public function render(): ?string
    {
        return $this->label() . "<textarea {$this->attributes()}>{$this->getValue()}</textarea>";
    }
}