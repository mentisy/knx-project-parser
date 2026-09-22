<?php
declare(strict_types=1);

namespace Avolle\KnxProject\Parsing\Type\Baggage\Program;

use EventSauce\ObjectHydrator\MapFrom;
use EventSauce\ObjectHydrator\PropertyCasters\CastToType;

class TranslationElementString
{
    public function __construct(
        #[MapFrom('@AttributeName')]
        public ?string $attributeName,

        #[MapFrom('@Text')]
        #[CastToType('string')]
        public ?string $text,
    ) {
    }
}
