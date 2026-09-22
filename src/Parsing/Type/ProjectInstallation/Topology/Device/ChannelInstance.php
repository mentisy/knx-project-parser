<?php
declare(strict_types=1);

namespace Avolle\KnxProject\Parsing\Type\ProjectInstallation\Topology\Device;

use Avolle\KnxProject\Parsing\Caster\CastToBool;
use EventSauce\ObjectHydrator\MapFrom;
use EventSauce\ObjectHydrator\PropertyCasters\CastToType;

/**
 * @internal
 */
class ChannelInstance
{
    /**
     * @param string $id
     * @param string|null $refId
     * @param string|null $name
     * @param string|null $description
     * @param bool|null $isActive
     */
    public function __construct(
        #[MapFrom('@Id')]
        public string $id,

        #[MapFrom('@RefId')]
        public ?string $refId,

        #[MapFrom('@Name')]
        #[CastToType('string')]
        public ?string $name,

        #[MapFrom('@Description')]
        public ?string $description,

        #[MapFrom('@IsActive')]
        #[CastToBool(false)]
        public ?bool $isActive = false,
    ) {
    }
}
