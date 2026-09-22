<?php
declare(strict_types=1);

namespace Avolle\KnxProject\ProjectArchive;

use EventSauce\ObjectHydrator\ObjectMapperUsingReflection;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * Deserialize XML into a PHP data object
 *
 * @template T Object-class deserialized into
 * @internal
 */
class Deserializer
{
    /**
     * @var \Symfony\Component\Serializer\Serializer
     */
    protected Serializer $serializer;

    /**
     * @var \EventSauce\ObjectHydrator\ObjectMapperUsingReflection
     */
    protected ObjectMapperUsingReflection $mapper;

    /**
     * Constructor
     */
    public function __construct()
    {
        $encoders = [new XmlEncoder()];
        $normalizers = [new ObjectNormalizer()];

        $this->serializer = new Serializer($normalizers, $encoders);
        $this->mapper = new ObjectMapperUsingReflection();
    }

    /**
     * Deserialize XML string into a data object
     *
     * @param string $xmlContent XML content string
     * @param class-string<T> $objectClass Object-class to deserialize into
     * @return T Object-class deserialized into
     */
    public function deserialize(string $xmlContent, string $objectClass)
    {
        $data = $this->serializer->decode($xmlContent, 'xml');

        return $this->mapper->hydrateObject($objectClass, $data);
    }
}
