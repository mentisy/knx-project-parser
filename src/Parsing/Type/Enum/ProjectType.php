<?php
declare(strict_types=1);

namespace Avolle\KnxProject\Parsing\Type\Enum;

/**
 * @internal
 */
enum ProjectType: string implements EnumInterface
{
    use EnumTrait;

    case Apartment = 'Apartment';
    case FamilyHouse = 'Family House';
    case Villa = 'Villa';
    case OtherResidential = 'Other (Residential)';
    case Hotel = 'Hotel';
    case Airport = 'Airport';
    case OfficeBuilding = 'Office Building';
    case Educational = 'Educational';
    case Leisure = 'Leisure';
    case Entertainment = 'Entertainment';
    case PublicBuilding = 'Public Building';
    case HealthCare = 'Health Care';
    case OtherCommercial = 'Other (Commercial)';
    case Manufacturer = 'Manufacturer';
    case CityProject = 'City Project';
    case Transportation = 'Transportation';
    case OtherOther = 'Other (Other)';

    /**
     * @inheritDoc
     */
    public function label(): string
    {
        return $this->value;
    }
}
