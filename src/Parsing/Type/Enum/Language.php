<?php
declare(strict_types=1);

namespace Avolle\KnxProject\Parsing\Type\Enum;

/**
 * @internal
 */
enum Language: string implements EnumInterface
{
    use EnumTrait;

    case enUS = 'en-US';

    /**
     * @inheritDoc
     */
    public function label(): string
    {
        return $this->value;
    }
}
