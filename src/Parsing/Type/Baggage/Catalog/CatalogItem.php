<?php
declare(strict_types=1);

namespace Avolle\KnxProject\Parsing\Type\Baggage\Catalog;

use EventSauce\ObjectHydrator\MapFrom;

/**
 * @internal
 */
class CatalogItem
{
    public function __construct(
        #[MapFrom('@Id')]
        public ?string $id,

        #[MapFrom('@Name')]
        public ?string $name,

        #[MapFrom('@Number')]
        public string|int|null $number,

        #[MapFrom('@VisibleDescription')]
        public ?string $visibleDescription,

        #[MapFrom('@ProductRefId')]
        public ?string $productRefId,

        #[MapFrom('@Hardware2ProgramRefId')]
        public ?string $hardware2ProgramRefId,

        #[MapFrom('@DefaultLanguage')]
        public ?string $defaultLanguage,

        #[MapFrom('@NonRegRelevantDataVersion')]
        public ?int $nonRegRelevantDataVersion,
    ) {
    }
}
