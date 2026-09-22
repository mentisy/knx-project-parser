<?php
declare(strict_types=1);

namespace Avolle\KnxProject\Parsing\Type\Enum;

/**
 * @internal
 */
enum CompletionStatus: string implements EnumInterface
{
    use EnumTrait;

    case Unknown = 'Unknown';
    case Undefined = 'Undefined';
    case Editing = 'Editing';
    case FinishedDesign = 'Finished Design';
    case FinishedCommissioning = 'Finished Commissioning';
    case Tested = 'Tested';
    case Accepted = 'Accepted';
    case Locked = 'Locked';

    /**
     * @inheritDoc
     */
    public function label(): string
    {
        return $this->value;
    }
}
