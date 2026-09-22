<?php
declare(strict_types=1);

namespace Avolle\KnxProject\Parsing\Type\Master;

use EventSauce\ObjectHydrator\MapFrom;

/**
 * @internal
 */
class Knx
{
    public function __construct(
        #[MapFrom('MasterData')]
        public MasterData $masterData,
    ) {
    }
}
