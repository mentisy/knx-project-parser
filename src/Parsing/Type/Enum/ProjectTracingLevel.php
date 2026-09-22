<?php
declare(strict_types=1);

namespace Avolle\KnxProject\Parsing\Type\Enum;

/**
 * @internal
 */
enum ProjectTracingLevel: string implements EnumInterface
{
    use EnumTrait;

    case None = 'None';
    case OperationUsed = 'Operation Used';
    case Detailed = 'Detailed';

    /**
     * @inheritDoc
     */
    public function label(): string
    {
        return $this->value;
    }
}
