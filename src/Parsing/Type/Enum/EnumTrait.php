<?php
declare(strict_types=1);

namespace Avolle\KnxProject\Parsing\Type\Enum;

trait EnumTrait
{
    /**
     * Try to set the enum by trying from the name.
     *
     * @param string $name Enum name
     * @return static|null
     */
    public static function tryFromName(string $name): ?static
    {
        return array_column(static::cases(), null, 'name')[$name] ?? null;
    }
}
