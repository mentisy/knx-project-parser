<?php
declare(strict_types=1);

namespace Avolle\KnxProject\Parsing\Type\Baggage\Program;

use EventSauce\ObjectHydrator\MapFrom;

class RelativeSegment
{
    public function __construct(
        #[MapFrom('@Id')]
        public ?string $id,

        #[MapFrom('@Offset')]
        public ?int $offset,

        #[MapFrom('@Size')]
        public ?int $size,

        #[MapFrom('@LoadStateMachine')]
        public ?int $loadStateMachine,
    ) {
    }
}
