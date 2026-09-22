<?php
declare(strict_types=1);

namespace Avolle\KnxProject\Test\TestCase\ProjectArchive;

use Avolle\KnxProject\ProjectArchive\ProjectFilesInformation;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class ProjectFilesInformationTest extends TestCase
{
    /**
     * Project id to use in all tests.
     */
    protected const string PROJECT_ID = 'P-0125';

    /**
     * Manufacturer id to use in all tests.
     */
    protected const string MANUFACTURER_ID = '00AA';

    /**
     * Test projectFilePasswordProtected method.
     *
     * @return void
     */
    #[Test]
    public function projectFilePasswordProtected(): void
    {
        $expected = 'P-0125.zip';
        $actual = ProjectFilesInformation::projectFilePasswordProtected(static::PROJECT_ID);
        $this->assertEquals($expected, $actual);
    }

    /**
     * Test projectInformationFile method.
     *
     * @return void
     */
    #[Test]
    public function projectInformationFile(): void
    {
        $expected = static::PROJECT_ID . '/project.xml';
        $actual = ProjectFilesInformation::projectInformationFile(static::PROJECT_ID);
        $this->assertEquals($expected, $actual);

        // Password-protected (no project-id prefix)
        $expected = 'project.xml';
        $actual = ProjectFilesInformation::projectInformationFile(static::PROJECT_ID, passwordProtected: true);
        $this->assertEquals($expected, $actual);
    }

    /**
     * Test projectInstallationFile method.
     *
     * @return void
     */
    #[Test]
    public function projectInstallationFile(): void
    {
        $expected = static::PROJECT_ID . '/0.xml';
        $actual = ProjectFilesInformation::projectInstallationFile(static::PROJECT_ID);
        $this->assertEquals($expected, $actual);

        // Password-protected (no project-id prefix)
        $expected = '0.xml';
        $actual = ProjectFilesInformation::projectInstallationFile(static::PROJECT_ID, passwordProtected: true);
        $this->assertEquals($expected, $actual);
    }

    /**
     * Test projectImageFile method.
     *
     * @return void
     */
    #[Test]
    public function projectImageFile(): void
    {
        $expected = static::PROJECT_ID . '/project.jpg';
        $actual = ProjectFilesInformation::projectImageFile(static::PROJECT_ID);
        $this->assertEquals($expected, $actual);

        // Password-protected (no project-id prefix)
        $expected = 'project.jpg';
        $actual = ProjectFilesInformation::projectImageFile(static::PROJECT_ID, passwordProtected: true);
        $this->assertEquals($expected, $actual);
    }

    /**
     * Test userFilesFolderRegex method.
     *
     * @return void
     */
    #[Test]
    public function userFilesFolderRegex(): void
    {
        $expected = '/P\-0125\/UserFiles\/(.+)/';
        $actual = ProjectFilesInformation::userFilesFolderRegex(static::PROJECT_ID);
        $this->assertEquals($expected, $actual);

        // Password-protected (no project-id prefix)
        $expected = '/UserFiles\/(.+)/';
        $actual = ProjectFilesInformation::userFilesFolderRegex(static::PROJECT_ID, passwordProtected: true);
        $this->assertEquals($expected, $actual);
    }

    /**
     * Test userFile method.
     *
     * @return void
     */
    #[Test]
    public function userFile(): void
    {
        $filename = 'some-file.pdf';
        $expected = static::PROJECT_ID . "/UserFiles/$filename";
        $actual = ProjectFilesInformation::userFile(static::PROJECT_ID, $filename);
        $this->assertEquals($expected, $actual);

        // Password-protected (no project-id prefix)
        $expected = "UserFiles/$filename";
        $actual = ProjectFilesInformation::userFile(static::PROJECT_ID, $filename, passwordProtected: true);
        $this->assertEquals($expected, $actual);
    }

    /**
     * Test binaryData method.
     *
     * @return void
     */
    #[Test]
    public function binaryData(): void
    {
        $filename = 'P-0125-0_DI-368_BLOB.5FPARA.dat';

        $expected = static::PROJECT_ID . "/BinaryData/$filename";
        $actual = ProjectFilesInformation::binaryData(static::PROJECT_ID, $filename);
        $this->assertEquals($expected, $actual);

        // Password-protected (no project-id prefix)
        $expected = "BinaryData/$filename";
        $actual = ProjectFilesInformation::binaryData(static::PROJECT_ID, $filename, passwordProtected: true);
        $this->assertEquals($expected, $actual);
    }

    /**
     * Test projectInfoFile method.
     *
     * @return void
     */
    #[Test]
    public function projectInfoFile(): void
    {
        $expected = '/P-[0-9A-Z]+\.info/i';
        $actual = ProjectFilesInformation::projectInfoFile();
        $this->assertEquals($expected, $actual);

        // With project id already known.
        $expected = 'P-0125.info';
        $actual = ProjectFilesInformation::projectInfoFile(static::PROJECT_ID);
        $this->assertEquals($expected, $actual);
    }

    /**
     * Test baggageSignatureFile method.
     *
     * @return void
     */
    #[Test]
    public function baggageSignatureFile(): void
    {
        $expected = '00AA.signature';
        $actual = ProjectFilesInformation::baggageSignatureFile(static::MANUFACTURER_ID);
        $this->assertEquals($expected, $actual);
    }

    /**
     * Test baggageCatalogFile method.
     *
     * @return void
     */
    #[Test]
    public function baggageCatalogFile(): void
    {
        $expected = '00AA/Catalog.xml';
        $actual = ProjectFilesInformation::baggageCatalogFile(static::MANUFACTURER_ID);
        $this->assertEquals($expected, $actual);
    }

    /**
     * Test baggageHardwareFile method.
     *
     * @return void
     */
    #[Test]
    public function baggageHardwareFile(): void
    {
        $expected = '00AA/Hardware.xml';
        $actual = ProjectFilesInformation::baggageHardwareFile(static::MANUFACTURER_ID);
        $this->assertEquals($expected, $actual);
    }

    /**
     * Test baggageProgramFile method.
     *
     * @return void
     */
    #[Test]
    public function baggageProgramFile(): void
    {
        $productId = 'M-00AA_A-0000-01-9542';
        $expected = "00AA/$productId.xml";
        $actual = ProjectFilesInformation::baggageProgramFile(static::MANUFACTURER_ID, $productId);
        $this->assertEquals($expected, $actual);
    }
}
