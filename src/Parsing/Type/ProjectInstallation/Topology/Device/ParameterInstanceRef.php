<?php
declare(strict_types=1);

namespace Avolle\KnxProject\Parsing\Type\ProjectInstallation\Topology\Device;

use Avolle\KnxProject\Parsing\Caster\CastToBool;
use EventSauce\ObjectHydrator\MapFrom;

/**
 * @internal
 */
class ParameterInstanceRef
{
    /**
     * @param string|null $id
     * @param string $refId
     * @param string|int|float|null $value
     * @param bool|null $grantUseByCustomer
     * @param string|null $customizedText
     */
    public function __construct(
        #[MapFrom('@Id')]
        public ?string $id,

        #[MapFrom('@RefId')]
        public string $refId,

        #[MapFrom('@Value')]
        public string|int|float|null $value,

        #[MapFrom('@GrantUseByCustomer')]
        #[CastToBool(false)]
        public ?bool $grantUseByCustomer,

        #[MapFrom('@CustomizedText')]
        public ?string $customizedText,
    ) {
    }
}
