<?php
declare(strict_types=1);

namespace Avolle\KnxProject\Parsing\Type\Master;

use EventSauce\ObjectHydrator\MapFrom;

/**
 * @internal
 */
class Manufacturer
{
    /**
     * @param string|null $id
     * @param int|null $manufacturerId
     * @param string|null $name
     * @param string|null $defaultLanguage
     * @param string|null $importRestriction
     * @param string|null $importGroup
     * @param string|null $memberStatus
     */
    public function __construct(
        #[MapFrom('@Id')]
        public ?string $id,

        #[MapFrom('@KnxManufacturerId')]
        public ?int $manufacturerId,

        #[MapFrom('@Name')]
        public ?string $name,

        #[MapFrom('@DefaultLanguage')]
        public ?string $defaultLanguage,

        #[MapFrom('@ImportRestriction')]
        public ?string $importRestriction,

        #[MapFrom('@ImportGroup')]
        public ?string $importGroup,

        #[MapFrom('@MemberStatus')]
        public ?string $memberStatus,
    ) {
    }

    public function isActiveMember(): bool
    {
        return $this->memberStatus === 'Active';
    }
}
