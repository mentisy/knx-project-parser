<?php
declare(strict_types=1);

namespace Avolle\KnxProject\Parsing\Type\Baggage\Program;

use Avolle\KnxProject\Parsing\Caster\CastToArrayValues;
use Avolle\KnxProject\Parsing\Caster\CastToListArray;
use Avolle\KnxProject\Service\DeviceInconsistencyFixer\ValueExtractionException;
use EventSauce\ObjectHydrator\MapFrom;
use EventSauce\ObjectHydrator\PropertyCasters\CastListToType;

class Manufacturer
{
    /**
     * @param string|null $refId
     * @param array<\Avolle\KnxProject\Parsing\Type\Baggage\Program\ApplicationProgram>|null $applicationPrograms
     * @param array<\Avolle\KnxProject\Parsing\Type\Baggage\Program\Language>|null $languages
     */
    public function __construct(
        #[MapFrom('@RefId')]
        public ?string $refId,

        #[MapFrom('ApplicationPrograms')]
        #[CastToArrayValues]
        #[CastToListArray]
        #[CastListToType(ApplicationProgram::class)]
        public ?array $applicationPrograms = [],

        #[MapFrom('Languages')]
        #[CastToArrayValues]
        #[CastToListArray]
        #[CastListToType(Language::class)]
        public ?array $languages = [],
    ) {
    }

    public function findApplicationProgram($programId, ?bool $throw = true): ?ApplicationProgram
    {
        foreach ($this->applicationPrograms as $applicationProgram) {
            if ($applicationProgram->id === $programId) {
                return $applicationProgram;
            }
        }
        if ($throw) {
            throw new ValueExtractionException(
                sprintf('Could not extract `%s` based on %s`: %s`', 'applicationProgram', 'programId', $programId),
            );
        }

        return null;
    }

    /**
     * @param int|string $languageIdentifier
     * @param bool|null $throw
     * @return \Avolle\KnxProject\Parsing\Type\Baggage\Program\Language|null
     * @throws \Avolle\KnxProject\Service\DeviceInconsistencyFixer\ValueExtractionException
     */
    public function findLanguage(int|string $languageIdentifier, ?bool $throw = true): ?Language
    {
        foreach ($this->languages as $language) {
            if ($language->identifier === $languageIdentifier) {
                return $language;
            }
        }
        if ($throw) {
            throw new ValueExtractionException(
                sprintf('Could not extract `%s` based on %s`: %s`', 'language', 'identifier', $languageIdentifier),
            );
        }

        return null;
    }
}
