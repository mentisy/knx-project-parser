<?php
declare(strict_types=1);

namespace Avolle\KnxProject\Parsing\Caster;

use Attribute;
use EventSauce\ObjectHydrator\ObjectMapper;
use EventSauce\ObjectHydrator\PropertyCaster;
use InvalidArgumentException;

/**
 * Cast a value to use a key inside an array, instead of the actual array.
 *
 * @internal
 */
#[Attribute(Attribute::TARGET_PARAMETER)]
class CastExtractFromArrayKey implements PropertyCaster
{
    /**
     * Constructor.
     *
     * @param string $key Key inside array to extract.
     * @param bool $allowMissing If key does not exist, by default it throws exception. Set to `false` to return null instead.
     */
    public function __construct(protected string $key, protected bool $allowMissing = false)
    {
    }

    /**
     * Cast method. Extract value in the key property of array.
     *
     * @param mixed $value Value received
     * @param \EventSauce\ObjectHydrator\ObjectMapper $hydrator Hydrator mapper
     * @return mixed
     */
    public function cast(mixed $value, ObjectMapper $hydrator): mixed
    {
        if (!array_key_exists($this->key, $value)) {
            if ($this->allowMissing) {
                return [];
            }
            throw new InvalidArgumentException("Key `$this->key` does not exist in array.");
        }

        return $value[$this->key];
    }
}
