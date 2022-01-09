<?php

namespace Rp76\Fields;

class MultipleSelect extends Select
{
    public function __construct($options, $attributes = [])
    {
        $attributes = array_merge($attributes, ['multiple' => true]);
        parent::__construct($options, $attributes);
        $this->onShow(fn($value) => json_decode($value) ?? $value);
        $this->onProcess(fn($value) => json_encode($value));
    }

    public function init()
    {
        $this->setName();
    }

    public function setName()
    {
        $name = $this->getName();
        $this->attributes['name'] = str_replace(["[", "]"], '', $name) . "[]";
    }
}