<?php
declare(strict_types=1);

namespace Avolle\KnxProject\Parsing\Type\Baggage\Hardware;

use Avolle\KnxProject\Parsing\Caster\CastToBool;
use EventSauce\ObjectHydrator\MapFrom;

/**
 * @internal
 */
class Product
{
    public function __construct(
        #[MapFrom('@Id')]
        public ?string $id,

        #[MapFrom('@Text')]
        public ?string $text,

        #[MapFrom('@OrderNumber')]
        public string|int|null $orderNumber,

        #[MapFrom('@IsRailMounted')]
        #[CastToBool(false)]
        public ?bool $isRailMounted,

        #[MapFrom('@DefaultLanguage')]
        public ?string $defaultLanguage,

        #[MapFrom('@Hash')]
        public ?string $hash,

        #[MapFrom('RegistrationInfo')]
        public ?RegistrationInfo $registrationInfo,
    ) {
    }
}
