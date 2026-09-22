<?php
declare(strict_types=1);

namespace Avolle\KnxProject\Parsing\Type\Baggage\Hardware;

use Avolle\KnxProject\Parsing\Caster\CastExtractFromArrayKey;
use Avolle\KnxProject\Parsing\Caster\CastToArrayValues;
use Avolle\KnxProject\Parsing\Caster\CastToBool;
use Avolle\KnxProject\Parsing\Caster\CastToListArray;
use Avolle\KnxProject\Service\DeviceInconsistencyFixer\ValueExtractionException;
use EventSauce\ObjectHydrator\MapFrom;
use EventSauce\ObjectHydrator\PropertyCasters\CastListToType;

/**
 * @internal
 */
class Hardware
{
    public function __construct(
        #[MapFrom('@Id')]
        public ?string $id,

        #[MapFrom('@Name')]
        public ?string $name,

        #[MapFrom('@SerialNumber')]
        public string|int|null $serialNumber,

        #[MapFrom('@VersionNumber')]
        public ?int $versionNumber,

        #[MapFrom('@BusCurrent')]
        public int|float|null $busCurrent,

        #[MapFrom('@HasIndividualAddress')]
        #[CastToBool(true)]
        public ?bool $hasIndividualAddress,

        #[MapFrom('@HasApplicationProgram')]
        #[CastToBool(true)]
        public ?bool $hasApplicationProgram,

        #[MapFrom('Products')]
        #[CastToArrayValues]
        #[CastToListArray]
        #[CastListToType(Product::class)]
        public ?array $products = [],

        #[MapFrom('Hardware2Programs')]
        #[CastExtractFromArrayKey('Hardware2Program')]
        #[CastToListArray]
        #[CastToArrayValues]
        #[CastListToType(Hardware2Program::class)]
        public ?array $hardware2Programs = [],
    ) {
    }

    public function findHardware2Program(?string $hardware2ProgramId, ?bool $throw = true): ?Hardware2Program
    {
        foreach ($this->hardware2Programs as $hardware2Program) {
            if ($hardware2Program->id === $hardware2ProgramId) {
                return $hardware2Program;
            }
        }
        if ($throw) {
            throw new ValueExtractionException(
                sprintf('Could not extract `%s` based on %s`: %s`', 'hardware2Program', 'hardware2ProgramId', $hardware2ProgramId),
            );
        }

        return null;
    }
}
