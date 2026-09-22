<?php
declare(strict_types=1);

namespace Avolle\KnxProject\Test\TestCase\Parsing\Caster;

use Avolle\KnxProject\Exception\CastValueException;
use Avolle\KnxProject\Parsing\Caster\CastToArrayValues;
use EventSauce\ObjectHydrator\ObjectMapperUsingReflection;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class CastToArrayValuesTest extends TestCase
{
    /**
     * Test cast method - Input a list array, so expect returned unchanged array
     *
     * @return void
     * @throws \Avolle\KnxProject\Exception\CastValueException
     */
    #[Test]
    public function castIsArray()
    {
        $caster = new CastToArrayValues();

        $isList =  ['this array is a list, so return unchanged'];
        $expected = $isList;
        $actual = $caster->cast($isList, new ObjectMapperUsingReflection());
        $this->assertEquals($expected, $actual);
    }

    /**
     * Test cast method - Input is associative array. Expect list array of input array returned.
     *
     * @return void
     * @throws \Avolle\KnxProject\Exception\CastValueException
     */
    #[Test]
    public function castAssociativeArray()
    {
        $caster = new CastToArrayValues();

        $notListArray = [5 => 'value for a specific key'];
        $expected = [$notListArray[5]];
        $actual = $caster->cast($notListArray, new ObjectMapperUsingReflection());
        $this->assertEquals($expected, $actual);
    }

    /**
     * Test cast method - Input not an array, so expect exception
     *
     * @return void
     */
    #[Test]
    public function castIsNotArray()
    {
        $caster = new CastToArrayValues();
        $this->expectException(CastValueException::class);
        $this->expectExceptionMessage('Input type `string` is not allowed while casting. Expecting an array value');

        $isList =  'this is a string, which is not accepted';
        $expected = $isList;
        $actual = $caster->cast($isList, new ObjectMapperUsingReflection());
        $this->assertEquals($expected, $actual);
    }
}
