<?php
declare(strict_types=1);

namespace Avolle\KnxProject\Parsing\Type\Enum;

use BackedEnum;

/**
 * @internal
 */
interface EnumInterface extends BackedEnum
{
    /**
     * Try to set the enum by trying from the name.
     *
     * @param string $name Enum name
     * @return static|null
     */
    public static function tryFromName(string $name): ?static;

    /**
     * Label for the case
     *
     * @return string
     */
    public function label(): string;
}
