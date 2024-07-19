<?php

namespace App\Libs\Form\Builder\Fields;

class TextField extends Field
{
    public function type(?string $value = null)
    {
        return $this->attribute('type', $value);
    }

    public function value(?string $value = null)
    {
        return $this->attribute('value', $value);
    }

    public function step(int $value)
    {
        return $this->attribute('step', (string) $value);
    }

    public function size(int $value)
    {
        return $this->attribute('size', (string) $value);
    }
}
