<?php
declare(strict_types=1);

namespace Avolle\KnxProject\Parsing\Type\Enum;

/**
 * @internal
 */
enum SpaceType: string implements EnumInterface
{
    use EnumTrait;

    case Building = 'Building';
    case BuildingPart = 'Building Part';
    case Floor = 'Floor';
    case Room = 'Room';
    case RoomPart = 'Room Part';
    case DistributionBoard = 'Distribution Board';
    case Stairway = 'Stairway';
    case Corridor = 'Corridor';
    case Area = 'Area';
    case Ground = 'Ground';
    case Segment = 'Segment';

    /**
     * @inheritDoc
     */
    public function label(): string
    {
        return $this->value;
    }
}
