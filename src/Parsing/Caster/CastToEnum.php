<?php
declare(strict_types=1);

namespace Avolle\KnxProject\Parsing\Caster;

use Attribute;
use Avolle\KnxProject\Parsing\Type\Enum\EnumInterface;
use EventSauce\ObjectHydrator\ObjectMapper;
use EventSauce\ObjectHydrator\PropertyCaster;

/**
 * Cast value to a matching enum type
 *
 * @internal
 */
#[Attribute(Attribute::TARGET_PARAMETER)]
class CastToEnum implements PropertyCaster
{
    /**
     * Constructor
     *
     * @param \Avolle\KnxProject\Parsing\Type\Enum\EnumInterface $enum Enum type to cast value to.
     */
    public function __construct(protected EnumInterface $enum)
    {
    }

    /**
     * Cast value to a matching enum type.
     *
     * @param mixed $value Value to cast to enum.
     * @param \EventSauce\ObjectHydrator\ObjectMapper $hydrator Hydrator.
     * @return \Avolle\KnxProject\Parsing\Type\Enum\EnumInterface|int|string
     */
    public function cast(mixed $value, ObjectMapper $hydrator): EnumInterface|int|string
    {
        return $this->enum::tryFromName($value ?? 0) ?? $value;
    }
}
