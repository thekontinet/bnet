<?php

namespace App\DataObjects;

class DataObject
{
    public static function fromArray(array $data): static
    {
        $reflectionClass = new \ReflectionClass(static::class);
        $parameters = [];

        foreach ($reflectionClass->getProperties() as $property) {
            $propertyName = $property->getName();

            if(!$property->getType()->allowsNull() && !isset($data[$propertyName])){
                throw new \InvalidArgumentException("Missing property: $propertyName");
            }

            $parameters[] = $data[$propertyName] ?? null;
        }

        return $reflectionClass->newInstanceArgs($parameters);
    }

    public function toArray(): array
    {
        return get_object_vars($this);
    }
}
