<?php
declare(strict_types=1);

namespace Avolle\KnxProject\ProjectArchive;

use Avolle\KnxProject\Exception\ProjectIsPasswordProtectedException;
use Avolle\KnxProject\Parsing\Type\Archive\InfoFile;
use Avolle\KnxProject\Parsing\Type\Baggage\Catalog\Knx as KnxCatalog;
use Avolle\KnxProject\Parsing\Type\Baggage\Hardware\Knx as KnxHardware;
use Avolle\KnxProject\Parsing\Type\Baggage\Program\Knx as KnxBaggageProgram;
use Avolle\KnxProject\Parsing\Type\Master\Knx as KnxMaster;
use Avolle\KnxProject\Parsing\Type\ProjectInformation\Knx as KnxInformation;
use Avolle\KnxProject\Parsing\Type\ProjectInstallation\Knx as KnxInstallation;
use Avolle\KnxProject\Trait\ProjectPasswordTrait;
use ZipArchive;

/**
 * Project Archive
 *
 * Responsible for containing metadata
 */
class ProjectArchive
{
    use ProjectPasswordTrait;

    /**
     * Project archive ID.
     *
     * @var string
     */
    protected string $projectId;

    /**
     * Data objec deserializer.
     *
     * @var \Avolle\KnxProject\ProjectArchive\Deserializer
     */
    protected Deserializer $deserializer;

    /**
     * Class to locate files in project archive.
     *
     * @var \Avolle\KnxProject\ProjectArchive\FileLocator
     */
    protected FileLocator $locator;

    /**
     * Whether project archive is found to be password-protected.
     *
     * @var bool
     */
    protected bool $isPasswordProtected = false;

    /**
     * Password for project archive.
     *
     * @var string|null
     */
    protected ?string $password = null;

    /**
     * This is the password-protected Zip archive inside the .knxproj Zip archive file.
     *
     * @var \ZipArchive|null
     */
    protected ?ZipArchive $passwordProtectedArchive = null;

    /**
     * Constructor.
     *
     * @throws \Avolle\KnxProject\Exception\ArchiveFileNotFoundException
     */
    public function __construct(ZipArchive $zip)
    {
        $this->locator = new FileLocator($zip);
        $this->projectId = $this->extractProjectId();
        $this->deserializer = new Deserializer();
        if ($zip->getFromName(ProjectFilesInformation::projectFilePasswordProtected($this->projectId))) {
            $this->isPasswordProtected = true;
        }
    }

    /**
     * Deserialize and return the project installation file.
     *
     * The installation file contains information like:
     * * Project metadata
     * * Building structure
     * * Topology
     * * Group addresses
     *
     * @return \Avolle\KnxProject\Parsing\Type\ProjectInstallation\Knx
     * @throws \Avolle\KnxProject\Exception\ArchiveFileNotFoundException
     * @throws \Avolle\KnxProject\Exception\ProjectIsPasswordProtectedException
     * @throws \Avolle\KnxProject\Exception\ProjectPasswordIncorrect
     */
    public function projectInstallationFile(): KnxInstallation
    {
        if ($this->isPasswordProtected) {
            $protectedZip = $this->getPasswordProtectedArchive();
            $xmlContent = $this->locator->getFileContents(
                ProjectFilesInformation::projectInstallationFile($this->projectId, passwordProtected: true),
                $protectedZip,
            );
        } else {
            $xmlContent = $this->locator->getFileContents(ProjectFilesInformation::projectInstallationFile($this->projectId));
        }
        $knx = $this->deserializer->deserialize($xmlContent, KnxInstallation::class);
        KnxContainer::setKnxInstallation($knx);

        return $knx;
    }

    /**
     * Deserialize and return the project information file.
     *
     * The information file contains information like:
     * Project metadata
     * Project log
     * To-do items
     * User files
     * Device certificates
     *
     * @return \Avolle\KnxProject\Parsing\Type\ProjectInformation\Knx
     * @throws \Avolle\KnxProject\Exception\ArchiveFileNotFoundException
     * @throws \Avolle\KnxProject\Exception\ProjectIsPasswordProtectedException
     * @throws \Avolle\KnxProject\Exception\ProjectPasswordIncorrect
     */
    public function projectInformationFile(): KnxInformation
    {
        if ($this->isPasswordProtected) {
            $protectedZip = $this->getPasswordProtectedArchive();
            $xmlContent = $this->locator->getFileContents(
                ProjectFilesInformation::projectInformationFile($this->projectId, passwordProtected: true),
                $protectedZip,
            );
        } else {
            $xmlContent = $this->locator->getFileContents(
                ProjectFilesInformation::projectInformationFile($this->projectId),
            );
        }
        $knx = $this->deserializer->deserialize($xmlContent, KnxInformation::class);
        KnxContainer::setKnxInformation($knx);

        return $knx;
    }

    /**
     * Return project image as a binary string
     *
     * @throws \Avolle\KnxProject\Exception\ArchiveFileNotFoundException
     * @throws \Avolle\KnxProject\Exception\ProjectIsPasswordProtectedException
     * @throws \Avolle\KnxProject\Exception\ProjectPasswordIncorrect
     */
    public function projectImage(): string
    {
        if ($this->isPasswordProtected) {
            $protectedZip = $this->getPasswordProtectedArchive();

            return $this->locator->getFileContents(
                ProjectFilesInformation::projectImageFile($this->projectId()),
                $protectedZip,
            );
        }

        return $this->locator->getFileContents(ProjectFilesInformation::projectImageFile($this->projectId));
    }

    /**
     * Return the project info file, which contains basic project metadata.
     *
     * @return \Avolle\KnxProject\Parsing\Type\Archive\InfoFile
     * @throws \Avolle\KnxProject\Exception\ArchiveFileNotFoundException
     * @throws \Avolle\KnxProject\Exception\ProjectPasswordIncorrect
     */
    public function infoFile(): InfoFile
    {
        $infoFile = $this->locator->findFile(ProjectFilesInformation::projectInfoFile());
        $data = json_decode($this->locator->getFileContents($infoFile), true);

        return InfoFile::fromArray($data);
    }

    /**
     * Return a list of user files, based on files found in the UserFiles folder (not through the XML content).
     *
     * @return array<string>
     */
    public function userFiles(): array
    {
        $regex = ProjectFilesInformation::userFilesFolderRegex($this->projectId);

        return $this->locator->findFiles($regex);
    }

    /**
     * Return the contents of a specific user file.
     *
     * @param string $filename The user file name to return.
     * @return string
     * @throws \Avolle\KnxProject\Exception\ArchiveFileNotFoundException
     * @throws \Avolle\KnxProject\Exception\ProjectPasswordIncorrect
     */
    public function userFile(string $filename): string
    {
        return $this->locator->getFileContents(ProjectFilesInformation::userFile($this->projectId, $filename));
    }

    /**
     * Return a list of baggage file names.
     *
     * @return array<string>
     */
    public function baggagesList(): array
    {
        $regex = '/^(M-[0-9a-zA-Z]+)\/$/'; // M-0008/

        return $this->locator->findFiles($regex);
    }

    /**
     * Return a baggage catalog file for a specific manufacturer ID.
     *
     * @param string $manufacturerId Manufacturer ID.
     * @return \Avolle\KnxProject\Parsing\Type\Baggage\Catalog\Knx
     * @throws \Avolle\KnxProject\Exception\ArchiveFileNotFoundException
     * @throws \Avolle\KnxProject\Exception\ProjectPasswordIncorrect
     */
    public function baggageCatalogFile(string $manufacturerId): KnxCatalog
    {
        $xmlContent = $this->locator->getFileContents(ProjectFilesInformation::baggageCatalogFile($manufacturerId));

        return $this->deserializer->deserialize($xmlContent, KnxCatalog::class);
    }

    /**
     * Return a baggage hardware file for a specific manufacturer ID.
     *
     * @param string $manufacturerId Manufacturer ID.
     * @return \Avolle\KnxProject\Parsing\Type\Baggage\Hardware\Knx
     * @throws \Avolle\KnxProject\Exception\ArchiveFileNotFoundException
     * @throws \Avolle\KnxProject\Exception\ProjectPasswordIncorrect
     */
    public function baggageHardwareFile(string $manufacturerId): KnxHardware
    {
        $xmlContent = $this->locator->getFileContents(ProjectFilesInformation::baggageHardwareFile($manufacturerId));

        return $this->deserializer->deserialize($xmlContent, KnxHardware::class);
    }

    /**
     * Return a baggage application program file for a specific manufacturer ID and application program ID.
     *
     * @param string $manufacturerId Manufacturer ID.
     * @param string $programId Application program ID.
     * @return \Avolle\KnxProject\Parsing\Type\Baggage\Program\Knx
     * @throws \Avolle\KnxProject\Exception\ArchiveFileNotFoundException
     * @throws \Avolle\KnxProject\Exception\ProjectPasswordIncorrect
     */
    public function baggageProgramFile(string $manufacturerId, string $programId): KnxBaggageProgram
    {
        $xmlContent = $this->locator->getFileContents(ProjectFilesInformation::baggageProgramFile($manufacturerId, $programId));

        return $this->deserializer->deserialize($xmlContent, KnxBaggageProgram::class);
    }

    /**
     * Return the KNX master file.
     *
     * @return \Avolle\KnxProject\Parsing\Type\Master\Knx
     * @throws \Avolle\KnxProject\Exception\ArchiveFileNotFoundException
     * @throws \Avolle\KnxProject\Exception\ProjectPasswordIncorrect
     */
    public function masterFile(): KnxMaster
    {
        $xmlContent = $this->locator->getFileContents(ProjectFilesInformation::masterFile());

        return $this->deserializer->deserialize($xmlContent, KnxMaster::class);
    }

    /**
     * Whether the project file is password-protected or not. Determined when class is instantiated.
     *
     * @return bool True if password-protected. False, otherwise.
     */
    public function isPasswordProtected(): bool
    {
        return $this->isPasswordProtected;
    }

    /**
     * Set the password to use when attempting to open the project file.
     *
     * @param string|null $password Project password.
     * @return void
     */
    public function setPassword(?string $password): void
    {
        $this->password = $password;
    }

    /**
     * Return the project ID.
     *
     * @return string
     */
    public function projectId(): string
    {
        return $this->projectId;
    }

    /**
     * Extract project ID by using the filename of the root .signature file. This file exists in ETS 4, 5 and 6.
     *
     * The filename is "P-XYZ.signature", so we can extract the ID by removing ".signature"
     *
     * @throws \Avolle\KnxProject\Exception\ArchiveFileNotFoundException
     */
    protected function extractProjectId(): string
    {
        $signatureFile = $this->locator->findFile('/P-[0-9a-zA-Z]+\.signature/');

        return str_replace('.signature', '', $signatureFile);
    }

    /**
     * Get the password-protected archive inside the .knxproj archive. If this method has already been called, it will
     * return the stored archive from the first call.
     *
     * @return \ZipArchive
     * @throws \Avolle\KnxProject\Exception\ProjectIsPasswordProtectedException
     * @throws \Avolle\KnxProject\Exception\ArchiveFileNotFoundException
     * @throws \Avolle\KnxProject\Exception\ProjectPasswordIncorrect
     */
    protected function getPasswordProtectedArchive(): ZipArchive
    {
        if (isset($this->passwordProtectedArchive)) {
            return $this->passwordProtectedArchive;
        }
        if (empty($this->password)) {
            throw new ProjectIsPasswordProtectedException(
                'Password is required, since the project ia password-protected.',
            );
        }
        $tempArchivePath = tempnam(sys_get_temp_dir(), 'zip');
        file_put_contents($tempArchivePath, $this->locator->getFileContents(
            ProjectFilesInformation::projectFilePasswordProtected($this->projectId),
        ));
        $archive = new ZipArchive();
        $archive->open($tempArchivePath);
        $archive->setPassword($this->hashPassword($this->password));

        return $this->passwordProtectedArchive = $archive;
    }
}
