<?php
declare(strict_types=1);

namespace Avolle\KnxProject\Parsing\Type\Baggage\Program;

use EventSauce\ObjectHydrator\MapFrom;

class Knx
{
    protected const string ETS5 = 'ETS5';
    protected const string ETS6 = 'ETS6';

    /**
     * @param string $createdBy
     * @param string $toolVersion
     * @param \Avolle\KnxProject\Parsing\Type\Baggage\Program\ManufacturerData $manufacturerData
     */
    public function __construct(
        #[MapFrom('@CreatedBy')]
        public string $createdBy,

        #[MapFrom('@ToolVersion')]
        public string $toolVersion,

        #[MapFrom('ManufacturerData')]
        public ManufacturerData $manufacturerData,
    ) {
    }

    public function isEts5(): bool
    {
        return $this->createdBy === self::ETS5;
    }

    public function isEts6(): bool
    {
        return $this->createdBy === self::ETS6;
    }
}
