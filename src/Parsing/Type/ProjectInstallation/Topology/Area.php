<?php
declare(strict_types=1);

namespace Avolle\KnxProject\Parsing\Type\ProjectInstallation\Topology;

use Avolle\KnxProject\Parsing\Caster\CastToEnum;
use Avolle\KnxProject\Parsing\Caster\CastToListArray;
use Avolle\KnxProject\Parsing\Type\Enum\CompletionStatus;
use EventSauce\ObjectHydrator\MapFrom;
use EventSauce\ObjectHydrator\PropertyCasters\CastListToType;

/**
 * @internal
 */
class Area
{
    /**
     * @param string $id
     * @param string|null $name
     * @param int $address
     * @param string|null $comment
     * @param \Avolle\KnxProject\Parsing\Type\Enum\CompletionStatus|string|null $completionStatus
     * @param string|null $description
     * @param int|null $puId
     * @param array<\Avolle\KnxProject\Parsing\Type\ProjectInstallation\Topology\Line>|null $lines
     */
    public function __construct(
        #[MapFrom('@Id')]
        public string $id,

        #[MapFrom('@Name')]
        public ?string $name,

        #[MapFrom('@Address')]
        public int $address,

        #[MapFrom('@Comment')]
        public ?string $comment,

        #[MapFrom('@CompletionStatus')]
        #[CastToEnum(CompletionStatus::Unknown)]
        public CompletionStatus|string|null $completionStatus,

        #[MapFrom('@Description')]
        public ?string $description,

        #[MapFrom('@Puid')]
        public ?int $puId,

        #[MapFrom('Line')]
        #[CastToListArray]
        #[CastListToType(Line::class)]
        public ?array $lines,
    ) {
    }
}
