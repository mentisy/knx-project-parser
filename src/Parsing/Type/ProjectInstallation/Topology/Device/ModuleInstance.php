<?php
declare(strict_types=1);

namespace Avolle\KnxProject\Parsing\Type\ProjectInstallation\Topology\Device;

use Avolle\KnxProject\Parsing\Caster\CastExtractFromArrayKey;
use Avolle\KnxProject\Parsing\Caster\CastToListArray;
use EventSauce\ObjectHydrator\MapFrom;
use EventSauce\ObjectHydrator\PropertyCasters\CastListToType;

/**
 * @internal
 */
class ModuleInstance
{
    /**
     * @param string|null $id
     * @param string|null $refId
     * @param string|null $repeatIndex
     * @param array<\Avolle\KnxProject\Parsing\Type\ProjectInstallation\Topology\Device\ModuleArgument>|null $arguments
     */
    public function __construct(
        #[MapFrom('@Id')]
        public ?string $id,

        #[MapFrom('@RefId')]
        public ?string $refId,

        #[MapFrom('@RepeatIndex')]
        public ?string $repeatIndex,

        #[MapFrom('Arguments')]
        #[CastExtractFromArrayKey('Argument')]
        #[CastToListArray]
        #[CastListToType(ModuleArgument::class)]
        public ?array $arguments = [],
    ) {
    }
}
