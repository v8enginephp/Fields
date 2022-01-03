<?php

namespace Module\Fields;

use App\Exception\V8Exception;
use Core\Model;
use Illuminate\Http\Request;
use function Fields\{collect, input};

trait HasForm
{
    private static array $fields;
    private static FieldCollection $collection;

    public static function getFields()
    {
        return self::$fields ?? self::$fields = self::getFormInputs();
    }

    private static function collect(): FieldCollection
    {
        if (isset(self::$collection))
            return self::$collection;

        $fields = collect();
        foreach (self::getFields() as $key => $field) {
            $fields[$key] = self::generateField($field);
        }
        return self::$collection = filter("field.generate." . static::class, $fields);
    }

    private static function generateField($field): Field
    {
        if ($field instanceof Field)
            return $field;

        if (is_array($field))
            return "";

        throw new V8Exception("field.notvalid", "field must be array or Field");
    }

    protected static function getFormInputs(): array
    {
        return [];
    }

    public static function form($action, $method = "POST")
    {
        return self::make(["action" => $action, "method" => $method]);
    }

    public function editForm($action, $method = "PUT")
    {
        self::collect();

        foreach (self::$collection as $key => $field) {
            /**
             * @var $field Field
             */
            $field->setValue($field->callShow($this->{$key}, $this) ?? $this->{$key});
        }
        $method = $this->method($method);

        return self::make(["action" => $action, "method" => $method], self::$collection);
    }

    private function method($method)
    {
        if (!in_array(strtoupper($method), ['GET', 'POST'])) {
            self::$collection['_method'] = input('hidden')->setValue($method);
            $method = "POST";
        }
        return $method;
    }

    public static function store(Request $request, $event = null)
    {
        $fields = self::collect();
        $data = [];

        $fields->each(function (Field $field) use (&$data) {
            $field->hasOnSave() ?: $field->onSave(function ($value, Field $field) use (&$data) {
                $data[$field->getName()] = $field->callProcess($value);
            });
        });
        $event = $event ?? static::class . '.onstore';

        $class = static::class;

        /**
         * @var $class Model
         */

        bind($event, function () use (&$data, $class) {
            $class::create($data);
        });

        return $fields->process($request, $event);
    }

    public function edit(Request $request, $event)
    {
        $fields = self::collect();
        $data = [];
        $fields->each(function (Field $field) use (&$data) {
            $field->hasOnSave() ?: $field->onSave(function ($value, Field $field) use (&$data) {
                $data[str_replace(["[", "]"], "", $field->getName())] = $field->callProcess($value);
            });
        });
        $event = $event ?? static::class . '.onupdate';

        $class = $this;

        bind($event, function () use (&$data, $class) {
            $class->update($data);
        });

        return $fields->process($request, $event);
    }

    private static function make($attributes = [], $fields = null): Form
    {
        return new Form($fields ?? self::collect(), $attributes);
    }
}