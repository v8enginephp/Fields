<?php

namespace Module\Fields;

class Label extends Field
{
    protected bool $formControl = false;
    /**
     * @param $body
     * @param array $attributes
     */
    public function __construct($body, $attributes = [])
    {
        $this->setValue($body);
        parent::__construct($attributes);
    }

    public function render(): ?string
    {
        listen('field.label.render', null, $this);
        return "<label {$this->attributes()}>{$this->getValue()}</label>";
    }
}