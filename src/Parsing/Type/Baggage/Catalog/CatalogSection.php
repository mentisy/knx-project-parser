<?php
declare(strict_types=1);

namespace Avolle\KnxProject\Parsing\Type\Baggage\Catalog;

use Avolle\KnxProject\Parsing\Caster\CastToArrayValues;
use Avolle\KnxProject\Parsing\Caster\CastToListArray;
use EventSauce\ObjectHydrator\MapFrom;
use EventSauce\ObjectHydrator\PropertyCasters\CastListToType;

/**
 * @internal
 */
class CatalogSection
{
    /**
     * @param array<\Avolle\KnxProject\Parsing\Type\Baggage\Catalog\CatalogSection>|null $sections
     * @param array<\Avolle\KnxProject\Parsing\Type\Baggage\Catalog\CatalogItem>|null $items
     */
    public function __construct(
        #[MapFrom('@Id')]
        public ?string $id,

        #[MapFrom('@Name')]
        public ?string $name,

        #[MapFrom('@Number')]
        public string|int $number,

        #[MapFrom('@DefaultLanguage')]
        public ?string $defaultLanguage,

        #[MapFrom('@NonRegRelevantDataVersion')]
        public ?int $nonRegRelevantDataVersion,

        #[MapFrom('CatalogSection')]
        #[CastToListArray]
        #[CastToArrayValues]
        #[CastListToType(CatalogSection::class)]
        public ?array $sections = [],

        #[MapFrom('CatalogItem')]
        #[CastToListArray]
        #[CastToArrayValues]
        #[CastListToType(CatalogItem::class)]
        public ?array $items = [],
    ) {
    }
}
