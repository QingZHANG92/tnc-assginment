<?php

namespace App\Validation\Normalizer\Value;

class LastLoginAtValue implements ValueInterface
{
    /**
     * @param array<string, null|\DateTimeImmutable> $value
     */
    public function     __construct(private array $value = []) {}

    /**
     * @return array<string, null|\DateTimeImmutable>
     */
    public function getValue(): array
    {
        return $this->value;
    }
}