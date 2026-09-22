<?php
declare(strict_types=1);

namespace Avolle\KnxProject\Parsing\Type\Enum;

/**
 * @internal
 */
enum Enable: string implements EnumInterface
{
    use EnumTrait;

    case Enabled = 'Enabled';
    case Disabled = 'Disabled';

    /**
     * @inheritDoc
     */
    public function label(): string
    {
        return $this->value;
    }
}
