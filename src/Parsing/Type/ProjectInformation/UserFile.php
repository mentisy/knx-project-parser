<?php
declare(strict_types=1);

namespace Avolle\KnxProject\Parsing\Type\ProjectInformation;

use EventSauce\ObjectHydrator\MapFrom;

/**
 * @internal
 */
class UserFile
{
    /**
     * @param string $filename
     * @param string|null $comment
     */
    public function __construct(
        #[MapFrom('@Filename')]
        public string $filename,

        #[MapFrom('@Comment')]
        public ?string $comment,
    ) {
    }
}
