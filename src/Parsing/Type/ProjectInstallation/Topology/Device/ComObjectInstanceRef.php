<?php
declare(strict_types=1);

namespace Avolle\KnxProject\Parsing\Type\ProjectInstallation\Topology\Device;

use Avolle\KnxProject\Parsing\Caster\CastToEnum;
use Avolle\KnxProject\Parsing\Type\Enum\ComObjectPriority;
use Avolle\KnxProject\Parsing\Type\Enum\Enable;
use EventSauce\ObjectHydrator\MapFrom;
use EventSauce\ObjectHydrator\PropertyCasters\CastToType;

/**
 * @internal
 */
class ComObjectInstanceRef
{
    /**
     * @param string|null $id
     * @param string $refId
     * @param string|null $text
     * @param string|null $functionText
     * @param \Avolle\KnxProject\Parsing\Type\Enum\ComObjectPriority|string|null $priority
     * @param \Avolle\KnxProject\Parsing\Type\Enum\Enable|string|null $readFlag
     * @param \Avolle\KnxProject\Parsing\Type\Enum\Enable|string|null $writeFlag
     * @param \Avolle\KnxProject\Parsing\Type\Enum\Enable|string|null $communicationFlag
     * @param \Avolle\KnxProject\Parsing\Type\Enum\Enable|string|null $transmitFlag
     * @param \Avolle\KnxProject\Parsing\Type\Enum\Enable|string|null $updateFlag
     * @param \Avolle\KnxProject\Parsing\Type\Enum\Enable|string|null $readOnInitFlag
     * @param string|null $datapointType
     * @param string|null $description
     * @param string|null $channelId
     * @param string|null $links
     * @param string|null $acknowledges
     */
    public function __construct(
        #[MapFrom('@id')]
        public ?string $id,

        #[MapFrom('@RefId')]
        public string $refId,

        #[MapFrom('@Text')]
        public ?string $text,

        #[MapFrom('@FunctionText')]
        public ?string $functionText,

        #[MapFrom('@Priority')]
        #[CastToEnum(ComObjectPriority::Low)]
        public ComObjectPriority|string|null $priority,

        #[MapFrom('@ReadFlag')]
        #[CastToEnum(Enable::Enabled)]
        public Enable|string|null $readFlag,

        #[MapFrom('@WriteFlag')]
        #[CastToEnum(Enable::Enabled)]
        public Enable|string|null $writeFlag,

        #[MapFrom('@CommunicationFlag')]
        #[CastToEnum(Enable::Enabled)]
        public Enable|string|null $communicationFlag,

        #[MapFrom('@TransmitFlag')]
        #[CastToEnum(Enable::Enabled)]
        public Enable|string|null $transmitFlag,

        #[MapFrom('@UpdateFlag')]
        #[CastToEnum(Enable::Enabled)]
        public Enable|string|null $updateFlag,

        #[MapFrom('@ReadOnInitFlag')]
        #[CastToEnum(Enable::Enabled)]
        public Enable|string|null $readOnInitFlag,

        #[MapFrom('@DatapointType')]
        public ?string $datapointType,

        #[MapFrom('@Description')]
        #[CastToType('string')]
        public ?string $description,

        #[MapFrom('@ChannelId')]
        public ?string $channelId,

        #[MapFrom('@Links')]
        public ?string $links,

        #[MapFrom('@Acknowledges')]
        public ?string $acknowledges,
    ) {
    }

    /**
     * Returns the links as an array of IDs. If `$removePrefix` is true, then it removes the "GA-" prefix.
     *
     * @param bool $removePrefix Remove "GA-" prefix?
     * @return array<string|int>
     */
    public function linksAsArray(?bool $removePrefix = false): array
    {
        if (empty($this->links)) {
            return [];
        }

        $links = explode(' ', $this->links);
        if (!$removePrefix) {
            return $links;
        }

        return array_map(fn ($link) => (int)str_replace('GA-', '', $link), $links);
    }
}
