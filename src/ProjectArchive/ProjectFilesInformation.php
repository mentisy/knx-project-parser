<?php
declare(strict_types=1);

namespace Avolle\KnxProject\ProjectArchive;

/**
 * This is a utility-class for folder/file paths inside the KNX project file.
 *
 * Returns different strings based on whether the project file is password-protected or not. This is because
 * a password-protected project file has all project-related information locked behind an internal Zip archive
 * that is password-protected. One must then open that Zip archive to read files, and those files
 * are in the root directory.
 *
 * Not password-protected: Project-related files are kept inside the P-XXXX folder.
 *
 * Password-protected: Project-related files are kept inside the root folder of a P-XXXX zip archive.
 */
class ProjectFilesInformation
{
    /**
     * Base filename of the inner password-protected project file.
     */
    protected const string ProjectFilePasswordProtected = '%s.zip';

    /**
     * Filename of project installation file.
     */
    protected const string ProjectInstallationFile = '0.xml';

    /**
     * Filename of project information file.
     */
    protected const string ProjectInformationFile = 'project.xml';

    /**
     * Filename or project image file.
     */
    protected const string ProjectImageFile = 'project.jpg';

    /**
     * Regex for all files inside the user files folder.
     */
    protected const string UserFilesFolderPathRegex = 'UserFiles\/(.+)';

    /**
     * Base path to a specific user file.
     */
    protected const string UserFilePath = 'UserFiles/%s';

    /**
     * Base path to a specific binary data file.
     */
    protected const string BinaryDataPath = 'BinaryData/%s';

    /**
     * Base filename of project metadata info file.
     */
    protected const string ProjectInfoFile = '%s.info';

    /**
     * Regex for project metadata info file.
     */
    protected const string ProjectInfoFileRegex = '/P-[0-9A-Z]+\.info/i';

    /**
     * Base path to a baggage folder.
     */
    protected const string BaggageFolderPath = '%s/';

    /**
     * Base path to a baggage catalog file.
     */
    protected const string BaggageCatalogFile = self::BaggageFolderPath . 'Catalog.xml';

    /**
     * Base path to a baggage hardware file.
     */
    protected const string BaggageHardwareFile = self::BaggageFolderPath . 'Hardware.xml';

    /**
     * Base path to a baggage application program file.
     */
    protected const string BaggageProgramFile = self::BaggageFolderPath . '%s.xml';

    /**
     * Base path to a baggage signature file.
     */
    protected const string BaggageSignatureFile = '%s.signature';

    /**
     * Base path to the master file.
     */
    protected const string MasterFile = 'knx_master.xml';

    /**
     * Return the formatted path to the inner password-protected project file.
     *
     * @param string $projectId Project id.
     * @return string Formatted path to the inner password-protected project file.
     */
    public static function projectFilePasswordProtected(string $projectId): string
    {
        return sprintf(static::ProjectFilePasswordProtected, $projectId);
    }

    /**
     * Return formatted path to the project information file.
     *
     * If opening a password-protected program file, the `projectId` root folder is omitted in the path.
     *
     * @param string $projectId Project id.
     * @param bool $passwordProtected Whether project file is password-protected.
     * @return string Formatted path to the project information file.
     */
    public static function projectInformationFile(string $projectId, bool $passwordProtected = false): string
    {
        if ($passwordProtected) {
            return static::ProjectInformationFile;
        } else {
            return "$projectId/" . static::ProjectInformationFile;
        }
    }

    /**
     * Return formatted path to the project installation file.
     *
     * If opening a password-protected program file, the `projectId` root folder is omitted in the path.
     *
     * @param string $projectId Project id.
     * @param bool $passwordProtected Whether project file is password-protected.
     * @return string Path to the project installation file.
     */
    public static function projectInstallationFile(string $projectId, bool $passwordProtected = false): string
    {
        if ($passwordProtected) {
            return static::ProjectInstallationFile;
        } else {
            return "$projectId/" . static::ProjectInstallationFile;
        }
    }

    /**
     * Return the formatted path to the project image file.
     *
     * If opening a password-protected program file, the `projectId` root folder is omitted in the path.
     *
     * @param string $projectId Project id.
     * @param bool $passwordProtected Whether project file is password-protected.
     * @return string Formatted path to the project image file.
     */
    public static function projectImageFile(string $projectId, bool $passwordProtected = false): string
    {
        if ($passwordProtected) {
            return static::ProjectImageFile;
        } else {
            return "$projectId/" . static::ProjectImageFile;
        }
    }

    /**
     * Return a regular expression that encompasses the path to every user file.
     *
     * If opening a password-protected program file, the `projectId` root folder is omitted in the path.
     *
     * @param string $projectId Project id.
     * @param bool $passwordProtected Whether project file is password-protected.
     * @return string Regular expression for every file in the user files folder.
     */
    public static function userFilesFolderRegex(string $projectId, bool $passwordProtected = false): string
    {
        if ($passwordProtected) {
            return "/" . static::UserFilesFolderPathRegex . "/";
        } else {
            return "/" . preg_quote($projectId) . "\/" . static::UserFilesFolderPathRegex . "/";
        }
    }

    /**
     * Return formatted path to a user file.
     *
     * If opening a password-protected program file, the `projectId` root folder is omitted in the path.
     *
     * @param string $projectId Project id.
     * @param string $filename Filename of user file.
     * @param bool $passwordProtected Whether project file is password-protected.
     * @return string Formatted path to a user file.
     */
    public static function userFile(string $projectId, string $filename, bool $passwordProtected = false): string
    {
        if ($passwordProtected) {
            return sprintf(static::UserFilePath, $filename);
        } else {
            return "$projectId/" . sprintf(static::UserFilePath, $filename);
        }
    }

    /**
     * Return formatted path to a binary data file.
     *
     * If opening a password-protected program file, the `projectId` root folder is omitted in the path.
     *
     * @param string $projectId Project id.
     * @param string $filename Filename of binary data.
     * @param bool $passwordProtected Whether project file is password-protected.
     * @return string Formatted path to a binary data file.
     */
    public static function binaryData(string $projectId, string $filename, bool $passwordProtected = false): string
    {
        if ($passwordProtected) {
            return sprintf(static::BinaryDataPath, $filename);
        } else {
            return "$projectId/" . sprintf(static::BinaryDataPath, $filename);
        }
    }

    /**
     * Return the project info file, named as the project id and a .info extension (i.e.: P-061C.info)
     *
     * If no project ID is given, it will return the correct regex pattern to search for it. If project id is given,
     * it will try to open it based on the id.
     *
     * @param string|null $projectId Provide project id if known. Otherwise, returns regex pattern.
     * @return string Filename for project info file, or pattern if no `$projectId` is given.
     */
    public static function projectInfoFile(?string $projectId = null): string
    {
        if (!empty($projectId)) {
            return sprintf(static::ProjectInfoFile, $projectId);
        } else {
            return static::ProjectInfoFileRegex;
        }
    }

    /**
     * Return formatted path to a baggage signature file.
     *
     * @param string $manufacturerId Manufacturer id (2 byte hex value)
     * @return string Path to a baggage signature file.
     */
    public static function baggageSignatureFile(string $manufacturerId): string
    {
        return sprintf(static::BaggageSignatureFile, $manufacturerId);
    }

    /**
     * Return formatted path to a baggage catalog file.
     *
     * @param string $manufacturerId Manufacturer id (2 byte hex value).
     * @return string Path to a baggage catalog file.
     */
    public static function baggageCatalogFile(string $manufacturerId): string
    {
        return sprintf(static::BaggageCatalogFile, $manufacturerId);
    }

    /**
     * Return formatted path to a baggage hardware file.
     *
     * @param string $manufacturerId Manufacturer id (2 byte hex value).
     * @return string Path to a baggage hardware file.
     */
    public static function baggageHardwareFile(string $manufacturerId): string
    {
        return sprintf(static::BaggageHardwareFile, $manufacturerId);
    }

    /**
     * Return formatted path to a baggage application program file.
     *
     * @param string $manufacturerId Manufacturer id (2 byte hex value).
     * @param string $productId Product id.
     * @return string Path to a baggage application program file.
     */
    public static function baggageProgramFile(string $manufacturerId, string $productId): string
    {
        return sprintf(static::BaggageProgramFile, $manufacturerId, $productId);
    }

    /**
     * Return path to the KNX master file.
     *
     * @return string Path to the KNX master file.
     */
    public static function masterFile(): string
    {
        return static::MasterFile;
    }
}
