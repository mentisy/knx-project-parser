<?php
declare(strict_types=1);

namespace Avolle\KnxProject\Parsing\Type\ProjectInstallation\Topology\Device;

use Avolle\KnxProject\Parsing\Caster\CastToEnum;
use Avolle\KnxProject\Parsing\Type\Enum\IpConfigAssign;
use EventSauce\ObjectHydrator\MapFrom;

/**
 * @internal
 */
class IpConfig
{
    public function __construct(
        #[MapFrom('@Assign')]
        #[CastToEnum(IpConfigAssign::Auto)]
        public IpConfigAssign|string|null $assign,

        #[MapFrom('@IPAddress')]
        public ?string $ipAddress,

        #[MapFrom('@SubnetMask')]
        public ?string $subnetMask,

        #[MapFrom('@DefaultGateway')]
        public ?string $defaultGateway,

        #[MapFrom('@MACAddress')]
        public ?string $macAddress,
    ) {
    }
}
