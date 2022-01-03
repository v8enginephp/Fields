<?php

namespace Fields;

use Module\Fields\Date;
use Module\Fields\FieldCollection;
use Module\Fields\Form;
use Module\Fields\Input;
use Module\Fields\MultipleSelect;
use Module\Fields\Option;
use Module\Fields\Select;
use Module\Fields\Textarea;

function collect(array $fields = [])
{
    return new FieldCollection($fields);
}

function multiple_select($options, $attributes = [], $json = true)
{
    return new MultipleSelect($options, $attributes, $json);
}

function select($options, $attributes = [])
{
    return new Select($options, $attributes);
}


function input($type = 'text', $attributes = [])
{
    return new Input($type, $attributes);
}

function textarea($attributes = [])
{
    return new Textarea($attributes);
}

function option($label, $value = null, $attributes = [])
{
    return new Option($value, $label, $attributes);
}

function form($fields, $action, $method = "POST", $attributes = [])
{
    $attributes = array_merge(['action' => $action, 'method' => $method], $attributes);
    return new Form($fields, $attributes);
}

function date($attributes = [])
{
    return new Date($attributes);
}