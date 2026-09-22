<?php
declare(strict_types=1);

namespace Avolle\KnxProject\Parsing\Type\ProjectInformation;

use EventSauce\ObjectHydrator\MapFrom;

/**
 * @internal
 */
class DeviceCertificate
{
    /**
     * @param string $serialNumber
     * @param string|null $fdsk
     * @param string|null $password
     */
    public function __construct(
        #[MapFrom('@SerialNumber')]
        public string $serialNumber,

        #[MapFrom('@FDSK')]
        public ?string $fdsk,

        #[MapFrom('@Password')]
        public ?string $password,
    ) {
    }
}
