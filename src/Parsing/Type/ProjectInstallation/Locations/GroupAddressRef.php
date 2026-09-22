<?php
declare(strict_types=1);

namespace Avolle\KnxProject\Parsing\Type\ProjectInstallation\Locations;

use Avolle\KnxProject\Parsing\Type\ProjectInstallation\GroupAddresses\Custom\SubAddress;
use Avolle\KnxProject\ProjectArchive\KnxContainer;
use EventSauce\ObjectHydrator\MapFrom;

/**
 * @internal
 */
class GroupAddressRef
{
    /**
     * @param string $id
     * @param string $refId
     * @param string $name
     * @param string|null $role
     * @param int $puId
     */
    public function __construct(
        #[MapFrom('@Id')]
        public string $id,

        #[MapFrom('@RefId')]
        public string $refId,

        #[MapFrom('@Name')]
        public string $name,

        #[MapFrom('@Role')]
        public ?string $role,

        #[MapFrom('@Puid')]
        public int $puId,
    ) {
    }

    /**
     * Get the specific group address by the ref id.
     *
     * If cache is used, it will first generate a list of all
     * group addresses in a flat structure, so that further lookups of group adresses by ref (not just this same ref)
     * will be quicker.
     *
     * If no cache is used, then it will return early when found, so one-time lookup is quicker than caching.
     *
     * @param bool|null $cache Whether to generate a list of all addresses first, so lookup is quicker next time.
     * @return \Avolle\KnxProject\Parsing\Type\ProjectInstallation\GroupAddresses\Custom\SubAddress|null
     */
    public function getAddressFromRef(?bool $cache = true): ?SubAddress
    {
        $knx = KnxContainer::getKnxInstallation();
        $mainAddresses = $knx->project->installations[0]->groupAddresses->mainAddresses;
        if ($cache) {
            $addresses = $knx->project->installations[0]->groupAddresses->allSubAddresses();
            foreach ($addresses as $address) {
                if ($address->id === $this->refId) {
                    return $address;
                }
            }
        } else {
            foreach ($mainAddresses as $mainAddress) {
                foreach ($mainAddress->middleAddresses as $middleAddress) {
                    foreach ($middleAddress->subAddresses as $subAddress) {
                        if ($subAddress->id === $this->refId) {
                            return $subAddress;
                        }
                    }
                }
            }
        }

        return null;
    }
}
