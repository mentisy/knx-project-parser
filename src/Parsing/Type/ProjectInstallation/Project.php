<?php
declare(strict_types=1);

namespace Avolle\KnxProject\Parsing\Type\ProjectInstallation;

use Avolle\KnxProject\Parsing\Caster\CastToArrayValues;
use EventSauce\ObjectHydrator\MapFrom;
use EventSauce\ObjectHydrator\PropertyCasters\CastListToType;

/**
 * @internal
 */
class Project
{
    /**
     * @param string|null $id
     * @param array<\Avolle\KnxProject\Parsing\Type\ProjectInstallation\Installation>|null $installations
     */
    public function __construct(
        #[MapFrom('@Id')]
        public ?string $id,

        #[MapFrom('Installations')]
        #[CastToArrayValues]
        #[CastListToType(Installation::class)]
        public ?array $installations = [],
    ) {
    }
}
