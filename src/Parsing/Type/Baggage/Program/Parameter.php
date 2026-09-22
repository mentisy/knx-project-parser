<?php
declare(strict_types=1);

namespace Avolle\KnxProject\Parsing\Type\Baggage\Program;

use EventSauce\ObjectHydrator\MapFrom;
use EventSauce\ObjectHydrator\PropertyCasters\CastToType;

class Parameter
{
    /**
     * @param string|null $id
     * @param string|null $name
     * @param string|null $parameterType
     * @param string|null $text
     * @param string|int|float|null $value
     * @param \Avolle\KnxProject\Parsing\Type\Baggage\Program\Memory|null $memory
     */
    public function __construct(
        #[MapFrom('@Id')]
        public ?string $id,

        #[MapFrom('@Name')]
        #[CastToType('string')]
        public ?string $name,

        #[MapFrom('@ParameterType')]
        public ?string $parameterType,

        #[MapFrom('@Text')]
        #[CastToType('string')]
        public ?string $text,

        #[MapFrom('@Value')]
        public string|int|float|null $value,

        #[MapFrom('Memory')]
        public ?Memory $memory,
    ) {
    }
}
