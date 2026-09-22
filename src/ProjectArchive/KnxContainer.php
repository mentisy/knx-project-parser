<?php
declare(strict_types=1);

namespace Avolle\KnxProject\ProjectArchive;

use Avolle\KnxProject\Parsing\Type\ProjectInformation\Knx as KnxInformation;
use Avolle\KnxProject\Parsing\Type\ProjectInstallation\Knx as KnxInstallation;

/**
 * Statically contain the project files parsed. This enables access throughout the lifetime of the process.
 */
class KnxContainer
{
    /**
     * KNX project information file.
     *
     * @var \Avolle\KnxProject\Parsing\Type\ProjectInformation\Knx|null
     */
    public static ?KnxInformation $knxInformation;

    /**
     * KNX project installation file.
     *
     * @var \Avolle\KnxProject\Parsing\Type\ProjectInstallation\Knx|null
     */
    public static ?KnxInstallation $knxInstallation;

    /**
     * Set KNX project information file.
     *
     * @param \Avolle\KnxProject\Parsing\Type\ProjectInformation\Knx $knxInformation Data object for KNX information file.
     * @return void
     */
    public static function setKnxInformation(KnxInformation $knxInformation): void
    {
        static::$knxInformation = $knxInformation;
    }

    /**
     * Get KNX project information file.
     *
     * @return \Avolle\KnxProject\Parsing\Type\ProjectInformation\Knx|null
     */
    public static function getKnxInformation(): ?KnxInformation
    {
        return static::$knxInformation ?? null;
    }

    /**
     * Set KNX project installation file.
     *
     * @param \Avolle\KnxProject\Parsing\Type\ProjectInstallation\Knx $knxInstallation Data object for KNX installation file.
     * @return void
     */
    public static function setKnxInstallation(KnxInstallation $knxInstallation): void
    {
        static::$knxInstallation = $knxInstallation;
    }

    /**
     * Get KNX project installation file.
     *
     * @return \Avolle\KnxProject\Parsing\Type\ProjectInstallation\Knx|null
     */
    public static function getKnxInstallation(): ?KnxInstallation
    {
        return static::$knxInstallation ?? null;
    }
}
