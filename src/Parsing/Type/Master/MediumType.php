<?php
declare(strict_types=1);

namespace Avolle\KnxProject\Parsing\Type\Master;

use EventSauce\ObjectHydrator\MapFrom;

/**
 * @internal
 */
class MediumType
{
    /**
     * @param string $id
     * @param int $number
     * @param string $name
     * @param string $text
     * @param int $domainAddressLength
     */
    public function __construct(
        #[MapFrom('@Id')]
        public string $id,

        #[MapFrom('@Number')]
        public int $number,

        #[MapFrom('@Name')]
        public string $name,

        #[MapFrom('@Text')]
        public string $text,

        #[MapFrom('@DomainAddressLength')]
        public int $domainAddressLength,
    ) {
    }
}
