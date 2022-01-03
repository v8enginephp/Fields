<?php

namespace Module\Fields;

use App\Exception\V8Exception;
use App\Helper\Submitter;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use function Fields\form;

class FieldCollection extends Collection
{
    public function render()
    {
        $this->each(function (Field $field) use (&$o) {
            return $o .= $field;
        });
        return $o ?? "";
    }

    public function offsetSet($key, $value)
    {
        if ($value instanceof Field) {
            $attrs = $value->getAttributes();

            if (!isset($attrs['name']))
                $attrs['name'] = $key;


            if (!isset($attrs['id']))
                $attrs['id'] = $key;

            if (isset($attrs['label']))
                $value->setLabel($attrs['label']);

            $value->setAttributes($attrs);

            if (method_exists($value, 'init'))
                $value->init();

            parent::offsetSet($key, $value);
        } else
            throw new V8Exception('fields.invalid.field', $key . " Must Be Instance of " . Field::class);
    }

    public function process(Request $request, $event = null)
    {
        $data = validate($request->all(), $this->map(function (Field $field) {
            $rules = $field->getRules();
            if ($rules == [])
                $rules = ['nullable'];
            return $rules;
        })->toArray());

        foreach ($data->getData() as $key => $input) {
            $field = @$this[$key];

            /**
             * @var $field Field
             */
            if ($field)
                $field->save($input);
        }

        listen($event ?? 'fields.collection.onsave', null, $this);

        return filter($event ?? 'fields.collection.onsave', Submitter::refresh());
    }

    public function form($action, $method = "POST", $attributes = [])
    {
        return form($this, $action, $method, $attributes);
    }

    public function __toString()
    {
        return $this->render();
    }
}