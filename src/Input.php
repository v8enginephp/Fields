<?php

namespace Module\Fields;

class Input extends Field
{
    /**
     * @param string $type
     * @param array $attributes
     */
    public function __construct($type = 'text', $attributes = [])
    {
        $attributes['type'] = $type;

        parent::__construct($attributes);
    }

    /**
     * @return string|null
     */
    public function render(): ?string
    {
        listen('field.input.render', null, $this);
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