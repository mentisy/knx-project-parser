<?php
declare(strict_types=1);

namespace Avolle\KnxProject\Parsing\Type\ProjectInstallation\Topology\Device;

use EventSauce\ObjectHydrator\MapFrom;

/**
 * @internal
 */
class ModuleArgument
{
    public function __construct(
        #[MapFrom('@RefId')]
        public ?string $refId,

        #[MapFrom('@Value')]
        public string|int|float|null $value,
    ) {
    }
}
