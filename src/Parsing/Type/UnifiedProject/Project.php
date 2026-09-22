<?php
declare(strict_types=1);

namespace Avolle\KnxProject\Parsing\Type\UnifiedProject;

use Avolle\KnxProject\Parsing\Type\ProjectInformation\ProjectInformation;

/**
 * @internal
 */
class Project
{
    /**
     * @param string|null $id
     * @param array<\Avolle\KnxProject\Parsing\Type\ProjectInstallation\Installation>|null $installations
     * @param \Avolle\KnxProject\Parsing\Type\ProjectInformation\ProjectInformation|null $projectInformation
     * @param array<\Avolle\KnxProject\Parsing\Type\ProjectInformation\UserFile>|null $userFiles
     * @param array<\Avolle\KnxProject\Parsing\Type\ProjectInformation\AddinData>|null $addinData
     */
    public function __construct(
        public ?string $id = null,
        public ?array $installations = [],
        public ?ProjectInformation $projectInformation = null,
        public ?array $userFiles = null,
        public ?array $addinData = null,
    ) {
    }
}
