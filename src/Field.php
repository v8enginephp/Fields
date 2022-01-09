<?php

namespace Rp76\Fields;

use Closure;

abstract class Field
{
    protected mixed $value;
    protected mixed $label;
    protected bool $formGroup = true;
    protected bool $formControl = true;
    protected array $rules = [];
    protected array $attributes = [];
    protected Closure $onSave;
    private Closure $onProcess;
    private Closure $onShow;

    public function __construct($attributes = [])
    {
        $this->attributes = $attributes;

        if (!isset($this->attributes['class']) and $this->formControl) {
            $this->attributes['class'] = 'form-control';
        }

    }

    abstract public function render(): ?string;

    public function attributes(): string
    {
        $result = "";

        foreach ($this->attributes as $key => $attribute) {
            $result .= "{$key}='{$attribute}' ";
        }
        return $result;
    }

    public function getRules()
    {
        if (@$this->getAttributes()['required'])
            $this->rules[] = 'required';
        return $this->rules;
    }

    /**
     * @return string
     */
    public function getValue()
    {
        return $this->value ?? "";
    }


    public function save($value)
    {
        if (isset($this->onSave)) {
            call_user_func($this->onSave, $value, $this);
        }

        Config::get($this->getName(), true)->update([
            Config::VALUE => $value
        ]);
    }

    public function hasOnSave()
    {
        return isset($this->onSave);
    }

    public function onProcess(callable $callable)
    {
        $this->onProcess = Closure::fromCallable($callable);
        return $this;
    }

    public function callProcess($value)
    {
        if (isset($this->onProcess))
            return call_user_func($this->onProcess, $value);
        return $value;
    }

    /**
     * @param callable $onSave
     * @return Field
     */
    public function onSave(callable $onSave): Field
    {
        $this->onSave = Closure::fromCallable($onSave);
        return $this;
    }


    public function onShow(callable $onShow)
    {
        $this->onShow = Closure::fromCallable($onShow);
        return $this;
    }

    public function getName()
    {
        return $this->getAttributes()['name'];
    }

    /**
     * @param $value
     * @return $this
     */
    public function setValue($value): Field
    {
        $this->value = $value;
        return $this;
    }

    public function __toString()
    {
        if ($this->isFormGroup())
            return "<div class='form-group " . (@$this->attributes['grid'] ?? 'col-md-12') . "'>{$this->render()}</div>";
        return $this->render();
    }

    /**
     * @return mixed
     */
    public function getLabel(): mixed
    {
        return $this->label;
    }

    /**
     * @param string|Label $label
     */
    public function setLabel($label): Field
    {
        $this->label = ($label instanceof Label) ? $label : new Label($label, ['for' => @$this->attributes['id']]);
        return $this;
    }

    public function label()
    {
        return isset($this->label) ? $this->label->render() : "";
    }

    /**
     * @return bool
     */
    public function isFormGroup(): bool
    {
        return $this->formGroup;
    }

    public function getAttributes()
    {
        return $this->attributes;
    }

    public function setAttributes(array $attributes)
    {
        $this->attributes = $attributes;
        return $this;
    }

    /**
     * @param bool $formGroup
     * @return $this
     */
    public function setFormGroup(bool $formGroup): Field
    {
        $this->formGroup = $formGroup;
        return $this;
    }

    /**
     * @param array $rules
     * @return Field
     */
    public function setRules(array $rules): Field
    {
        $this->rules = $rules;
        return $this;
    }

    public function callShow(...$args)
    {
        if (isset($this->onShow))
            return call_user_func($this->onShow, ...$args);
        return null;
    }
}