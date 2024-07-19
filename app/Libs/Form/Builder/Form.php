<?php

namespace App\Libs\Form\Builder;

use App\Libs\Form\Builder\Fields\Field;

class Form
{
    private array $fields = [];
    private array $attributes = [];
    private string $title = '';
    private string $description = '';

    public static function make(): static
    {
        return new static();
    }

    private function setAttribute(string $name, string $value): void
    {
        $this->attributes[$name] = $value;
    }

    public function getAttribute(?string $name = null)
    {
        if(!$name) return $this->attributes;
        return $this->attributes[$name] ?? null;
    }

    public function attribute(string $name, ?string $value = null)
    {
        if (!$value) return $this->getAttribute($name);
        $this->setAttribute($name, $value);
        return $this;
    }

    public function action(?string $action = null)
    {
        return $this->attribute('action', $action);
    }

    public function method(?string $method = null)
    {
        return $this->attribute('method', $method);
    }

    public function title(?string $title = null)
    {
        if($title === null) return $this->title;

        $this->title = $title;
        return $this;
    }

    public function description(?string $description = null)
    {
        if($description === null) return $this->description;

        $this->description = $description;
        return $this;
    }

    public function addField(Field $field)
    {
        $this->fields[] = $field;
        return $this;
    }

    public function getFields()
    {
        return $this->fields;
    }
}

