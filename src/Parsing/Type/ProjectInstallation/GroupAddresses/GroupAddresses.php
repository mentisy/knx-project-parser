<?php
declare(strict_types=1);

namespace Avolle\KnxProject\Parsing\Type\ProjectInstallation\GroupAddresses;

use Avolle\KnxProject\Parsing\Caster\CastToGroupAddressStructure;
use Avolle\KnxProject\Parsing\Type\ProjectInstallation\GroupAddresses\Custom\MainAddress;
use EventSauce\ObjectHydrator\MapFrom;

/**
 * @internal
 */
class GroupAddresses
{
    /**
     * @var array<\Avolle\KnxProject\Parsing\Type\ProjectInstallation\GroupAddresses\Custom\SubAddress>|null
     */
    protected ?array $allSubAddresses = null;

    /**
     * @param array<\Avolle\KnxProject\Parsing\Type\ProjectInstallation\GroupAddresses\Custom\MainAddress>|null $mainAddresses
     */
    public function __construct(
        #[MapFrom('GroupRanges')]
        #[CastToGroupAddressStructure(MainAddress::class)]
        public ?array $mainAddresses = [],
    ) {
    }

    /**
     * @return array<\Avolle\KnxProject\Parsing\Type\ProjectInstallation\GroupAddresses\Custom\SubAddress>
     */
    public function allSubAddresses(): array
    {
        return $this->allSubAddresses ?? $this->getAllSubAddresses();
    }

    /**
     * @return array<\Avolle\KnxProject\Parsing\Type\ProjectInstallation\GroupAddresses\Custom\SubAddress>
     */
    protected function getAllSubAddresses(): array
    {
        $addresses = [];
        foreach ($this->mainAddresses as $mainAddress) {
            foreach ($mainAddress->middleAddresses as $middleAddress) {
                foreach ($middleAddress->subAddresses as $subAddress) {
                    $addresses[] = $subAddress;
                }
            }
        }

        return $addresses;
    }
}
