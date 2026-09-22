<?php
declare(strict_types=1);

namespace Avolle\KnxProject\Parsing\Type\Baggage\Program;

use EventSauce\ObjectHydrator\MapFrom;

class Memory
{
    public function __construct(
        #[MapFrom('@CodeSegment')]
        public ?string $codeSegment,

        #[MapFrom('@Offset')]
        public ?int $offset,

        #[MapFrom('@BitOffset')]
        public ?int $bitOffset,
    ) {
    }
}
