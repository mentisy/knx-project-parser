<?php
declare(strict_types=1);

namespace Avolle\KnxProject\Parsing\Type\Baggage\Hardware;

use EventSauce\ObjectHydrator\MapFrom;

/**
 * @internal
 */
class RegistrationInfo
{
    public function __construct(
        #[MapFrom('@RegistrationStatus')]
        public ?string $registrationStatus,

        #[MapFrom('@RegistrationDate')]
        public ?string $registrationDate,

        #[MapFrom('@RegistrationNumber')]
        public ?string $registrationNumber,

        #[MapFrom('@RegistrationSignature')]
        public ?string $registrationSignature,
    ) {
    }
}
