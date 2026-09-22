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
class GroupObjectTree
{
    public function __construct(
        #[MapFrom('Nodes')]
        #[CastExtractFromArrayKey('Node')]
        #[CastToListArray]
        #[CastListToType(Node::class)]
        public ?array $nodes = [],
    ) {
    }
}
