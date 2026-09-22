<?php
declare(strict_types=1);

namespace Avolle\KnxProject\Test\TestCase\ProjectArchive;

use Avolle\KnxProject\Exception\ProjectPasswordIncorrect;
use Avolle\KnxProject\Parsing\Type\ProjectInstallation\Topology\Device\DeviceInstance;
use Avolle\KnxProject\ProjectArchive\ProjectArchiveHandler;
use DateTimeImmutable;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class ProjectArchiveTest extends TestCase
{
    /**
     * Test opening a password-protected project archive.
     *
     * @return void
     * @throws \Avolle\KnxProject\Exception\ArchiveFileNotFoundException
     * @throws \Avolle\KnxProject\Exception\ProjectIsPasswordProtectedException
     * @throws \Avolle\KnxProject\Exception\ProjectPasswordIncorrect
     */
    #[Test]
    public function openPasswordProtected(): void
    {
        $testFile = TEST_FILES . 'projects' . DS . 'password-protected.knxproj';
        $handler = new ProjectArchiveHandler();
        $archive = $handler->openFromFile($testFile);
        $archive->setPassword('Password-Protected');
        $installation = $archive->projectInstallationFile();
        $this->assertTrue($installation->isEts6());
    }

    /**
     * Test opening a password-protected project archive. The password is invalid, so it should throw exception.
     *
     * @return void
     * @throws \Avolle\KnxProject\Exception\ArchiveFileNotFoundException
     * @throws \Avolle\KnxProject\Exception\ProjectIsPasswordProtectedException
     */
    #[Test]
    public function openPasswordProtectedPasswordIsWrong(): void
    {
        $this->expectException(ProjectPasswordIncorrect::class);
        $this->expectExceptionMessage('Archive password is incorrect');

        $testFile = TEST_FILES . 'projects' . DS . 'password-protected.knxproj';
        $handler = new ProjectArchiveHandler();
        $archive = $handler->openFromFile($testFile);
        $archive->setPassword('Invalid Password');
        $archive->projectInstallationFile();
    }

    /**
     * Test projectImage method.
     *
     * @return void
     * @throws \Avolle\KnxProject\Exception\ArchiveFileNotFoundException
     * @throws \Avolle\KnxProject\Exception\ProjectIsPasswordProtectedException
     * @throws \Avolle\KnxProject\Exception\ProjectPasswordIncorrect
     */
    #[Test]
    public function projectImage(): void
    {
        $testFile = TEST_FILES . 'projects' . DS . 'small-project.knxproj';
        $handler = new ProjectArchiveHandler();
        $archive = $handler->openFromFile($testFile);
        $projectImage = $archive->projectImage();
        $this->assertIsString($projectImage);
        // Let's get the first 10 chars of the file content,
        // to prevent false-positives from gibberish in file randomly spelling JFIF
        $firstTenCharsOfFile = mb_substr($projectImage, 0, 10);
        $this->assertTrue(str_contains($firstTenCharsOfFile, 'JFIF'));
    }

    /**
     * Test baggageList method
     *
     * @return void
     * @throws \Avolle\KnxProject\Exception\ArchiveFileNotFoundException
     */
    #[Test]
    public function baggageList(): void
    {
        $expected = [
            'M-0071',
            'M-0083',
        ];
        $testFile = TEST_FILES . 'projects' . DS . 'small-project.knxproj';
        $handler = new ProjectArchiveHandler();
        $archive = $handler->openFromFile($testFile);
        $baggageList = $archive->baggagesList();
        $this->assertEquals($expected, $baggageList);
    }

    /**
     * Test projectId method.
     *
     * @return void
     * @throws \Avolle\KnxProject\Exception\ArchiveFileNotFoundException
     */
    #[Test]
    public function projectId(): void
    {
        $testFile = TEST_FILES . 'projects' . DS . 'small-project.knxproj';
        $handler = new ProjectArchiveHandler();
        $archive = $handler->openFromFile($testFile);
        $this->assertEquals('P-0526', $archive->projectId());
    }

    /**
     * Test infoFile method.
     *
     * @return void
     * @throws \Avolle\KnxProject\Exception\ArchiveFileNotFoundException
     * @throws \Avolle\KnxProject\Exception\ProjectPasswordIncorrect
     */
    #[Test]
    public function infoFile(): void
    {
        $testFile = TEST_FILES . 'projects' . DS . 'small-project.knxproj';
        $handler = new ProjectArchiveHandler();
        $archive = $handler->openFromFile($testFile);
        $expected = [
            'projectName' => 'Small Project',
            'projectGuid' => 'e57acc40-503d-4c92-996e-aeaa4ad3a6b6',
            'isPasswordProtected' => false,
        ];
        $projectInfo = $archive->infoFile();
        $actual = $projectInfo->toArray();
        $this->assertEquals($expected, $actual);
    }

    /**
     * Test userFiles method.
     *
     * @return void
     * @throws \Avolle\KnxProject\Exception\ArchiveFileNotFoundException
     */
    #[Test]
    public function userFiles(): void
    {
        $testFile = TEST_FILES . 'projects' . DS . 'small-project.knxproj';
        $handler = new ProjectArchiveHandler();
        $archive = $handler->openFromFile($testFile);
        $expected = [
            'a-file.txt',
        ];
        $this->assertEquals($expected, $archive->userFiles());
    }

    /**
     * Test userFile method.
     *
     * @return void
     * @throws \Avolle\KnxProject\Exception\ArchiveFileNotFoundException
     * @throws \Avolle\KnxProject\Exception\ProjectPasswordIncorrect
     */
    #[Test]
    public function userFile(): void
    {
        $testFile = TEST_FILES . 'projects' . DS . 'small-project.knxproj';
        $handler = new ProjectArchiveHandler();
        $archive = $handler->openFromFile($testFile);
        $getFile = 'a-file.txt';
        $userFile = $archive->userFile($getFile);
        $this->assertIsString($userFile);
        $this->assertTrue($userFile === "This is a text file\n");
    }

    /**
     * Test projectInstallationFile method.
     *
     * @return void
     * @throws \Avolle\KnxProject\Exception\ArchiveFileNotFoundException
     * @throws \Avolle\KnxProject\Exception\ProjectPasswordIncorrect
     * @throws \Avolle\KnxProject\Exception\ProjectIsPasswordProtectedException
     */
    #[Test]
    public function projectInstallationFile(): void
    {
        $handler = new ProjectArchiveHandler();

        $testFile = TEST_FILES . 'projects' . DS . 'small-project.knxproj';
        $archive = $handler->openFromFile($testFile);
        $installationFile = $archive->projectInstallationFile();
        $this->assertEquals('ETS6', $installationFile->createdBy);
        $this->assertStringStartsWith('6.4.', $installationFile->toolVersion);
        $this->assertEquals(4294967295, $installationFile->project->installations[0]->bcuKey);
        $this->assertEquals('', $installationFile->project->installations[0]->bcuKeyAsHex());
        $device = $installationFile->project->installations[0]->topology->areas[1]->lines[1]->segments[0]->devices[0];
        $this->assertInstanceOf(DeviceInstance::class, $device);
        $this->assertEquals(0, $device->address);
        $this->assertEquals('IP-router', $device->description);
        $this->assertTrue($device->isActivityCalculated);
        $this->assertInstanceOf(DateTimeImmutable::class, $device->lastModified);
    }

    /**
     * Test projectInformationFile method.
     *
     * @return void
     * @throws \Avolle\KnxProject\Exception\ArchiveFileNotFoundException
     * @throws \Avolle\KnxProject\Exception\ProjectPasswordIncorrect
     * @throws \Avolle\KnxProject\Exception\ProjectIsPasswordProtectedException
     */
    #[Test]
    public function projectInformationFile(): void
    {
        $handler = new ProjectArchiveHandler();

        $testFile = TEST_FILES . 'projects' . DS . 'small-project.knxproj';
        $archive = $handler->openFromFile($testFile);
        $projectInformationFile = $archive->projectInformationFile();
        $this->assertEquals('ETS6', $projectInformationFile->createdBy);
        $this->assertStringStartsWith('6.4.', $projectInformationFile->toolVersion);
        $this->assertGreaterThanOrEqual(21, $projectInformationFile->project->projectInformation->projectTraces);
        $this->assertGreaterThanOrEqual(1, $projectInformationFile->project->userFiles);
    }

    /**
     * Test baggageCatalogFile method.
     *
     * @return void
     * @throws \Avolle\KnxProject\Exception\ArchiveFileNotFoundException
     * @throws \Avolle\KnxProject\Exception\ProjectPasswordIncorrect
     * @throws \Avolle\KnxProject\Exception\ProjectIsPasswordProtectedException
     */
    #[Test]
    public function baggageCatalogFile(): void
    {
        $handler = new ProjectArchiveHandler();

        $testFile = TEST_FILES . 'projects' . DS . 'small-project.knxproj';
        $archive = $handler->openFromFile($testFile);
        $baggageCatalogFile = $archive->baggageCatalogFile('M-0071');
        $this->assertEquals('ETS6', $baggageCatalogFile->createdBy);
        $this->assertEquals('M-0071', $baggageCatalogFile->manufacturerData->manufacturers[0]->refId);
        $item = $baggageCatalogFile->manufacturerData->manufacturers[0]->catalog->sections[0]->sections[0]->items[0];
        $this->assertEquals('M-0071_H-ZSYIPRCL-3-O0072_HP-6371-11-83E5-O0072_CI-ZSYIPRCL-1', $item->id);
        $this->assertEquals('IP Router CL', $item->name);
        $this->assertEquals('KNX-IP Router', $item->visibleDescription);
    }

    /**
     * Test baggageHardwareFile method.
     *
     * @return void
     * @throws \Avolle\KnxProject\Exception\ArchiveFileNotFoundException
     * @throws \Avolle\KnxProject\Exception\ProjectPasswordIncorrect
     * @throws \Avolle\KnxProject\Exception\ProjectIsPasswordProtectedException
     */
    #[Test]
    public function baggageHardwareFile(): void
    {
        $handler = new ProjectArchiveHandler();

        $testFile = TEST_FILES . 'projects' . DS . 'small-project.knxproj';
        $archive = $handler->openFromFile($testFile);
        $baggageHardwareFile = $archive->baggageHardwareFile('M-0071');
        $this->assertEquals('ETS6', $baggageHardwareFile->createdBy);
        $this->assertEquals(
            'M-0071_H-ZSYIPRCL-3-O0072',
            $baggageHardwareFile->manufacturerData->manufacturers[0]->hardware[0]->id,
        );
        $this->assertEquals(
            'IP Router CL',
            $baggageHardwareFile->manufacturerData->manufacturers[0]->hardware[0]->name,
        );
        $this->assertEquals(20, $baggageHardwareFile->manufacturerData->manufacturers[0]->hardware[0]->busCurrent);
        $this->assertCount(2, $baggageHardwareFile->manufacturerData->manufacturers[0]->hardware);
    }

    /**
     * Test baggageProgramFile method.
     *
     * @return void
     * @throws \Avolle\KnxProject\Exception\ArchiveFileNotFoundException
     * @throws \Avolle\KnxProject\Exception\ProjectPasswordIncorrect
     * @throws \Avolle\KnxProject\Exception\ProjectIsPasswordProtectedException
     */
    #[Test]
    public function baggageProgramFile(): void
    {
        $handler = new ProjectArchiveHandler();

        $testFile = TEST_FILES . 'projects' . DS . 'small-project.knxproj';
        $archive = $handler->openFromFile($testFile);
        $baggageProgramFile = $archive->baggageProgramFile('M-0071', 'M-0071_A-6371-11-83E5-O0072');
        $this->assertEquals('ETS6', $baggageProgramFile->createdBy);
        $this->assertEquals(
            'M-0071_A-6371-11-83E5-O0072',
            $baggageProgramFile->manufacturerData->manufacturers[0]->applicationPrograms[0]->id,
        );
        $this->assertEquals(
            'KNX-IP Router',
            $baggageProgramFile->manufacturerData->manufacturers[0]->applicationPrograms[0]->visibleDescription,
        );
        $this->assertEquals(
            'IP Router CL 1.1',
            $baggageProgramFile->manufacturerData->manufacturers[0]->applicationPrograms[0]->name,
        );
    }

    /**
     * Test masterFile method.
     *
     * @return void
     * @throws \Avolle\KnxProject\Exception\ArchiveFileNotFoundException
     * @throws \Avolle\KnxProject\Exception\ProjectPasswordIncorrect
     */
    #[Test]
    public function masterFile(): void
    {
        $handler = new ProjectArchiveHandler();

        $testFile = TEST_FILES . 'projects' . DS . 'small-project.knxproj';
        $archive = $handler->openFromFile($testFile);
        $masterFile = $archive->masterFile();
        $this->assertEquals('MD-1', $masterFile->masterData->id);
        $this->assertEquals(293, $masterFile->masterData->version);
    }

    /**
     * Test isPasswordProtected method.
     *
     * @return void
     * @throws \Avolle\KnxProject\Exception\ArchiveFileNotFoundException
     */
    #[Test]
    public function isPasswordProtected(): void
    {
        $handler = new ProjectArchiveHandler();

        // Not protected
        $testFileNotProtected = TEST_FILES . 'projects' . DS . 'small-project.knxproj';
        $notProtectedArchive = $handler->openFromFile($testFileNotProtected);
        $this->assertFalse($notProtectedArchive->isPasswordProtected());

        // Protected
        $testFileProtected = TEST_FILES . 'projects' . DS . 'password-protected.knxproj';
        $protectedArchive = $handler->openFromFile($testFileProtected);
        $this->assertTrue($protectedArchive->isPasswordProtected());
    }
}
