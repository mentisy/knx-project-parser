<?php
declare(strict_types=1);

namespace Avolle\KnxProject\Test\TestCase\Parsing\Caster;

use Avolle\KnxProject\Parsing\Caster\CastToListArray;
use EventSauce\ObjectHydrator\ObjectMapperUsingReflection;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class CastToListArrayTest extends TestCase
{
    /**
     * Test cast method
     *
     * @return void
     */
    #[Test]
    public function cast()
    {
        $caster = new CastToListArray();

        $notList = [5 => 'this array is not a list, so return this array inside a list'];
        $expected = [$notList];
        $actual = $caster->cast($notList, new ObjectMapperUsingReflection());
        $this->assertEquals($expected, $actual);

        $isNotArray =  'this is not an array, so return this as a list array';
        $expected = [$isNotArray];
        $actual = $caster->cast($isNotArray, new ObjectMapperUsingReflection());
        $this->assertEquals($expected, $actual);

        $isList =  ['this array is a list, so return unchanged'];
        $expected = $isList;
        $actual = $caster->cast($isList, new ObjectMapperUsingReflection());
        $this->assertEquals($expected, $actual);
    }
}
