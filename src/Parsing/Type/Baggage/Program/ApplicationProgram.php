<?php
declare(strict_types=1);

namespace Avolle\KnxProject\Parsing\Type\Baggage\Program;

use Avolle\KnxProject\Parsing\Caster\CastToBool;
use EventSauce\ObjectHydrator\MapFrom;

class ApplicationProgram
{
    /**
     * @param string|null $id
     * @param int|null $applicationNumber
     * @param int|null $applicationVersion
     * @param string|null $programType
     * @param string|null $maskVersion
     * @param string|null $loadProcedureStyle
     * @param int|null $peiType
     * @param string|null $defaultLanguage
     * @param bool|null $dynamicTableManagement
     * @param bool|null $linkable
     * @param string|null $originalManufacturer
     * @param bool|null $preEts4Style
     * @param bool|null $convertedFromPreEts4Data
     * @param string|null $hash
     * @param \Avolle\KnxProject\Parsing\Type\Baggage\Program\ApplicationProgramStatic|null $static
     * @param \Avolle\KnxProject\Parsing\Type\Baggage\Program\ApplicationProgramDynamic|null $dynamic
     */
    public function __construct(
        #[MapFrom('@Id')]
        public ?string $id,

        #[MapFrom('@ApplicationNumber')]
        public ?int $applicationNumber,

        #[MapFrom('@ApplicationVersion')]
        public ?int $applicationVersion,

        #[MapFrom('@ProgramType')]
        public ?string $programType,

        #[MapFrom('@MaskVersion')]
        public ?string $maskVersion,

        #[MapFrom('@LoadProcedureStyle')]
        public ?string $loadProcedureStyle,

        #[MapFrom('@PeiType')]
        public ?int $peiType,

        #[MapFrom('@DefaultLanguage')]
        public ?string $defaultLanguage,

        #[MapFrom('@DynamicTableManagement')]
        #[CastToBool(true)] //@todo verify default
        public ?bool $dynamicTableManagement,

        #[MapFrom('@Linkable')]
        #[CastToBool(true)] //@todo verify default
        public ?bool $linkable,

        #[MapFrom('@OriginalManufacturer')]
        public ?string $originalManufacturer,

        #[MapFrom('@VisibleDescription')]
        public ?string $visibleDescription,

        #[MapFrom('@Name')]
        public ?string $name,

        #[MapFrom('@PreEts4Style')]
        #[CastToBool(true)] //@todo verify default
        public ?bool $preEts4Style,

        #[MapFrom('@ConvertedFromPreEts4Data')]
        #[CastToBool(true)] //@todo verify default
        public ?bool $convertedFromPreEts4Data,

        #[MapFrom('@Hash')]
        public ?string $hash,

        #[MapFrom('Static')]
        public ?ApplicationProgramStatic $static,

        #[MapFrom('Dynamic')]
        public ?ApplicationProgramDynamic $dynamic,
    ) {
    }
}
