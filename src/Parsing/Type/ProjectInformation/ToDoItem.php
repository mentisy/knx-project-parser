<?php
declare(strict_types=1);

namespace Avolle\KnxProject\Parsing\Type\ProjectInformation;

use Avolle\KnxProject\Parsing\Caster\CastToEnum;
use Avolle\KnxProject\Parsing\Type\Enum\ToDoItemStatus;
use EventSauce\ObjectHydrator\MapFrom;

/**
 * @internal
 */
class ToDoItem
{
    /**
     * @param string $description
     * @param string|null $objectPath
     * @param \Avolle\KnxProject\Parsing\Type\Enum\ToDoItemStatus|string $status
     */
    public function __construct(
        #[MapFrom('@Description')]
        public string $description,

        #[MapFrom('@ObjectPath')]
        public ?string $objectPath,

        #[MapFrom('@Status')]
        #[CastToEnum(ToDoItemStatus::Open)]
        public ToDoItemStatus|string $status,
    ) {
    }
}
