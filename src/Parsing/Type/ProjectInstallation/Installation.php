<?php
declare(strict_types=1);

namespace Avolle\KnxProject\Parsing\Type\ProjectInstallation;

use Avolle\KnxProject\Parsing\Caster\CastExtractFromArrayKey;
use Avolle\KnxProject\Parsing\Caster\CastToArrayValues;
use Avolle\KnxProject\Parsing\Caster\CastToEnum;
use Avolle\KnxProject\Parsing\Caster\CastToListArray;
use Avolle\KnxProject\Parsing\Type\Enum\CompletionStatus;
use Avolle\KnxProject\Parsing\Type\Enum\InstallationIpRoutingBackboneSecurity;
use Avolle\KnxProject\Parsing\Type\ProjectInstallation\GroupAddresses\GroupAddresses;
use Avolle\KnxProject\Parsing\Type\ProjectInstallation\Locations\Space;
use Avolle\KnxProject\Parsing\Type\ProjectInstallation\Topology\Topology;
use EventSauce\ObjectHydrator\MapFrom;
use EventSauce\ObjectHydrator\PropertyCasters\CastListToType;

/**
 * @internal
 */
class Installation
{
    /**
     * The BCU key value that is defined when one is not really set.
     */
    protected const string EMPTY_BCU_VALUE = 'ffffffff';

    /**
     * @param string $name
     * @param int|null $installationId
     * @param int|null $bcuKey
     * @param string|null $ipRoutingMulticastAddress
     * @param int|null $multicastTtl
     * @param string|null $ipRoutingBackboneKey
     * @param int|null $ipRoutingLatencyTolerance
     * @param int|float|null $ipSyncLatencyFunction
     * @param string|null $ipRoutingBackboneSecurity
     * @param string|null $defaultLine
     * @param \Avolle\KnxProject\Parsing\Type\Enum\CompletionStatus|string|null $completionStatus
     * @param string|null $splitType
     * @param string|null $context
     * @param int|null $ipv6InstallationId
     * @param \Avolle\KnxProject\Parsing\Type\ProjectInstallation\Topology\Topology $topology
     * @param array<\Avolle\KnxProject\Parsing\Type\ProjectInstallation\Locations\Space> $locations
     * @param \Avolle\KnxProject\Parsing\Type\ProjectInstallation\GroupAddresses\GroupAddresses|null $groupAddresses
     * @param array<\Avolle\KnxProject\Parsing\Type\ProjectInstallation\Trade>|null $trades
     */
    public function __construct(
        #[MapFrom('@Name')]
        public string $name,

        #[MapFrom('@InstallationId')]
        public ?int $installationId,

        #[MapFrom('@BCUKey')]
        public ?int $bcuKey,

        #[MapFrom('@IPRoutingMulticastAddress')]
        public ?string $ipRoutingMulticastAddress,

        #[MapFrom('@MulticastTTL')]
        public ?int $multicastTtl,

        #[MapFrom('@IPRoutingBackboneKey')]
        public ?string $ipRoutingBackboneKey,

        #[MapFrom('@IPRoutingLatencyTolerance')]
        public ?int $ipRoutingLatencyTolerance,

        #[MapFrom('@IPSyncLatencyFunction')]
        public int|float|null $ipSyncLatencyFunction,

        #[MapFrom('@IPRoutingBackboneSecurity')]
        #[CastToEnum(InstallationIpRoutingBackboneSecurity::Auto)]
        public ?string $ipRoutingBackboneSecurity,

        #[MapFrom('@DefaultLine')]
        public ?string $defaultLine,

        #[MapFrom('@CompletionStatus')]
        #[CastToEnum(CompletionStatus::Unknown)]
        public CompletionStatus|string|null $completionStatus,

        #[MapFrom('@SplitType')]
        public ?string $splitType,

        #[MapFrom('@Context')]
        public ?string $context,

        #[MapFrom('@Ipv6InstallationId')]
        public ?int $ipv6InstallationId,

        #[MapFrom('Topology')]
        public Topology $topology,

        #[MapFrom('Locations')]
        #[CastToArrayValues]
        #[CastListToType(Space::class)]
        public array $locations,

        #[MapFrom('GroupAddresses')]
        public ?GroupAddresses $groupAddresses,

        #[MapFrom('Trades')]
        #[CastExtractFromArrayKey('Trade')]
        #[CastToListArray]
        #[CastListToType(Trade::class)]
        public ?array $trades = [],
    ) {
    }

    /**
     * Return the BCU key as a hexadecimal value (how it is inserted/read in ETS)
     *
     * @return string
     */
    public function bcuKeyAsHex(): string
    {
        if ($this->bcuKey === null) {
            return '';
        }
        $hex = dechex($this->bcuKey);
        if ($hex === self::EMPTY_BCU_VALUE) {
            return '';
        }

        return $hex;
    }
}
