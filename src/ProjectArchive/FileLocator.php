<?php
declare(strict_types=1);

namespace Avolle\KnxProject\ProjectArchive;

use Avolle\KnxProject\Exception\ArchiveFileNotFoundException;
use Avolle\KnxProject\Exception\ProjectPasswordIncorrect;
use ZipArchive;

class FileLocator
{
    /**
     * List of files previously found in project archive.
     *
     * @var array
     */
    protected array $searchResultsCache = [];

    /**
     * Constructor.
     *
     * @param \ZipArchive $zip Zip archive of project file.
     */
    public function __construct(protected ZipArchive $zip)
    {
    }

    /**
     * Find a file matching a regex pattern. If no file is found, it throws an exception.
     *
     * @param string $regex Regex pattern to match against file names
     * @param \ZipArchive|null $fromZipFile An optional Zip Archive instance to find file in. If none is provided, use the class-provided one.
     * @return string
     * @throws \Avolle\KnxProject\Exception\ArchiveFileNotFoundException
     */
    public function findFile(string $regex, ?ZipArchive $fromZipFile = null): string
    {
        if (!$fromZipFile && isset($this->searchResultsCache[$regex])) {
            return $this->searchResultsCache[$regex];
        }
        $zip = $fromZipFile ?? $this->zip;
        for ($i = 0; $i < $zip->numFiles; $i++) {
            $file = $zip->statIndex($i);
            $path = $file['name'];
            if (preg_match($regex, $path)) {
                if (!$fromZipFile) {
                    $this->searchResultsCache[$regex] = $path;
                }

                return $path;
            }
        }
        throw new ArchiveFileNotFoundException("Requested archive file was not found, using regex `$regex`");
    }

    /**
     * Find all files matching a regex pattern. If no files are found, it throws an exception.
     *
     * @param string $regex Regex pattern to match against file names
     * @param \ZipArchive|null $fromZipFile An optional Zip Archive instance to find files in. If none is provided, use the class-provided one.
     * @return array
     */
    public function findFiles(string $regex, ?ZipArchive $fromZipFile = null): array
    {
        $files = [];
        $zip = $fromZipFile ?? $this->zip;
        for ($i = 0; $i < $zip->numFiles; $i++) {
            $file = $zip->statIndex($i);
            $path = $file['name'];
            if (preg_match($regex, $path, $matches)) {
                if (!$fromZipFile) {
                    $this->searchResultsCache[$regex] = $matches[1];
                }
                $files[] = $matches[1];
            }
        }

        return $files;
    }

    /**
     * Return contents of a specific file. It throws an exception if no file is found.
     *
     * @param string $filePath Complete path to file, relative to ZIP file.
     * @param \ZipArchive|null $fromZipFile An optional Zip Archive instance to find files in. If none is provided, use the class-provided one.
     * @return string
     * @throws \Avolle\KnxProject\Exception\ArchiveFileNotFoundException
     * @throws \Avolle\KnxProject\Exception\ProjectPasswordIncorrect
     */
    public function getFileContents(string $filePath, ?ZipArchive $fromZipFile = null): string
    {
        $zip = $fromZipFile ?? $this->zip;
        $content = $zip->getFromName($filePath);
        if ($content === false) {
            if ($zip->numFiles > 0) {
                $content = $zip->getFromIndex(0);
                if ($content === false) {
                    throw new ProjectPasswordIncorrect('Archive password is incorrect');
                }
            }
            throw new ArchiveFileNotFoundException("Archive file `$filePath` not found.");
        }

        return $content;
    }
}
