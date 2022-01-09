<?php

namespace Rp76\Fields;

class Date extends Input
{
    protected array $rules = ['date'];

    public function __construct($attributes = [])
    {
        $this->onProcess(fn($value) => trim($value) == '' ? null : $value);
        parent::__construct('date', $attributes);
    }
}