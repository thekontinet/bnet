<?php

namespace App\Builders;

class FormBuilder
{
    protected ?string $action = '';
    protected ?string $title = '';
    protected ?string $description = '';
    protected array $fields = [];

    public function setAction(string $action): static
    {
        $this->action = $action;
        return $this;
    }

    public function setTitle($title): static
    {
        $this->title = $title;
        return $this;
    }

    public function setDescription($description): static
    {
        $this->description = $description;
        return $this;
    }

    public function addField($name, $label, $type='text', $value = null): static
    {
        $this->fields[] = ['name' => $name, 'label' => $label, 'type' => $type, 'value' => $value];
        return $this;
    }

    public function buildArray(): array
    {
        return [
            'action' => $this->action,
            'title' => $this->title,
            'description' => $this->description,
            'fields' => $this->fields
        ];
    }

}

