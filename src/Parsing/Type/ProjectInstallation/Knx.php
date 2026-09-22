<?php
declare(strict_types=1);

namespace Avolle\KnxProject\Parsing\Type\ProjectInstallation;

use EventSauce\ObjectHydrator\MapFrom;

/**
 * @internal
 */
class Knx
{
    protected const string ETS5 = 'ETS5';
    protected const string ETS6 = 'ETS6';

    /**
     * @param string $createdBy The short ETS version
     * @param string $toolVersion The full ETS version
     * @param \Avolle\KnxProject\Parsing\Type\ProjectInstallation\Project $project
     */
    public function __construct(
        #[MapFrom('@CreatedBy')]
        public string $createdBy,

        #[MapFrom('@ToolVersion')]
        public string $toolVersion,

        #[MapFrom('Project')]
        public Project $project,
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
