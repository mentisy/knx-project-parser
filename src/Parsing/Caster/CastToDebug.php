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
class CastToDebug implements PropertyCaster
{
    /**
     * Dump and die the value received
     *
     * @param mixed $value Value received
     * @param \EventSauce\ObjectHydrator\ObjectMapper $hydrator Hydrator mapper
     * @return never
     */
    public function cast(mixed $value, ObjectMapper $hydrator): never
    {
        dd($value);
    }
}
