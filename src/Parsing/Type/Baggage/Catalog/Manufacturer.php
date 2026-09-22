<?php
declare(strict_types=1);

namespace Avolle\KnxProject\Parsing\Type\Baggage\Catalog;

use EventSauce\ObjectHydrator\MapFrom;

/**
 * @internal
 */
class Manufacturer
{
    /**
     * @param string|null $refId
     * @param \Avolle\KnxProject\Parsing\Type\Baggage\Catalog\Catalog|null $catalog
     */
    public function __construct(
        #[MapFrom('@RefId')]
        public ?string $refId,

        #[MapFrom('Catalog')]
        public ?Catalog $catalog,
    ) {
    }
}
