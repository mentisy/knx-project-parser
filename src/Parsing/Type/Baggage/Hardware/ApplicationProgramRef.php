<?php
declare(strict_types=1);

namespace Avolle\KnxProject\Parsing\Type\Baggage\Hardware;

use EventSauce\ObjectHydrator\MapFrom;

/**
 * @internal
 */
class ApplicationProgramRef
{
    public function __construct(
        #[MapFrom('@RefId')]
        public ?string $refId,
    ) {
    }
}
