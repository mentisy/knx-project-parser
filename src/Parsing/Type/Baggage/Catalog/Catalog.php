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
class Catalog
{
    /**
     * @param array<\Avolle\KnxProject\Parsing\Type\Baggage\Catalog\CatalogSection>|null $sections
     */
    public function __construct(
        #[MapFrom('CatalogSection')]
        #[CastToListArray]
        #[CastToArrayValues]
        #[CastListToType(CatalogSection::class)]
        public ?array $sections = [],
    ) {
    }
}
