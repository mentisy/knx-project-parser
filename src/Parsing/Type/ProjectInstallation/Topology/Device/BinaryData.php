<?php
declare(strict_types=1);

namespace Avolle\KnxProject\Parsing\Type\ProjectInstallation\Topology\Device;

use Avolle\KnxProject\Parsing\Caster\CastToBool;
use EventSauce\ObjectHydrator\MapFrom;

/**
 * @internal
 */
class BinaryData
{
    /**
     * @param string|null $id
     * @param string|null $refId
     * @param string|null $name
     * @param bool|null $doNotCopy
     */
    public function __construct(
        #[MapFrom('@Id')]
        public ?string $id,

        #[MapFrom('@RefId')]
        public ?string $refId,

        #[MapFrom('@Name')]
        public ?string $name,

        #[MapFrom('@DoNotCopy')]
        #[CastToBool(false)]
        public ?bool $doNotCopy,
    ) {
    }
}
