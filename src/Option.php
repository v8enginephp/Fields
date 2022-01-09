<?php

namespace Rp76\Fields;

class Option extends Field
{
    protected bool $formGroup = false;
    protected bool $formControl = false;

    public function __construct($value, $label, $attributes = [])
    {
        $this->setLabel($label);
        $this->setValue($value);
        parent::__construct($attributes);
    }

    public function render(): ?string
    {
        return "<option {$this->attributes()} value='{$this->getValue()}'>{$this->getLabel()}</option>";
    }

    public function setLabel($label): Option
    {
        $this->label = $label;
        return $this;
    }
}