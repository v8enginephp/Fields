<?php

namespace Rp76\Fields;

use function Fields\input;

class Form extends Field
{
    protected bool $formGroup = false;
    protected bool $formControl = false;
    protected bool $row = true;
    private FieldCollection $fields;
    private bool $ajax = true;

    public function __construct(FieldCollection $fields, $attributes = [])
    {
        $this->fields = $fields;
        if (!isset($attributes['class']) and $this->row) {
            $attributes['class'] = 'row';
        }
        parent::__construct($attributes);

    }

    public function render(): ?string
    {
//        if ($this->fields->filter(fn(Field $field) => @$field->getAttributes()['type'] == 'submit')->count() <= 0) {
//            $this->fields['submit'] = input('submit', ['class' => 'btn btn-success'])->setValue('submit');
//        }

        return "<form {$this->attributes()}>{$this->fields}</form>";
    }

    /**
     * @return bool
     */
    public function isRow(): bool
    {
        return $this->row;
    }

    /**
     * @param bool $row
     * @return Form
     */
    public function setRow(bool $row): Form
    {
        $this->row = $row;
        return $this;
    }

    public function setAjax($situation = true): Form
    {
        $this->ajax = true;
        return $this;
    }
}