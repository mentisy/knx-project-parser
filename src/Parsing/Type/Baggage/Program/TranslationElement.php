<?php
declare(strict_types=1);

namespace Avolle\KnxProject\Parsing\Type\Baggage\Program;

use EventSauce\ObjectHydrator\MapFrom;

class TranslationElement
{
    /**
     * @param string|null $refId
     * @param \Avolle\KnxProject\Parsing\Type\Baggage\Program\TranslationElementString $translation
     */
    public function __construct(
        #[MapFrom('@RefId')]
        public ?string $refId,

        #[MapFrom('Translation')]
        public TranslationElementString $translation,
    ) {
    }
}
