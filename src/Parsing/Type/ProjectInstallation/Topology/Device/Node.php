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
class Node
{
    /**
     * @param string $type
     * @param string $refId
     * @param string|null $groupObjectInstances
     * @param array|null $nodes
     */
    public function __construct(
        #[MapFrom('@Type')]
        public string $type,

        #[MapFrom('@RefId')]
        public string $refId,

        #[MapFrom('@GroupObjectInstances')]
        public ?string $groupObjectInstances,

        #[MapFrom('Nodes')]
        #[CastExtractFromArrayKey('Node')]
        #[CastToListArray]
        #[CastListToType(Node::class)]
        public ?array $nodes = [],
    ) {
    }
}
