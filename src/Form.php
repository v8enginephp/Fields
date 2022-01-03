<?php

namespace Module\Fields;

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
        listen('field.form.render', null, $this);

        if ($this->fields->filter(fn(Field $field) => @$field->getAttributes()['type'] == 'submit')->count() <= 0) {
            $this->fields['submit'] = input('submit', ['class' => 'btn btn-success'])->setValue(lang('submit', 'ارسال اطلاعات'));
        }

        if ($this->ajax)
            $this->submiter();

        return "<form {$this->attributes()}>{$this->fields}</form>";
    }

    /**
     * @return bool
     */
    public function isRow(): bool
    {
        return $this->row;
    }

    private function submiter()
    {
        $id = $this->attributes['id'] ?? $this->attributes['id'] = md5(uniqid());
        push("scripts", "<script>$('#{$id}').submit(function (e){e.preventDefault();formSubmit(this)})</script>");
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


    public function setAjax($situation = true)
    {
        $this->ajax = true;
        return $this;
    }
}