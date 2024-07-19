<?php

namespace App\Libs\Form\Builder\Fields;

abstract class Field
{
    private $attributes = [];

    public static function make(): static
    {
        return new static();
    }

    public function label(?string $value = null)
    {
        return $this->attribute('label', $value);
    }

    public function attribute(string $name, ?string $value = null)
    {
        if (count(func_get_args()) < 2) return $this->getAttribute($name);
        $this->setAttribute($name, $value);
        return $this;
    }

    public function getAttribute(?string $name = null)
    {
        if(!$name) return $this->attributes;
        return $this->attributes[$name] ?? null;
    }

    private function setAttribute(string $name, ?string $value): void
    {
        $this->attributes[$name] = $value;
    }

    public function name(?string $value = null)
    {
        return $this->attribute('name', $value);
    }

    public function id(?string $value = null)
    {
        return $this->attribute('id', $value);
    }

    public function placeholder(?string $value = null)
    {
        return $this->attribute('placeholder', $value);
    }

    public function required(bool $value = true)
    {
        if (!$value) $this->attributes['required'] = null;
        else unset($this->attributes['required']);
        return $this;
    }

    public function readonly(bool $value = true)
    {
        if ($value) $this->attributes['readonly'] = null;
        else unset($this->attributes['readonly']);
        return $this;
    }

    public function disabled(bool $value = true)
    {
        if ($value) $this->attributes['disabled'] = null;
        else unset($this->attributes['disabled']);
        return $this;
    }

    public function autofocus(bool $value = true)
    {
        if ($value) $this->attributes['autofocus'] = null;
        else unset($this->attributes['autofocus']);
        return $this;
    }

    public function maxlength(int $value)
    {
        return $this->attribute('maxlength', (string) $value);
    }

    public function minlength(int $value)
    {
        return $this->attribute('minlength', (string) $value);
    }

    public function pattern(string $value)
    {
        return $this->attribute('pattern', $value);
    }
}

