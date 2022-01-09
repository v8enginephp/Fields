<?php

namespace Fields;

use Rp76\Fields\Date;
use Rp76\Fields\FieldCollection;
use Rp76\Fields\Form;
use Rp76\Fields\Input;
use Rp76\Fields\MultipleSelect;
use Rp76\Fields\Option;
use Rp76\Fields\Select;
use Rp76\Fields\Textarea;

function collect(array $fields = []): FieldCollection
{
    return new FieldCollection($fields);
}

function multiple_select($options, $attributes = [], $json = true): MultipleSelect
{
    return new MultipleSelect($options, $attributes, $json);
}

function select($options, $attributes = []): Select
{
    return new Select($options, $attributes);
}


function input($type = 'text', $attributes = []): Input
{
    return new Input($type, $attributes);
}

function textarea($attributes = []): Textarea
{
    return new Textarea($attributes);
}

function option($label, $value = null, $attributes = []): Option
{
    return new Option($value, $label, $attributes);
}

function form($fields, $action, $method = "POST", $attributes = []): Form
{
    $attributes = array_merge(['action' => $action, 'method' => $method], $attributes);
    return new Form($fields, $attributes);
}

function date($attributes = []): Date
{
    return new Date($attributes);
}