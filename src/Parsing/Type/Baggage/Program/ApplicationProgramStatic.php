<?php
declare(strict_types=1);

namespace Avolle\KnxProject\Parsing\Type\Baggage\Program;

use Avolle\KnxProject\Parsing\Caster\CastExtractFromArrayKey;
use Avolle\KnxProject\Parsing\Caster\CastToArrayValues;
use Avolle\KnxProject\Parsing\Caster\CastToListArray;
use Avolle\KnxProject\Service\DeviceInconsistencyFixer\ValueExtractionException;
use EventSauce\ObjectHydrator\MapFrom;
use EventSauce\ObjectHydrator\PropertyCasters\CastListToType;

class ApplicationProgramStatic
{
    /**
     * @param \Avolle\KnxProject\Parsing\Type\Baggage\Program\Parameters|null $parameters
     * @param array<\Avolle\KnxProject\Parsing\Type\Baggage\Program\AbsoluteSegment>|null $absoluteSegments
     * @param array<\Avolle\KnxProject\Parsing\Type\Baggage\Program\RelativeSegment>|null $relativeSegments
     * @param array<\Avolle\KnxProject\Parsing\Type\Baggage\Program\ParameterType>|null $parameterTypes
     * @param array<\Avolle\KnxProject\Parsing\Type\Baggage\Program\ParameterRef>|null $parameterRefs
     */
    public function __construct(
        #[MapFrom('Parameters')]
        public ?Parameters $parameters,

        #[MapFrom('Code')]
        #[CastExtractFromArrayKey('AbsoluteSegment', true)]
        #[CastToListArray]
        #[CastListToType(AbsoluteSegment::class)]
        public ?array $absoluteSegments = [],

        #[MapFrom('Code')]
        #[CastExtractFromArrayKey('RelativeSegment', true)]
        #[CastToListArray]
        #[CastListToType(RelativeSegment::class)]
        public ?array $relativeSegments = [],

        #[MapFrom('ParameterTypes')]
        #[CastExtractFromArrayKey('ParameterType')]
        #[CastToListArray]
        #[CastToArrayValues]
        #[CastListToType(ParameterType::class)]
        public ?array $parameterTypes = [],

        #[MapFrom('ParameterRefs')]
        #[CastExtractFromArrayKey('ParameterRef')]
        #[CastToListArray]
        #[CastToArrayValues]
        #[CastListToType(ParameterRef::class)]
        public ?array $parameterRefs = [],
    ) {
    }

    /**
     * @param float|int|null $memoryOffset
     * @param bool|null $reattempt
     * @param bool|null $throw
     * @return \Avolle\KnxProject\Parsing\Type\Baggage\Program\Parameter|\Avolle\KnxProject\Parsing\Type\Baggage\Program\Union|null
     * @throws \Avolle\KnxProject\Service\DeviceInconsistencyFixer\ValueExtractionException
     */
    public function findParameter(
        float|int|null $memoryOffset = null,
        ?bool $reattempt = true,
        ?bool $throw = true,
    ): Parameter|Union|null {
        if ($memoryOffset !== null) {
            // Find the AbsoluteSegment or RelativeSegment that matches the memory offset from ETS
            $memoryBlock = $this->findSegmentBock($memoryOffset);
            // Subtract the address start address from the found segment, so that the relative memory offset matches the Memory Offset
            $relativeMemoryOffset = $memoryOffset - $memoryBlock->address;
            foreach ($this->parameters->parameters as $parameter) {
                if ($memoryBlock->id !== $parameter->memory?->codeSegment) {
                    continue;
                }
                if ($parameter->memory?->offset === $relativeMemoryOffset) {
                    return $parameter;
                }
            }
            foreach ($this->parameters->unions as $union) {
                if ($memoryBlock->id !== $union->memory?->codeSegment) {
                    continue;
                }
                if ($union->memory?->offset === $relativeMemoryOffset) {
                    return $union;
                }
            }
        }

        // We reattempt because apparently some memory offsets are 0-indexed, while others are 1-indexed.
        // The Device Compare ETS app gives the impression the offset is e.g. 19, while in the application program it is 18.
        // Some other applications gives the correct memory offset. So until we know why, or how this is determined by ETS in real life
        // we'll have this reattempt as a non-ideal fixer (sometimes). False positives are not unlikely to occur.
        if ($reattempt) {
            return $this->findParameter($memoryOffset - 1, reattempt: false);
        }

        if ($throw) {
            throw new ValueExtractionException(
                sprintf('Could not extract `%s` based on %s`: %s`', 'parameter', 'memoryOffset', $memoryOffset),
            );
        }

        return null;
    }

    /**
     * @param float|int|null $memoryOffset
     * @param bool|null $reattempt
     * @return array<\Avolle\KnxProject\Parsing\Type\Baggage\Program\Parameter|\Avolle\KnxProject\Parsing\Type\Baggage\Program\Union>
     * @throws \Avolle\KnxProject\Service\DeviceInconsistencyFixer\ValueExtractionException
     */
    public function findParameters(
        float|int|null $memoryOffset,
        ?bool $reattempt = true,
    ): array {
        // Parameters found array
        $parameters = [];
        // Find the AbsoluteSegment or RelativeSegment that matches the memory offset from ETS
        $memoryBlock = $this->findSegmentBock($memoryOffset);
        // Subtract the address start address from the found segment, so that the relative memory offset matches the Memory Offset
        $relativeMemoryOffset = $memoryOffset - ($memoryBlock->address ?? $memoryBlock->offset);
        foreach ($this->parameters->parameters as $parameter) {
            if ($memoryBlock->id !== $parameter->memory?->codeSegment) {
                continue;
            }
            if ($parameter->memory?->offset === $relativeMemoryOffset) {
                $parameters[] = $parameter;
            }
        }
        foreach ($this->parameters->unions as $union) {
            if ($memoryBlock->id !== $union->memory?->codeSegment) {
                continue;
            }
            if ($union->memory?->offset === $relativeMemoryOffset) {
                $parameters[] = $union;
            }
        }

        // We reattempt because apparently some memory offsets are 0-indexed, while others are 1-indexed.
        // The Device Compare ETS app gives the impression the offset is e.g. 19, while in the application program it is 18.
        // Some other applications gives the correct memory offset. So until we know why, or how this is determined by ETS in real life
        // we'll have this reattempt as a non-ideal fixer (sometimes). False positives are not unlikely to occur.
        if (empty($parameters) && $reattempt) {
            return $this->findParameters($memoryOffset - 1, reattempt: false);
        }

        return $parameters;
    }

    /**
     * @param string $parameterTypeId
     * @param bool|null $throw
     * @return \Avolle\KnxProject\Parsing\Type\Baggage\Program\ParameterType|null
     * @throws \Avolle\KnxProject\Service\DeviceInconsistencyFixer\ValueExtractionException
     */
    public function findParameterType(string $parameterTypeId, ?bool $throw = true): ?ParameterType
    {
        foreach ($this->parameterTypes as $type) {
            if ($type->id === $parameterTypeId) {
                return $type;
            }
        }
        if ($throw) {
            throw new ValueExtractionException(
                sprintf('Could not extract `%s` based on %s`: %s`', 'parameterType', 'parameterTypeId', $parameterTypeId),
            );
        }

        return null;
    }

    /**
     * @param string|null $parameterRefId
     * @param string|null $parameterRefRefId
     * @param bool|null $throw
     * @return \Avolle\KnxProject\Parsing\Type\Baggage\Program\ParameterRef|null
     * @throws \Avolle\KnxProject\Service\DeviceInconsistencyFixer\ValueExtractionException
     */
    public function findParameterRef(
        ?string $parameterRefId = null,
        ?string $parameterRefRefId = null,
        ?bool $throw = true,
    ): ?ParameterRef {
        foreach ($this->parameterRefs as $ref) {
            if ($parameterRefId !== null && $ref->id === $parameterRefId) {
                return $ref;
            }
            if ($parameterRefRefId !== null && $ref->refId === $parameterRefRefId) {
                return $ref;
            }
        }
        if ($throw) {
            $basedOn = $parameterRefId ? 'parameterRefId' : ($parameterRefRefId ? 'parameterRefRefId' : 'nothing');
            throw new ValueExtractionException(
                sprintf('Could not extract `%s` based on %s`: %s`', 'parameterRef', $basedOn, $parameterRefId ?? $parameterRefRefId),
            );
        }

        return null;
    }

    /**
     * @param float|int|null $memoryOffset
     * @param bool|null $throw
     * @return \Avolle\KnxProject\Parsing\Type\Baggage\Program\AbsoluteSegment|\Avolle\KnxProject\Parsing\Type\Baggage\Program\RelativeSegment|null
     * @throws \Avolle\KnxProject\Service\DeviceInconsistencyFixer\ValueExtractionException
     */
    protected function findSegmentBock(
        float|int|null $memoryOffset,
        ?bool $throw = true,
    ): AbsoluteSegment|RelativeSegment|null {
        foreach ($this->absoluteSegments as $absSegment) {
            if ($memoryOffset >= $absSegment->address && $memoryOffset <= $absSegment->address + $absSegment->size) {
                return $absSegment;
            }
        }
        foreach ($this->relativeSegments as $relSegment) {
            if ($memoryOffset >= $relSegment->offset && $memoryOffset <= $relSegment->offset + $relSegment->size) {
                return $relSegment;
            }
        }
        if ($throw) {
            throw new ValueExtractionException(
                sprintf('Could not extract `%s` based on %s`: %s`', 'memory segment', 'memoryOffset', $memoryOffset),
            );
        }

        return null;
    }
}
