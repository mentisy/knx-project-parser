<?php
declare(strict_types=1);

namespace Avolle\KnxProject\Parsing\Type\ProjectInstallation\Topology\Device;

use EventSauce\ObjectHydrator\MapFrom;

/**
 * @internal
 */
class AdditionalAddress
{
    /**
     * @param int|null $address
     * @param string|null $name
     * @param string|null $description
     * @param string|null $comment
     */
    public function __construct(
        #[MapFrom('@Address')]
        public ?int $address,

        #[MapFrom('@Name')]
        public ?string $name,

        #[MapFrom('@Description')]
        public ?string $description,

        #[MapFrom('@Comment')]
        public ?string $comment,
    ) {
    }
}
