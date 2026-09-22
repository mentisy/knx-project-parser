<?php
declare(strict_types=1);

namespace Avolle\KnxProject\Parsing\Type\Baggage\Hardware;

use EventSauce\ObjectHydrator\MapFrom;

/**
 * @internal
 */
class Hardware2Program
{
    public function __construct(
        #[MapFrom('@Id')]
        public ?string $id,

        #[MapFrom('@MediumTypes')]
        public ?string $mediumTypes,

        #[MapFrom('@Hash')]
        public ?string $hash,

        #[MapFrom('ApplicationProgramRef')]
        public ?ApplicationProgramRef $applicationProgramRef,

        #[MapFrom('RegistrationInfo')]
        public ?RegistrationInfo $registrationInfo,
    ) {
    }
}
