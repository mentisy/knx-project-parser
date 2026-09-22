<?php
declare(strict_types=1);

namespace Avolle\KnxProject\Parsing\Type\Enum;

/**
 * @internal
 */
enum InstallationIpRoutingBackboneSecurity: string implements EnumInterface
{
    use EnumTrait;

    case Auto = 'Auto';
    case On = 'On';
    case Off = 'Off';

    /**
     * @inheritDoc
     */
    public function label(): string
    {
        return $this->value;
    }
}
