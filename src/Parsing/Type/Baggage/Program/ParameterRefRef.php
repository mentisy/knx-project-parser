<?php
declare(strict_types=1);

namespace Avolle\KnxProject\Parsing\Type\Baggage\Program;

use EventSauce\ObjectHydrator\MapFrom;

class ParameterRefRef
{
    public function __construct(
        #[MapFrom('@RefId')]
        public ?string $refId,
    ) {
    }
}
