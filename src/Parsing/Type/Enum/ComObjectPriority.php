<?php
declare(strict_types=1);

namespace Avolle\KnxProject\Parsing\Type\Enum;

/**
 * @internal
 */
enum ComObjectPriority: string implements EnumInterface
{
    use EnumTrait;

    case Low = 'Low';
    case High = 'High';
    case Alert = 'Alert';

    /**
     * @inheritDoc
     */
    public function label(): string
    {
        return $this->value;
    }
}
