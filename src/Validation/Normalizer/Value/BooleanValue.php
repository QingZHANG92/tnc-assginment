<?php

namespace App\Validation\Normalizer\Value;

class BooleanValue implements ValueInterface
{
    public function __construct(private ?bool $value = null) {}

    public function getValue(): ?bool
    {
        return $this->value;
    }
}