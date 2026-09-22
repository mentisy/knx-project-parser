<?php
declare(strict_types=1);

namespace Avolle\KnxProject\Parsing\Type\Archive;

/**
 * @internal
 */
class InfoFile
{
    public function __construct(
        public string $projectName,
        public string $projectGuid,
        public bool $isPasswordProtected,
    ) {
    }

    public static function fromArray(array $array): static
    {
        return new static(
            $array['ProjectName'],
            $array['ProjectGuid'],
            $array['IsPasswordProtected'],
        );
    }

    /**
     * Return info file metadata as an array.
     *
     * @return array{projectName: string, projectGuid: string, isPasswordProtected: bool}
     */
    public function toArray(): array
    {
        return [
            'projectName' => $this->projectName,
            'projectGuid' => $this->projectGuid,
            'isPasswordProtected' => $this->isPasswordProtected,
        ];
    }
}
