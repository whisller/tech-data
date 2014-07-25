<?php

namespace Whisller\TechData\Transformers;

use JMS\Serializer\SerializerInterface;
use Whisller\TechData\Exceptions\TechDataException;
use Whisller\TechData\ResponseModels\XGResponse;

class TransformerToObject
{
    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    public function transform($xml)
    {
        /** @var XGResponse $XGResponse */
        $XGResponse = $this->serializer->deserialize($xml, 'Whisller\TechData\ResponseModels\XGResponse', 'tech_data');

        if ($XGResponse->isFailure()) {
            throw new TechDataException(
                trim($XGResponse->getFailure()->getMessage()),
                $XGResponse->getFailure()->getCode()
            );
        }

        return $XGResponse;
    }
}
