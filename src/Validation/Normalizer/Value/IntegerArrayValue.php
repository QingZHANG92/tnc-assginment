<?php

namespace App\Validation\Normalizer\Value;

class IntegerArrayValue implements ValueInterface
{
    /**
     * @param int[] $value
     */
    public function __construct(private array $value = []) {}

    /**
     * @return int[]
     */
    public function getValue(): array
    {
        return $this->value;
    }
}