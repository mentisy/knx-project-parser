<?php
declare(strict_types=1);

namespace Avolle\KnxProject\Parsing\Type\Baggage\Program;

use Avolle\KnxProject\Exception\ValueExtractionException;
use Avolle\KnxProject\Parsing\Caster\CastToArrayValues;
use Avolle\KnxProject\Parsing\Caster\CastToListArray;
use EventSauce\ObjectHydrator\MapFrom;
use EventSauce\ObjectHydrator\PropertyCasters\CastListToType;

class ApplicationProgramDynamic
{
    /**
     * @param \Avolle\KnxProject\Parsing\Type\Baggage\Program\ChannelIndependantBlock|null $channelIndependantBlock
     * @param array<\Avolle\KnxProject\Parsing\Type\Baggage\Program\Channel> $channels
     * @param array<\Avolle\KnxProject\Parsing\Type\Baggage\Program\Choose> $chooses
     */
    public function __construct(
        #[MapFrom('ChannelIndependentBlock')]
        public ?ChannelIndependantBlock $channelIndependantBlock,

        #[MapFrom('Channel')]
        #[CastToListArray]
        #[CastToArrayValues]
        #[CastListToType(Channel::class)]
        public array $channels = [],

        #[MapFrom('choose')] // Lower-case choose is intentional, since XML is lower-case.
        #[CastToListArray]
        #[CastToArrayValues]
        #[CastListToType(Choose::class)]
        public array $chooses = [],
    ) {
    }

    /**
     * @param string $refId
     * @param bool|null $throw
     * @return \Avolle\KnxProject\Parsing\Type\Baggage\Program\ParameterBlock|null
     * @throws \Avolle\KnxProject\Exception\ValueExtractionException
     */
    public function findBlockByParameterRefRef(string $refId, ?bool $throw = true): ?ParameterBlock
    {
        if (!empty($this->channelIndependantBlock)) {
            foreach ($this->channelIndependantBlock->parameterBlocks as $parameterBlock) {
                $block = $this->findParameterBlock($refId, $parameterBlock);
                if ($block !== null) {
                    return $block;
                }
            }
            foreach ($this->channelIndependantBlock->chooses as $choose) {
                $block = $this->scanChooses($refId, $choose);
                if ($block !== null) {
                    return $block;
                }
            }
        }
        if (!empty($this->channels)) {
            foreach ($this->channels as $channel) {
                foreach ($channel->parameterBlocks as $parameterBlock) {
                    $block = $this->findParameterBlock($refId, $parameterBlock);
                    if ($block !== null) {
                        return $block;
                    }
                }
                foreach ($channel->chooses as $choose) {
                    $block = $this->scanChooses($refId, $choose);
                    if ($block !== null) {
                        return $block;
                    }
                }
            }
        }
        if (!empty($this->chooses)) {
            foreach ($this->chooses as $choose) {
                $block = $this->scanChooses($refId, $choose);
                if ($block !== null) {
                    return $block;
                }
            }
        }
        if ($throw) {
            throw new ValueExtractionException(
                sprintf('Could not extract `%s` based on %s`: %s`', 'parameterBlock', 'parameterRefId', $refId),
            );
        }

        return null;
    }

    /**
     * @param string $refId
     * @param bool|null $throw
     * @return \Avolle\KnxProject\Parsing\Type\Baggage\Program\Channel|null
     * @throws \Avolle\KnxProject\Exception\ValueExtractionException
     */
    public function findChannelByParameterRefRef(string $refId, ?bool $throw = true): ?Channel
    {
        if (!empty($this->channels)) {
            foreach ($this->channels as $channel) {
                foreach ($channel->parameterBlocks as $parameterBlock) {
                    $block = $this->findParameterBlock($refId, $parameterBlock);
                    if ($block !== null) {
                        return $channel;
                    }
                }
                foreach ($channel->chooses as $choose) {
                    $block = $this->scanChooses($refId, $choose);
                    if ($block !== null) {
                        return $channel;
                    }
                }
            }
        }
        if (!empty($this->chooses)) {
            foreach ($this->chooses as $choose) {
                foreach ($choose->whens as $when) {
                    if (!empty($when->channels)) {
                        foreach ($when->channels as $channel) {
                            foreach ($channel->parameterBlocks as $parameterBlock) {
                                $block = $this->findParameterBlock($refId, $parameterBlock);
                                if ($block !== null) {
                                    return $channel;
                                }
                            }
                            foreach ($channel->chooses as $choose) {
                                $block = $this->scanChooses($refId, $choose);
                                if ($block !== null) {
                                    return $channel;
                                }
                            }
                        }
                    }
                }
            }
        }
        if ($throw) {
            throw new ValueExtractionException(
                sprintf('Could not extract `%s` based on %s`: %s`', 'parameterBlock', 'parameterRefId', $refId),
            );
        }

        return null;
    }

    protected function scanChooses(
        string $refId,
        ?Choose $choose = null,
        ?ParameterBlock $parentParameterBlock = null,
    ): ?ParameterBlock {
        if ($choose->paramRefId === $refId) {
            return $parentParameterBlock;
        }
        foreach ($choose->whens as $when) {
            foreach ($when->parameterRefRefs as $ref) {
                if ($ref->refId === $refId) {
                    return $parentParameterBlock;
                }
            }
            foreach ($when->chooses as $choose) {
                $block = $this->scanChooses($refId, $choose, $parentParameterBlock);
                if ($block !== null) {
                    return $block;
                }
            }
            foreach ($when->parameterBlocks as $parameterBlock) {
                $block = $this->findParameterBlock($refId, $parameterBlock);
                if ($block !== null) {
                    return $block;
                }
            }
            foreach ($when->channels as $channel) {
                foreach ($channel->parameterBlocks as $parameterBlock) {
                    $block = $this->findParameterBlock($refId, $parameterBlock);
                    if ($block !== null) {
                        return $block;
                    }
                }
            }
        }

        return null;
    }

    protected function findParameterBlock(string $refId, ParameterBlock $parameterBlock): ?ParameterBlock
    {
        // First try in basic paramRefRefs children
        foreach ($parameterBlock->parameterRefRefs as $ref) {
            if ($ref->refId === $refId) {
                return $parameterBlock;
            }
        }
        // Then try inside choose children
        foreach ($parameterBlock->chooses as $choose) {
            $block = $this->scanChooses($refId, $choose, $parameterBlock);
            if ($block !== null) {
                return $block;
            }
        }

        return null;
    }
}
