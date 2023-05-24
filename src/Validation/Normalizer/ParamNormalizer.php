<?php

namespace App\Validation\Normalizer;

use App\Validation\Normalizer\Value\BooleanValue;
use App\Validation\Normalizer\Value\IntegerArrayValue;
use App\Validation\Normalizer\Value\LastLoginAtValue;
use App\Validation\Normalizer\Value\ValueInterface;
use Symfony\Component\Serializer\Normalizer\CacheableSupportsMethodInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class ParamNormalizer implements NormalizerInterface, DenormalizerInterface, CacheableSupportsMethodInterface
{
    private const SUPPORTED_TYPES = [
        BooleanValue::class,
        IntegerArrayValue::class,
        LastLoginAtValue::class,
    ];

    public function normalize(mixed $object, string $format = null, array $context = [])
    {
        //No normalize needed for now.
    }

    public function supportsNormalization(mixed $data, string $format = null)
    {
        return $data instanceof ValueInterface;
    }

    public function denormalize(mixed $data, string $type, string $format = null, array $context = [])
    {
        if ($type === BooleanValue::class) {
            return new $type(\filter_var($data, FILTER_VALIDATE_BOOLEAN));
        }
        if ($type === IntegerArrayValue::class) {
            return new $type(
                array_map(fn ($item) => (int)$item,
                    array_filter($data, fn ($value) => is_numeric($value))
                )
            );
        }
        if ($type === LastLoginAtValue::class) {
            return new $type([
                'start' => isset($data['start']) ? new \DateTimeImmutable($data['start']) : null,
                'end' => isset($data['end']) ? new \DateTimeImmutable($data['end']) : null,
            ]);
        }

        return new $type(null);
    }

    public function supportsDenormalization(mixed $data, string $type, string $format = null)
    {
        return in_array($type, self::SUPPORTED_TYPES);
    }

    public function hasCacheableSupportsMethod(): bool
    {
        return __CLASS__ === static::class;
    }
}