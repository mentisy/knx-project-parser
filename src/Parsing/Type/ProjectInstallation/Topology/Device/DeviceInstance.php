<?php
declare(strict_types=1);

namespace Avolle\KnxProject\Parsing\Type\ProjectInstallation\Topology\Device;

use Avolle\KnxProject\Parsing\Caster\CastExtractFromArrayKey;
use Avolle\KnxProject\Parsing\Caster\CastToBool;
use Avolle\KnxProject\Parsing\Caster\CastToEnum;
use Avolle\KnxProject\Parsing\Caster\CastToListArray;
use Avolle\KnxProject\Parsing\Type\Enum\CompletionStatus;
use DateTimeImmutable;
use EventSauce\ObjectHydrator\MapFrom;
use EventSauce\ObjectHydrator\PropertyCasters\CastListToType;
use EventSauce\ObjectHydrator\PropertyCasters\CastToDateTimeImmutable;
use EventSauce\ObjectHydrator\PropertyCasters\CastToType;

/**
 * @internal
 */
class DeviceInstance
{
    /**
     * @param string $id
     * @param string|null $name
     * @param string $productRefId
     * @param string|null $hardware2ProgramRefId
     * @param int|null $address
     * @param string|null $comment
     * @param \DateTimeImmutable|null $lastModified
     * @param \DateTimeImmutable|null $lastDownload
     * @param int|null $lastUsedApduLength
     * @param int|null $readMaxApduLength
     * @param string|null $installationHints
     * @param \Avolle\KnxProject\Parsing\Type\Enum\CompletionStatus|string|null $completionStatus
     * @param string|null $loadedImage
     * @param string|null $checkSums
     * @param string|null $description
     * @param int|null $downloadCounter
     * @param bool|null $broken
     * @param string|null $serialNumber
     * @param string|null $uniqueId
     * @param bool|null $isRfRetransmitter
     * @param bool|null $isSlowResender
     * @param int|null $puId
     * @param string|null $initialValueLanguage
     * @param \Avolle\KnxProject\Parsing\Type\ProjectInstallation\Topology\Device\GroupObjectTree|null $groupObjectTree
     * @param \Avolle\KnxProject\Parsing\Type\ProjectInstallation\Topology\Device\BinaryData|null $binaryData
     * @param \Avolle\KnxProject\Parsing\Type\ProjectInstallation\Topology\Device\IpConfig|null $ipConfig
     * @param \Avolle\KnxProject\Parsing\Type\ProjectInstallation\Topology\Device\Security|null $security
     * @param array<\Avolle\KnxProject\Parsing\Type\ProjectInstallation\Topology\Device\BusInterface>|null $busInterfaces
     * @param bool|null $individualAddressLoaded
     * @param bool|null $applicationProgramLoaded
     * @param bool|null $parametersLoaded
     * @param bool|null $communicationPartLoaded
     * @param bool|null $mediumConfigLoaded
     * @param bool|null $isActivityCalculated
     * @param array<\Avolle\KnxProject\Parsing\Type\ProjectInstallation\Topology\Device\ParameterInstanceRef>|null $parameterInstanceRefs
     * @param array<\Avolle\KnxProject\Parsing\Type\ProjectInstallation\Topology\Device\ComObjectInstanceRef>|null $comObjectInstanceRefs
     * @param array<\Avolle\KnxProject\Parsing\Type\ProjectInstallation\Topology\Device\ModuleInstance>|null $moduleInstances
     * @param array<\Avolle\KnxProject\Parsing\Type\ProjectInstallation\Topology\Device\AdditionalAddress>|null $additionalAddresses
     */
    public function __construct(
        #[MapFrom('@Id')]
        public string $id,

        #[MapFrom('@Name')]
        #[CastToType('string')]
        public ?string $name,

        #[MapFrom('@ProductRefId')]
        public string $productRefId,

        #[MapFrom('@Hardware2ProgramRefId')]
        public ?string $hardware2ProgramRefId,

        #[MapFrom('@Address')]
        public ?int $address,

        #[MapFrom('@Comment')]
        public ?string $comment,

        #[MapFrom('@LastModified')]
        #[CastToDateTimeImmutable]
        public ?DateTimeImmutable $lastModified,

        #[MapFrom('@LastDownload')]
        #[CastToDateTimeImmutable]
        public ?DateTimeImmutable $lastDownload,

        #[MapFrom('@LastUsedAPDULength')]
        public ?int $lastUsedApduLength,

        #[MapFrom('@ReadMaxAPDULength')]
        public ?int $readMaxApduLength,

        #[MapFrom('@InstallationHints')]
        public ?string $installationHints,

        #[MapFrom('@CompletionStatus')]
        #[CastToEnum(CompletionStatus::Unknown)]
        public CompletionStatus|string|null $completionStatus,

        #[MapFrom('@LoadedImage')]
        public ?string $loadedImage,

        #[MapFrom('@CheckSums')]
        public ?string $checkSums,

        #[MapFrom('@Description')]
        #[CastToType('string')]
        public ?string $description,

        #[MapFrom('@DownloadCounter')]
        public ?int $downloadCounter,

        #[MapFrom('@Broken')]
        #[CastToBool(false)]
        public ?bool $broken,

        #[MapFrom('@SerialNumber')]
        public ?string $serialNumber,

        #[MapFrom('@UniqueId')]
        public ?string $uniqueId,

        #[MapFrom('@IsRFRetransmitter')]
        #[CastToBool(false)]
        public ?bool $isRfRetransmitter,

        #[MapFrom('@IsSlowResender')]
        #[CastToBool(false)]
        public ?bool $isSlowResender,

        #[MapFrom('@Puid')]
        public ?int $puId,

        #[MapFrom('@InitialValueLanguage')]
        public ?string $initialValueLanguage,

        #[MapFrom('GroupObjectTree')]
        public ?GroupObjectTree $groupObjectTree,

        #[MapFrom('BinaryData')]
        #[CastExtractFromArrayKey('BinaryData')]
        public ?BinaryData $binaryData,

        #[MapFrom('IPConfig')]
        public ?IpConfig $ipConfig,

        #[MapFrom('Security')]
        #[CastToType('array')]
        public ?Security $security,

        #[MapFrom('BusInterfaces')]
        #[CastExtractFromArrayKey('BusInterface')]
        #[CastToListArray]
        #[CastListToType(BusInterface::class)]
        public ?array $busInterfaces = [],

        #[MapFrom('@IndividualAddressLoaded')]
        #[CastToBool(false)]
        public ?bool $individualAddressLoaded = false,

        #[MapFrom('@ApplicationProgramLoaded')]
        #[CastToBool(false)]
        public ?bool $applicationProgramLoaded = false,

        #[MapFrom('@ParametersLoaded')]
        #[CastToBool(false)]
        public ?bool $parametersLoaded = false,

        #[MapFrom('@CommunicationPartLoaded')]
        #[CastToBool(false)]
        public ?bool $communicationPartLoaded = false,

        #[MapFrom('@MediumConfigLoaded')]
        #[CastToBool(false)]
        public ?bool $mediumConfigLoaded = false,

        #[MapFrom('@IsActivityCalculated')]
        #[CastToBool(false)]
        public ?bool $isActivityCalculated = false,

        #[MapFrom('ParameterInstanceRefs')]
        #[CastExtractFromArrayKey('ParameterInstanceRef')]
        #[CastToListArray]
        #[CastListToType(ParameterInstanceRef::class)]
        public ?array $parameterInstanceRefs = [],

        #[MapFrom('ComObjectInstanceRefs')]
        #[CastExtractFromArrayKey('ComObjectInstanceRef')]
        #[CastToListArray]
        #[CastListToType(ComObjectInstanceRef::class)]
        public ?array $comObjectInstanceRefs = [],

        #[MapFrom('ModuleInstances')]
        #[CastExtractFromArrayKey('ModuleInstance')]
        #[CastToListArray]
        #[CastListToType(ModuleInstance::class)]
        public ?array $moduleInstances = [],

        #[MapFrom('AdditionalAddresses')]
        #[CastExtractFromArrayKey('Address')]
        #[CastToListArray]
        #[CastListToType(AdditionalAddress::class)]
        public ?array $additionalAddresses = [],
    ) {
    }

    /**
     * Extract the baggage id based on the product ref id.
     *
     * @return string
     */
    public function productRefIdToBaggageId(): string
    {
        $delimiter = '_';
        [$baggageId] = explode($delimiter, $this->productRefId);

        return $baggageId;
    }

    /**
     * Extract the hardware id based on the product ref id.
     *
     * @return string
     */
    public function productRefIdToHardwareId(): string
    {
        $delimiter = '_';
        [$baggageId, $hardwareId] = explode($delimiter, $this->productRefId);

        return implode($delimiter, [$baggageId, $hardwareId]);
    }
}
