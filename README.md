# KNX Project File Extractor

This library allows you to extract and use the files/information inside KNX project files (.knxproj), that ETS generates, easily.
Files are parsed from native XML files into code-complete-friendly object classes that you can use for whatever your
heart desires.

This project is a work-in-progress, and lacks complete parsing.

## Files inside the project file, and whether they will be password-protected if a password was defined on export

| Type                      | Pattern                                         | Description                                                                                                   | Password-protected? |
|---------------------------|-------------------------------------------------|---------------------------------------------------------------------------------------------------------------|---------------------|
| ProjectInstallation       | `{projectId}`/0.xml                             | Contains installation-related info. I.e.: Topology, Building Structure, Group Addresses                       | Yes                 |
| ProjectInformation        | `{projectId}`/project.xml                       | Contains metadata-related info. I.e.: Todo Items, Project History Log, Project Trace Log, Device Certificates | Yes                 |
| ProjectImage              | `{projectId}`/project.jpg                       | Contains the user-selected project image                                                                      | Yes                 |
| UserFile                  | `{projectId}`/UserFiles/`{userFile}`            | Files that users have added to the project file                                                               | Yes                 |
| BinaryData                | `{projectId}`/BinaryData/`{binaryFile}`         | Files that haven't been checked what is (probably something plug-ins create)                                  | Yes                 |
| ProjectInfo               | `{projectId}`.info                              | Contains identifying information about the project (Guid, Name, whether it is Password-Protected)             | No                  |
| ProjectSignature          | `{projectId}`.signature                         | Contains the signature hash created by ETS                                                                    | No                  |
| BaggageCatalog            | `{manufacturerId}`/Catalog.xml                  | Contains the device catalog information for the given manufacturer                                            | No                  |
| BaggageHardware           | `{manufacturerId}`/Hardware.xml                 | Contains the device hardware information for the given manufacturer                                           | No                  |
| BaggageApplicationProgram | `{manufacturerId}`/`{applicationProgramId}`.xml | Contains a version of the application program information for the given device                                | No                  |

## Installation
`composer require avolle/knx-project-parser`

## Usage

### Open a project file
Use the `ProjectArchiveHandler` to open a KNX project file. It will return a `ProjectArchive` class that can
be used to open any files inside the archive.
```php
$pathToProjectFile = '/Some-Site.knxproj';
$handler = new \Avolle\KnxExtractor\ProjectArchive\ProjectArchiveHandler();
$archive = $handler->openFromFile($pathToProjectFile);
// Get the project installation file
$installation = $archive->projectInstallationFile();
// Get the project information file
$information = $archive->projectInstallationFile();
```

### Password-protected files
If you need to open a password-protected project file, you can enter a password after getting the
`ProjectArchive` instance from the `ProjectArchiveHandler`. It is only necessary to set a password
if you are trying to access any password-protected files (see table above).

### Example usage
```php
$pathToProjectFile = '/Some-Site.knxproj';
$handler = new \Avolle\KnxExtractor\ProjectArchive\ProjectArchiveHandler();
$archive = $handler->openFromFile($pathToProjectFile);
$archive->setPassword('your-password'); // The password provided will be hashed matching the method ETS uses internally.
// Open any files inside the archive
$installation = $archive->projectInstallationFile();

```
**Open the Project Installation file (contains information like topology, building structure, group addresses).**
```php
// Output full ETS version project file was created in
var_dump($installation->createdBy);
// Output short ETS version project file was created in
var_dump($installation->toolVersion)
// Output topology
var_dump($installation->project->installations[0]->topology);
// Output building structure
var_dump($installation->project->installations[0]->locations);
// Output group addresses
var_dump($installation->project->installations[0]->groupAddresses);
```


**Open the Project Information file (contains information like to-do items, project log, device certificates).**
```php
$pathToProjectFile = '/Some-Site.knxproj';
$handler = new \Avolle\KnxExtractor\ProjectArchive\ProjectArchiveHandler();
$archive = $handler->openFromFile($pathToProjectFile);
$information = $archive->projectInformationFile();

// Output full ETS version project file was created in
var_dump($information->createdBy);
// Output short ETS version project file was created in
var_dump($information->toolVersion)
// Output to-do items
var_dump($information->project->projectInformation->toDoItems);
// Output project log (user-made)
var_dump($information->project->projectInformation->historyEntries);
// Output project trace (automatically-made)
var_dump($information->project->projectInformation->projectTraces);
// Output device certificates
var_dump($information->project->projectInformation->deviceCertificates);
```
