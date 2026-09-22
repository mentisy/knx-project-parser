<?php
declare(strict_types=1);

namespace Avolle\KnxProject\Parsing\Type\ProjectInformation;

use Avolle\KnxProject\Parsing\Caster\CastExtractFromArrayKey;
use Avolle\KnxProject\Parsing\Caster\CastToBool;
use Avolle\KnxProject\Parsing\Caster\CastToEnum;
use Avolle\KnxProject\Parsing\Caster\CastToListArray;
use Avolle\KnxProject\Parsing\Type\Enum\CompletionStatus;
use Avolle\KnxProject\Parsing\Type\Enum\GroupAddressStyle;
use Avolle\KnxProject\Parsing\Type\Enum\ProjectTracingLevel;
use Avolle\KnxProject\Parsing\Type\Enum\ProjectType;
use Avolle\KnxProject\Parsing\Type\Enum\Security;
use DateTimeImmutable;
use EventSauce\ObjectHydrator\MapFrom;
use EventSauce\ObjectHydrator\PropertyCasters\CastListToType;
use EventSauce\ObjectHydrator\PropertyCasters\CastToDateTimeImmutable;
use EventSauce\ObjectHydrator\PropertyCasters\CastToType;

/**
 * @internal
 */
class ProjectInformation
{
    /**
     * @param string $name
     * @param \Avolle\KnxProject\Parsing\Type\Enum\GroupAddressStyle|string $groupAddressStyle
     * @param string|null $projectNumber
     * @param string|null $contractNumber
     * @param \DateTimeImmutable|null $lastModified
     * @param \DateTimeImmutable|null $archivedVersion
     * @param \DateTimeImmutable|null $projectStart
     * @param \DateTimeImmutable|null $projectEnd
     * @param \Avolle\KnxProject\Parsing\Type\Enum\ProjectType|string|null $projectType
     * @param int|null $projectId
     * @param string|null $comment
     * @param \Avolle\KnxProject\Parsing\Type\Enum\CompletionStatus|string|null $completionStatus
     * @param \Avolle\KnxProject\Parsing\Type\Enum\ProjectTracingLevel|string|null $projectTracingLevel
     * @param string|null $projectTracingPassword
     * @param bool|null $hide16BitGroupsFromLegacyPlugins
     * @param string|null $codePage
     * @param bool|null $busAccessLegacyMode
     * @param string $guId
     * @param int $lastUsedPuId
     * @param \Avolle\KnxProject\Parsing\Type\Enum\Security|string|null $security
     * @param array<\Avolle\KnxProject\Parsing\Type\ProjectInformation\Tag>|null $tags
     * @param array<\Avolle\KnxProject\Parsing\Type\ProjectInformation\HistoryEntry>|null $historyEntries
     * @param array<\Avolle\KnxProject\Parsing\Type\ProjectInformation\ToDoItem>|null $toDoItems
     * @param array<\Avolle\KnxProject\Parsing\Type\ProjectInformation\ProjectTrace>|null $projectTraces
     * @param array<\Avolle\KnxProject\Parsing\Type\ProjectInformation\DeviceCertificate>|null $deviceCertificates
     */
    public function __construct(
        #[MapFrom('@Name')]
        #[CastToType('string')]
        public string $name,

        #[MapFrom('@GroupAddressStyle')]
        #[CastToEnum(GroupAddressStyle::ThreeLevel)]
        public GroupAddressStyle|string $groupAddressStyle,

        #[MapFrom('@ProjectNumber')]
        #[CastToType('string')]
        public ?string $projectNumber,

        #[MapFrom('@ContractNumber')]
        #[CastToType('string')]
        public ?string $contractNumber,

        #[MapFrom('@LastModified')]
        #[CastToDateTimeImmutable]
        public ?DateTimeImmutable $lastModified,

        #[MapFrom('@ArchivedVersion')]
        #[CastToDateTimeImmutable]
        public ?DateTimeImmutable $archivedVersion,

        #[MapFrom('@ProjectStart')]
        #[CastToDateTimeImmutable]
        public ?DateTimeImmutable $projectStart,

        #[MapFrom('@ProjectEnd')]
        #[CastToDateTimeImmutable]
        public ?DateTimeImmutable $projectEnd,

        #[MapFrom('@ProjectType')]
        #[CastToEnum(ProjectType::OtherOther)]
        public ProjectType|string|null $projectType,

        #[MapFrom('@ProjectId')]
        public ?int $projectId,

        #[MapFrom('@Comment')]
        public ?string $comment,

        #[MapFrom('@CompletionStatus')]
        #[CastToEnum(CompletionStatus::Unknown)]
        public CompletionStatus|string|null $completionStatus,

        #[MapFrom('@ProjectTracingLevel')]
        #[CastToEnum(ProjectTracingLevel::None)]
        public ProjectTracingLevel|string|null $projectTracingLevel,

        #[MapFrom('@ProjectTracingPassword')]
        public ?string $projectTracingPassword,

        #[MapFrom('@Hide16BitGroupsFromLegacyPlugins')]
        #[CastToBool(false)]
        public ?bool $hide16BitGroupsFromLegacyPlugins,

        #[MapFrom('@CodePage')]
        public ?string $codePage,

        #[MapFrom('@BusAccessLegacyMode')]
        #[CastToBool(false)]
        public ?bool $busAccessLegacyMode,

        #[MapFrom('@Guid')]
        public string $guId,

        #[MapFrom('@LastUsedPuid')]
        public int $lastUsedPuId,

        #[MapFrom('@Security')]
        #[CastToEnum(Security::Auto)]
        public Security|string|null $security,

        #[MapFrom('Tags')]
        #[CastExtractFromArrayKey('Tag')]
        #[CastToListArray]
        #[CastListToType(Tag::class)]
        public ?array $tags = [],

        #[MapFrom('HistoryEntries')]
        #[CastExtractFromArrayKey('HistoryEntry')]
        #[CastToListArray]
        #[CastListToType(HistoryEntry::class)]
        public ?array $historyEntries = [],

        #[MapFrom('ToDoItems')]
        #[CastExtractFromArrayKey('ToDoItem')]
        #[CastToListArray]
        #[CastListToType(ToDoItem::class)]
        public ?array $toDoItems = [],

        #[MapFrom('ProjectTraces')]
        #[CastExtractFromArrayKey('ProjectTrace')]
        #[CastToListArray]
        #[CastListToType(ProjectTrace::class)]
        public ?array $projectTraces = [],

        #[MapFrom('DeviceCertificates')]
        #[CastExtractFromArrayKey('DeviceCertificate')]
        #[CastToListArray]
        #[CastListToType(DeviceCertificate::class)]
        public ?array $deviceCertificates = [],
    ) {
    }
}
