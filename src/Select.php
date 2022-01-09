<?php

namespace Rp76\Fields;

class Select extends Field
{
    protected mixed $options;

    /**
     * @param array|callable $options
     * @param array $attributes
     */
    public function __construct($options, array $attributes = [])
    {
        $this->options = $options;
        parent::__construct($attributes);
    }

    public function render(): ?string
    {
        $output = $this->label() . "<select {$this->attributes()}>";

        $this->options = is_callable($this->options) ? call_user_func($this->options) : $this->options;

        foreach ($this->options ?? [] as $option) {
            /**
             * @var $option Option
             */
            if ($this->isSelected($option->value))
                $option->attributes['selected'] = true;

            $output .= $option;
        }

        return $output . "</select>";
    }

    public function isSelected($val): bool
    {
        return ($val == $this->getValue() or (is_array($this->getValue()) and in_array($val, (array)$this->getValue())));
    }
}