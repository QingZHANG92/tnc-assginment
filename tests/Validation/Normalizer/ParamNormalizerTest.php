<?php

namespace App\Tests\Validation\Normalizer;

use App\Validation\Normalizer\ParamNormalizer;
use App\Validation\Normalizer\Value\BooleanValue;
use App\Validation\Normalizer\Value\IntegerArrayValue;
use PHPUnit\Framework\TestCase;

class ParamNormalizerTest extends TestCase
{
    public function testSupportsDenormalization() {
        $normalizer = new ParamNormalizer();
        $supportType = $normalizer->supportsDenormalization([], BooleanValue::class);

        self::assertTrue($supportType);
    }

    public function testDenormalizeBoolean() {
        $normalizer = new ParamNormalizer();
        $dataIsActive = '0';
        $denormalizedIsActive = $normalizer->denormalize($dataIsActive, BooleanValue::class);

        self::assertEquals(new BooleanValue(false), $denormalizedIsActive);

        $dataIsActive2 = 'true';
        $denormalizedIsActive = $normalizer->denormalize($dataIsActive2, BooleanValue::class);

        self::assertEquals(new BooleanValue(true), $denormalizedIsActive);
    }

    public function testDenormalizeIntegerArray() {
        $normalizer = new ParamNormalizer();
        $data = ['1', '2', 'abc'];
        $denormalizedData = $normalizer->denormalize($data, IntegerArrayValue::class);

        self::assertEquals(new IntegerArrayValue([1, 2]),$denormalizedData);
    }
}