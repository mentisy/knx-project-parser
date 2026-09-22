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
class CastToBool implements PropertyCaster
{
    public function __construct(protected bool|null $default)
    {
    }

    /**
     * Cast a bool-ish string value into a propper bool value. Otherwise, use the default value
     *
     * @param mixed $value Value received
     * @param \EventSauce\ObjectHydrator\ObjectMapper $hydrator Hydrator mapper
     * @return bool|null
     */
    public function cast(mixed $value, ObjectMapper $hydrator): ?bool
    {
        return match ($value) {
            true, "true", 1, '1' => true,
            false, "false", 0, '0' => false,
            default => $this->default,
        };
    }
}
