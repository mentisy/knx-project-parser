<?php
declare(strict_types=1);

namespace Avolle\KnxProject\ProjectArchive;

use Avolle\KnxProject\Exception\ArchiveFileNotFoundException;
use ZipArchive;

/**
 * Open KNX project files (.knxproj).
 */
class ProjectArchiveHandler
{
    /**
     * Error codes translated to human-readable error message.
     *
     * @var array<false|int, string>
     */
    protected array $errorMessages = [
        false => 'Unknown reason',
        ZipArchive::ER_EXISTS => 'File already exists.',
        ZipArchive::ER_INCONS => 'Zip archive inconsistent.',
        ZipArchive::ER_INVAL => 'Invalid argument.',
        ZipArchive::ER_MEMORY => 'Malloc failure.',
        ZipArchive::ER_NOENT => 'No such file.',
        ZipArchive::ER_NOZIP => 'Not a zip archive.',
        ZipArchive::ER_OPEN => 'Can\'t open file.',
        ZipArchive::ER_READ => 'Read error.',
        ZipArchive::ER_SEEK => 'Seek error.',
    ];

    /**
     * Open a KNX project file from the provided file path.
     *
     * @param string $archiveFilePath Path to KNX project file to open.
     * @return \Avolle\KnxProject\ProjectArchive\ProjectArchive A successfully opened Zip archive.
     * @throws \Avolle\KnxProject\Exception\ArchiveFileNotFoundException When not successfully opened Zip archive.
     */
    public function openFromFile(string $archiveFilePath): ProjectArchive
    {
        if (!file_exists($archiveFilePath)) {
            throw new ArchiveFileNotFoundException(sprintf("Project file '%s' not found.", $archiveFilePath));
        }

        $zip = new ZipArchive();
        // If successfully opened, it will return true. If not successful, returns either false or an integer error code.
        $opened = $zip->open($archiveFilePath);
        if ($opened !== true) {
            throw new ArchiveFileNotFoundException($this->errorMessage($archiveFilePath, $opened));
        }

        return new ProjectArchive($zip);
    }

    /**
     * Create a more readable error message.
     *
     * @param string $path Path to file attempted to open.
     * @param false|int $errorCode Error code from opening Zip file.
     * @return string Human-readable error message.
     */
    protected function errorMessage(string $path, false|int $errorCode): string
    {
        $errorCodeString = $this->errorMessages[$errorCode] ?? 'Unknown reason';

        return sprintf("Archive file `%s` could not be opened: %s", $path, $errorCodeString);
    }
}
