<?php
declare(strict_types=1);

namespace Avolle\KnxProject\Parsing\Type\Baggage\Program;

use EventSauce\ObjectHydrator\MapFrom;

class AbsoluteSegment
{
    public function __construct(
        #[MapFrom('@Id')]
        public ?string $id,

        #[MapFrom('@Address')]
        public ?int $address,

        #[MapFrom('@Size')]
        public ?int $size,

        #[MapFrom('@UserMemory')]
        public ?int $userMemory,
    ) {
    }
}
