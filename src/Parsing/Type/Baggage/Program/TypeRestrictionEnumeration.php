<?php
declare(strict_types=1);

namespace Avolle\KnxProject\Parsing\Type\Baggage\Program;

use EventSauce\ObjectHydrator\MapFrom;
use EventSauce\ObjectHydrator\PropertyCasters\CastToType;

/**
 * @internal
 */
class TypeRestrictionEnumeration
{
    public function __construct(
        #[MapFrom('@Text')]
        #[CastToType('string')]
        public ?string $text,

        #[MapFrom('@Value')]
        public ?int $value,

        #[MapFrom('@Id')]
        public ?string $id,

        #[MapFrom('@DisplayOrder')]
        public ?int $displayOrder,
    ) {
    }
}
