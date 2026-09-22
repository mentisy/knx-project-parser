<?php
declare(strict_types=1);

namespace Avolle\KnxProject\Parsing\Type\Master;

use Avolle\KnxProject\Parsing\Caster\CastToBool;
use EventSauce\ObjectHydrator\MapFrom;

/**
 * @internal
 */
class DatapointSubType
{
    public function __construct(
        #[MapFrom('@Id')]
        public string $id,

        #[MapFrom('@Number')]
        public int $number,

        #[MapFrom('@Name')]
        public string $name,

        #[MapFrom('@Text')]
        public string $text,

        #[MapFrom('@Default')]
        #[CastToBool(false)]
        public ?bool $default,

        #[MapFrom('format')]
        public ?bool $format,
    ) {
    }
}
