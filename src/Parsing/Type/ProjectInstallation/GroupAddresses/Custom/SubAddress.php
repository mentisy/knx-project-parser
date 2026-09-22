<?php
declare(strict_types=1);

namespace Avolle\KnxProject\Parsing\Type\ProjectInstallation\GroupAddresses\Custom;

use Avolle\KnxProject\Parsing\Caster\CastToBool;
use Avolle\KnxProject\Parsing\Caster\CastToEnum;
use Avolle\KnxProject\Parsing\Type\Enum\Security;
use EventSauce\ObjectHydrator\MapFrom;
use EventSauce\ObjectHydrator\PropertyCasters\CastToType;

/**
 * @internal
 */
class SubAddress
{
    /**
     * @param string $id
     * @param int $address
     * @param string $name
     * @param bool|null $unfiltered
     * @param bool|null $central
     * @param bool|null $global
     * @param string|null $description
     * @param string|null $comment
     * @param string|null $datapointType
     * @param int|null $puId
     * @param string|null $key
     * @param \Avolle\KnxProject\Parsing\Type\Enum\Security|string|null $security
     */
    public function __construct(
        #[MapFrom('@Id')]
        public string $id,

        #[MapFrom('@Address')]
        public int $address,

        #[MapFrom('@Name')]
        #[CastToType('string')]
        public string $name,

        #[MapFrom('@Unfiltered')]
        #[CastToBool(false)]
        public ?bool $unfiltered,

        #[MapFrom('@Central')]
        #[CastToBool(false)]
        public ?bool $central,

        #[MapFrom('@Global')]
        #[CastToBool(false)]
        public ?bool $global,

        #[MapFrom('@Description')]
        #[CastToType('string')]
        public ?string $description,

        #[MapFrom('@Comment')]
        public ?string $comment,

        #[MapFrom('@DatapointType')]
        public ?string $datapointType,

        #[MapFrom('@Puid')]
        public ?int $puId,

        #[MapFrom('@Key')]
        public ?string $key,

        #[MapFrom('@Security')]
        #[CastToEnum(Security::Auto)]
        public Security|string|null $security,
    ) {
    }
}
