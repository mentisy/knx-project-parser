<?php
declare(strict_types=1);

namespace Avolle\KnxProject\Parsing\Type\Baggage\Program;

use EventSauce\ObjectHydrator\MapFrom;

class Language
{
    /**
     * @param string|null $identifier
     * @param \Avolle\KnxProject\Parsing\Type\Baggage\Program\TranslationUnit|null $translationUnit
     */
    public function __construct(
        #[MapFrom('@Identifier')]
        public ?string $identifier,

        #[MapFrom('TranslationUnit')]
        public ?TranslationUnit $translationUnit,
    ) {
    }
}
