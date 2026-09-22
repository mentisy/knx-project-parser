<?php
declare(strict_types=1);

namespace Avolle\KnxProject\Test\TestCase\Parsing\Caster;

use Avolle\KnxProject\Parsing\Caster\CastToBool;
use EventSauce\ObjectHydrator\ObjectMapperUsingReflection;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class CastToBoolTest extends TestCase
{
    /**
     * Test cast method - Input value = trueish, so return that
     *
     * @return void
     */
    #[Test]
    public function castTrueish()
    {
        $caster = new CastToBool(false);

        $actual = $caster->cast(true, new ObjectMapperUsingReflection());
        $this->assertTrue($actual, 'Input value `true` should be returned');

        $actual = $caster->cast('true', new ObjectMapperUsingReflection());
        $this->assertTrue($actual, 'Input value `true` should be returned');

        $actual = $caster->cast(1, new ObjectMapperUsingReflection());
        $this->assertTrue($actual, 'Input value `true` should be returned');

        $actual = $caster->cast('1', new ObjectMapperUsingReflection());
        $this->assertTrue($actual, 'Input value `true` should be returned');
    }

    /**
     * Test cast method - Input value = falseish, so return that
     *
     * @return void
     */
    #[Test]
    public function castFalseish()
    {
        $caster = new CastToBool(true);

        $actual = $caster->cast(false, new ObjectMapperUsingReflection());
        $this->assertFalse($actual, 'Input value `false` should be returned');

        $actual = $caster->cast('false', new ObjectMapperUsingReflection());
        $this->assertFalse($actual, 'Input value `false` should be returned');

        $actual = $caster->cast(0, new ObjectMapperUsingReflection());
        $this->assertFalse($actual, 'Input value `false` should be returned');

        $actual = $caster->cast('0', new ObjectMapperUsingReflection());
        $this->assertFalse($actual, 'Input value `false` should be returned');
    }

    /**
     * Test cast method - Input value = non-booleanish, so return `$default`.
     *
     * @return void
     */
    #[Test]
    public function castNullReturnsDefault()
    {
        $caster = new CastToBool(false);
        $actual = $caster->cast(null, new ObjectMapperUsingReflection());
        $this->assertFalse($actual, 'Default `false` should be returned');

        $caster = new CastToBool(true);
        $actual = $caster->cast(null, new ObjectMapperUsingReflection());
        $this->assertTrue($actual, 'Default `true` should be returned');
    }
}
