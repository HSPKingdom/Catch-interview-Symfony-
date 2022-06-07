<?php

namespace App\Service\Serializer;

use Symfony\Component\PropertyInfo\Extractor\PhpDocExtractor;
use Symfony\Component\PropertyInfo\Extractor\ReflectionExtractor;
use Symfony\Component\PropertyInfo\PropertyInfoExtractor;
use Symfony\Component\Serializer\Encoder\CsvEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\YamlEncoder;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

class DTOSerializer implements SerializerInterface
{
    private $serializer;

    public function __construct(){

        // Configure Encoder
        $encoders = [new JsonEncoder(), new CSVEncoder(), new XmlEncoder(), new YAMLEncoder()];

        // Configure Extractor info in Normalizer
        $extractor = new PropertyInfoExtractor([], [
            new PhpDocExtractor(),
            new ReflectionExtractor(),
        ]);

        // Configure Normalizer
        $normalizers = [
            new ObjectNormalizer(null, null, null, $extractor),
            new ArrayDenormalizer(),
            new DateTimeNormalizer()
        ];

        // Initialize Serializer
        $this->serializer = new Serializer($normalizers, $encoders);
    }

    /**
     * @param $data
     * @param string $format
     * @param array $context
     * @return string
     */
    public function serialize($data, string $format, array $context = []): string
    {
        return $this->serializer->serialize($data, $format, $context);
    }

    /**
     * @param $data
     * @param string $type
     * @param string $format
     * @param array $context
     * @return array | mixed
     */
    public function deserialize($data, string $type, string $format, array $context = []) : mixed
    {
        return $this->serializer->deserialize($data, $type, $format, $context);
    }
}