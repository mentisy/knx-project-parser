<?php
declare(strict_types=1);

namespace Avolle\KnxProject\Parsing\Type\ProjectInstallation;

use EventSauce\ObjectHydrator\MapFrom;

/**
 * @internal
 */
class DeviceInstanceRef
{
    public function __construct(
        #[MapFrom('@RefId')]
        public ?string $refId,
    ) {
    }
}
