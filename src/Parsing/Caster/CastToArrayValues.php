<?php
declare(strict_types=1);

namespace Avolle\KnxProject\Parsing\Caster;

use Attribute;
use Avolle\KnxProject\Exception\CastValueException;
use EventSauce\ObjectHydrator\ObjectMapper;
use EventSauce\ObjectHydrator\PropertyCaster;

/**
 * @internal
 */
#[Attribute(Attribute::TARGET_PARAMETER)]
class CastToArrayValues implements PropertyCaster
{
    /**
     * Will make sure to return a list-variant array. If it is an associative array, it will return that array as a list.
     *
     * @param mixed $value Value received
     * @param \EventSauce\ObjectHydrator\ObjectMapper $hydrator Hydrator mapper
     * @return mixed
     * @throws \Avolle\KnxProject\Exception\CastValueException
     */
    public function cast(mixed $value, ObjectMapper $hydrator): mixed
    {
        if (!is_array($value)) {
            $type = gettype($value);
            throw new CastValueException("Input type `$type` is not allowed while casting. Expecting an array value");
        }

        return array_values($value);
    }
}
