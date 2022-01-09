<?php

namespace Rp76\Fields;

class Input extends Field
{
    /**
     * @param string $type
     * @param array $attributes
     */
    public function __construct($type = 'text', array $attributes = [])
    {
        $attributes['type'] = $type;

        parent::__construct($attributes);
    }

    /**
     * @return string|null
     */
    public function render(): ?string
    {
        return $this->label() . "<input {$this->attributes()}>";
    }

    /**
     * @param $value
     * @return Input
     */
    public function setValue($value): Input
    {
        $this->attributes['value'] = $value;
        return parent::setValue($value);
    }
}