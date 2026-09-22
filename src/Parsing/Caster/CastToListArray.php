<?php
declare(strict_types=1);

namespace Avolle\KnxProject\Parsing\Caster;

use Attribute;
use EventSauce\ObjectHydrator\ObjectMapper;
use EventSauce\ObjectHydrator\PropertyCaster;

/**
 * @internal
 */
#[Attribute(Attribute::TARGET_PARAMETER)]
class CastToListArray implements PropertyCaster
{
    /**
     * Will make sure to return a list-variant array. If is it's associative array, it will return that array
     * inside a list array.
     *
     * @param mixed $value Value received
     * @param \EventSauce\ObjectHydrator\ObjectMapper $hydrator Hydrator mapper
     * @return mixed
     */
    public function cast(mixed $value, ObjectMapper $hydrator): mixed
    {
        if (is_array($value) && array_is_list($value)) {
            return $value;
        }

        return [$value];
    }
}
