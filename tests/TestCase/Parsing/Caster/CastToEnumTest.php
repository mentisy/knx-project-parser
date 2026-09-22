<?php
declare(strict_types=1);

namespace Avolle\KnxProject\Test\TestCase\Parsing\Caster;

use Avolle\KnxProject\Parsing\Caster\CastToEnum;
use Avolle\KnxProject\Parsing\Type\Enum\CompletionStatus;
use EventSauce\ObjectHydrator\ObjectMapperUsingReflection;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class CastToEnumTest extends TestCase
{
    /**
     * Test cast method - Input value is a known value, so it will return the enum-variant of that value.
     *
     * @return void
     */
    #[Test]
    public function castToKnownEnumValue()
    {
        $caster = new CastToEnum(CompletionStatus::Unknown);

        $value =  'Accepted';
        $expected = CompletionStatus::Accepted;
        $actual = $caster->cast($value, new ObjectMapperUsingReflection());
        $this->assertEquals($expected, $actual);
    }
    /**
     * Test cast method - Input type is an unknown enum, so return the value unchanged
     *
     * @return void
     */
    #[Test]
    public function castToUnknownEnumValue()
    {
        $caster = new CastToEnum(CompletionStatus::Unknown);

        $value =  'This is unknown';
        $expected = $value;
        $actual = $caster->cast($value, new ObjectMapperUsingReflection());
        $this->assertEquals($expected, $actual);
    }
}
