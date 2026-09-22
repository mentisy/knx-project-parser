<?php
declare(strict_types=1);

namespace Avolle\KnxProject\Parsing\Type\Baggage\Program;

use Avolle\KnxProject\Parsing\Caster\CastToListArray;
use Avolle\KnxProject\Service\DeviceInconsistencyFixer\ValueExtractionException;
use EventSauce\ObjectHydrator\MapFrom;
use EventSauce\ObjectHydrator\PropertyCasters\CastListToType;

/**
 * @internal
 */
class TypeRestriction
{
    /**
     * @param string|null $base
     * @param int|null $sizeInBit
     * @param array<\Avolle\KnxProject\Parsing\Type\Baggage\Program\TypeRestrictionEnumeration>|null $enumerations
     */
    public function __construct(
        #[MapFrom('@Base')]
        public ?string $base,

        #[MapFrom('@SizeInBit')]
        public ?int $sizeInBit,

        #[MapFrom('Enumeration')]
        #[CastToListArray]
        #[CastListToType(TypeRestrictionEnumeration::class)]
        public ?array $enumerations = [],
    ) {
    }

    /**
     * @param string|int|null $value
     * @param string|null $text
     * @param string|null $id
     * @param bool|null $throw
     * @return \Avolle\KnxProject\Parsing\Type\Baggage\Program\TypeRestrictionEnumeration|null
     * @throws \Avolle\KnxProject\Service\DeviceInconsistencyFixer\ValueExtractionException
     */
    public function findEnumeration(
        string|int|null $value = null,
        ?string $text = null,
        ?string $id = null,
        ?bool $throw = true,
    ): ?TypeRestrictionEnumeration {
        foreach ($this->enumerations as $enumeration) {
            if ($value !== null && $value === $enumeration->value) {
                return $enumeration;
            } elseif ($text !== null && $text === $enumeration->text) {
                return $enumeration;
            } elseif ($id !== null && $id === $enumeration->id) {
                return $enumeration;
            }
        }
        if ($throw) {
            $basedOn = $value ? 'value' : ($text ? 'text' : ($id ? 'id' : 'nothing'));
            throw new ValueExtractionException(
                sprintf('Could not extract `%s` based on %s`: %s`', 'enumeration', $basedOn, $value ?? $text ?? $id),
            );
        }

        return null;
    }
}
