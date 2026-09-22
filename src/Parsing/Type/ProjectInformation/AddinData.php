<?php
declare(strict_types=1);

namespace Avolle\KnxProject\Parsing\Type\ProjectInformation;

use EventSauce\ObjectHydrator\MapFrom;

/**
 * @internal
 */
class AddinData
{
    /**
     * @param string $name
     * @param string $addinId
     */
    public function __construct(
        #[MapFrom('@Name')]
        public string $name,

        #[MapFrom('@AddinId')]
        public string $addinId,
    ) {
    }
}
