<?php

namespace Rp76\Fields;

class Label extends Field
{
    protected bool $formControl = false;
    /**
     * @param $body
     * @param array $attributes
     */
    public function __construct($body, array $attributes = [])
    {
        $this->setValue($body);
        parent::__construct($attributes);
    }

    public function render(): ?string
    {
        return "<label {$this->attributes()}>{$this->getValue()}</label>";
    }
}