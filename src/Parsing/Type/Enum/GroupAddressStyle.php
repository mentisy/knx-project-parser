<?php
declare(strict_types=1);

namespace Avolle\KnxProject\Parsing\Type\Enum;

/**
 * @internal
 */
enum GroupAddressStyle: string implements EnumInterface
{
    use EnumTrait;

    case Free = 'Free';
    case TwoLevel = 'Two Level';
    case ThreeLevel = 'Three Level';

    /**
     * @inheritDoc
     */
    public function label(): string
    {
        return $this->value;
    }
}
