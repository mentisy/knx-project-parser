<?php
declare(strict_types=1);

namespace Avolle\KnxProject\Parsing\Type\ProjectInstallation\Topology\Device;

use Avolle\KnxProject\Parsing\Caster\CastToBool;
use EventSauce\ObjectHydrator\MapFrom;

/**
 * @internal
 */
class BusInterface
{
    public function __construct(
        #[MapFrom('@RefId')]
        public string $refId,

        #[MapFrom('@Name')]
        public ?string $name,

        #[MapFrom('@Description')]
        public ?string $description,

        #[MapFrom('@Comment')]
        public ?string $comment,

        #[MapFrom('@Password')]
        public ?string $password,

        #[MapFrom('@PasswordHash')]
        public ?string $passwordHash,

        #[MapFrom('@IsSecureEnabled')]
        #[CastToBool(false)]
        public ?bool $isSecureEnabled,
    ) {
    }
}
