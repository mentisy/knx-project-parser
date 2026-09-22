<?php
declare(strict_types=1);

namespace Avolle\KnxProject\Parsing\Type\Baggage\Program;

use Avolle\KnxProject\Parsing\Caster\CastToArrayValues;
use Avolle\KnxProject\Parsing\Caster\CastToListArray;
use EventSauce\ObjectHydrator\MapFrom;
use EventSauce\ObjectHydrator\PropertyCasters\CastListToType;

class TranslationUnit
{
    /**
     * @param string|null $refId
     * @param array<\Avolle\KnxProject\Parsing\Type\Baggage\Program\TranslationElement> $translationElements
     */
    public function __construct(
        #[MapFrom('@RefId')]
        public ?string $refId,

        #[MapFrom('TranslationElement')]
        #[CastToListArray]
        #[CastToArrayValues]
        #[CastListToType(TranslationElement::class)]
        public array $translationElements = [],
    ) {
    }

    public function findTranslationElement(?string $refId): ?TranslationElement
    {
        foreach ($this->translationElements as $translationElement) {
            if ($translationElement->refId === $refId) {
                return $translationElement;
            }
        }

        return null;
    }
}
