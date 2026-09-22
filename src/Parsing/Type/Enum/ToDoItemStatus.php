<?php
declare(strict_types=1);

namespace Avolle\KnxProject\Parsing\Type\Enum;

/**
 * @internal
 */
enum ToDoItemStatus: string implements EnumInterface
{
    use EnumTrait;

    case Open = 'Open';
    case Accomplished = 'Accomplished';

    /**
     * @inheritDoc
     */
    public function label(): string
    {
        return $this->value;
    }
}
