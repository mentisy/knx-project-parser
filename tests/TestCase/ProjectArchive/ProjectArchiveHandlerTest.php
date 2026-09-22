<?php
declare(strict_types=1);

namespace Avolle\KnxProject\Test\TestCase\ProjectArchive;

use Avolle\KnxProject\Exception\ArchiveFileNotFoundException;
use Avolle\KnxProject\ProjectArchive\ProjectArchiveHandler;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class ProjectArchiveHandlerTest extends TestCase
{
    /**
     * Test openFromFile method.
     *
     * @return void
     * @throws \Avolle\KnxProject\Exception\ArchiveFileNotFoundException
     */
    #[Test]
    public function openFromFile(): void
    {
        $fileZipArchive = TEST_FILES . 'projects' . DS . 'password-protected.knxproj';

        $handler = new ProjectArchiveHandler();
        $archive = $handler->openFromFile($fileZipArchive);
        $this->assertEquals('P-072A', $archive->projectId());
    }

    /**
     * Test openFromFile method.
     * Could not open, so expect exception.
     *
     * @return void
     * @throws \Avolle\KnxProject\Exception\ArchiveFileNotFoundException
     */
    #[Test]
    public function openFromFileError(): void
    {
        $fileNotZipArchive = TEST_FILES . 'projects' . DS . 'not-a-zip-archive.txt';
        $this->expectException(ArchiveFileNotFoundException::class);
        $this->expectExceptionMessage("Archive file `$fileNotZipArchive` could not be opened: Not a zip archive");

        $handler = new ProjectArchiveHandler();
        $handler->openFromFile($fileNotZipArchive);
    }
}
