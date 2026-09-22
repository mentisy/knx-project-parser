<?php
declare(strict_types=1);

namespace Avolle\KnxProject\Parsing\Type\ProjectInstallation\GroupAddresses\Custom;

use Avolle\KnxProject\Parsing\Caster\CastToBool;
use Avolle\KnxProject\Parsing\Caster\CastToEnum;
use Avolle\KnxProject\Parsing\Caster\CastToListArray;
use Avolle\KnxProject\Parsing\Type\Enum\Security;
use EventSauce\ObjectHydrator\MapFrom;
use EventSauce\ObjectHydrator\PropertyCasters\CastListToType;

/**
 * @internal
 */
class MainAddress
{
    /**
     * @param string $id
     * @param string|null $name
     * @param int $rangeStart
     * @param int $rangeEnd
     * @param bool|null $unfiltered
     * @param string|null $description
     * @param string|null $comment
     * @param int|null $puId
     * @param \Avolle\KnxProject\Parsing\Type\Enum\Security|string|null $security
     * @param array<\Avolle\KnxProject\Parsing\Type\ProjectInstallation\GroupAddresses\Custom\MiddleAddress>|null $middleAddresses
     */
    public function __construct(
        #[MapFrom('@Id')]
        public string $id,

        #[MapFrom('@Name')]
        public ?string $name,

        #[MapFrom('@RangeStart')]
        public int $rangeStart,

        #[MapFrom('@RangeEnd')]
        public int $rangeEnd,

        #[MapFrom('@Unfiltered')]
        #[CastToBool(false)]
        public ?bool $unfiltered,

        #[MapFrom('@Description')]
        public ?string $description,

        #[MapFrom('@Comment')]
        public ?string $comment,

        #[MapFrom('@Puid')]
        public ?int $puId,

        #[MapFrom('@Security')]
        #[CastToEnum(Security::Auto)]
        public Security|string|null $security,

        #[MapFrom('GroupRange')]
        #[CastToListArray]
        #[CastListToType(MiddleAddress::class)]
        public ?array $middleAddresses,
    ) {
    }
}
