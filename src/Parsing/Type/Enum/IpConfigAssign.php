<?php
declare(strict_types=1);

namespace Avolle\KnxProject\Parsing\Type\Enum;

/**
 * @internal
 */
enum IpConfigAssign: string implements EnumInterface
{
    use EnumTrait;

    case Auto = "Auto";

    case Fixed = "Fixed";

    /**
     * @inheritDoc
     */
    public function label(): string
    {
        return $this->value;
    }
}
