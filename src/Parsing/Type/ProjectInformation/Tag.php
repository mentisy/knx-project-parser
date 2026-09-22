<?php
declare(strict_types=1);

namespace Avolle\KnxProject\Parsing\Type\ProjectInformation;

use EventSauce\ObjectHydrator\MapFrom;

/**
 * @internal
 */
class Tag
{
    /**
     * @param string $text
     * @param string $color
     */
    public function __construct(
        #[MapFrom('@Text')]
        public string $text,

        #[MapFrom('@Color')]
        public string $color,
    ) {
    }
}
