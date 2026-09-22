<?php
declare(strict_types=1);

namespace Avolle\KnxProject\Parsing\Type\ProjectInformation;

use Avolle\KnxProject\Parsing\Caster\CastExtractFromArrayKey;
use Avolle\KnxProject\Parsing\Caster\CastToListArray;
use EventSauce\ObjectHydrator\MapFrom;
use EventSauce\ObjectHydrator\PropertyCasters\CastListToType;

/**
 * @internal
 */
class Project
{
    /**
     * @param \Avolle\KnxProject\Parsing\Type\ProjectInformation\ProjectInformation|null $projectInformation
     * @param array<\Avolle\KnxProject\Parsing\Type\ProjectInformation\UserFile>|null $userFiles
     * @param array<\Avolle\KnxProject\Parsing\Type\ProjectInformation\AddinData>|null $addinData
     */
    public function __construct(
        #[MapFrom('ProjectInformation')]
        public ?ProjectInformation $projectInformation,

        #[MapFrom('UserFiles')]
        #[CastExtractFromArrayKey('UserFile')]
        #[CastToListArray]
        #[CastListToType(UserFile::class)]
        public ?array $userFiles,

        #[MapFrom('AddinData')]
        #[CastExtractFromArrayKey('AddinData')]
        #[CastToListArray]
        #[CastListToType(AddinData::class)]
        public ?array $addinData,
    ) {
    }
}
