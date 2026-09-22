<?php
declare(strict_types=1);

namespace Avolle\KnxProject\Parsing\Caster;

use Attribute;
use EventSauce\ObjectHydrator\ObjectMapper;
use EventSauce\ObjectHydrator\ObjectMapperUsingReflection;
use EventSauce\ObjectHydrator\PropertyCaster;

/**
 * @internal
 */
#[Attribute(Attribute::TARGET_PARAMETER)]
class CastToGroupAddressStructure implements PropertyCaster
{
    public function __construct(protected string $targetClass)
    {
    }

    /**
     * Will transform group ranges into a more human-readable group address structure
     *
     * @param mixed $value Value received
     * @param \EventSauce\ObjectHydrator\ObjectMapper $hydrator Hydrator mapper
     * @return mixed
     */
    public function cast(mixed $value, ObjectMapper $hydrator): mixed
    {
        if (!is_array($value)) {
            return $value;
        }
        $mapper = new ObjectMapperUsingReflection();

        // If only one main address, then it's only an associated key array of that single main address,
        // so we need to make it into a list array containing that main address.
        if (!array_is_list($value['GroupRange'])) {
            $value['GroupRange'] = [$value['GroupRange']];
        }
        $mainRanges = [];
        foreach ($value['GroupRange'] as $mainRange) {
            if (!is_array($mainRange)) {
                $mainRange = [$mainRange];
            }
            $mainRanges[] = $mapper->hydrateObject($this->targetClass, $mainRange);
        }
        return $mainRanges;
    }
}
