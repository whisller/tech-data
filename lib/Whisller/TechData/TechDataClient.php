<?php

namespace Whisller\TechData;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Message\Response;
use JMS\Serializer\SerializerInterface;
use Whisller\TechData\Components\BaseComponentInterface;
use Whisller\TechData\Exceptions\TechDataException;
use Whisller\TechData\ResponseModels\Response as ModelResponse;

class TechDataClient
{
    protected $httpClient;
    protected $serializer;
    protected $validator;
    protected $serverDomain;

    public function __construct(
        ClientInterface $client,
        SerializerInterface $serializer,
        TechDataValidator $validator,
        $serverDomain
    ) {
        $this->httpClient = $client;
        $this->serializer = $serializer;
        $this->validator = $validator;
        $this->serverDomain = $serverDomain;
    }

    public function sendOrders(BaseComponentInterface $component)
    {
        $xml = $this->transform($component);

        /** @var Response $response */
        $response = $this->httpClient->post(
            $this->serverDomain.'/XMLGate/inbound',
            [
                'body' => [
                    'xmlmsg' => $xml,
                ]
            ]
        );

        /** @var ModelResponse $responseObject */
        $responseObject = $this->serializer->deserialize(
            (string) $response->getBody(),
            'Whisller\TechData\ResponseModels\Response',
            'tech_data'
        );

        if ($responseObject->isFailure()) {
            throw new TechDataException(
                trim($responseObject->getFailure()->getMessage()),
                $responseObject->getFailure()->getCode()
            );
        }

        return $responseObject;
    }

    protected function transform(BaseComponentInterface $component)
    {
        $xml = $this->serializer->serialize($component, 'xml');

        $xml = $this->postProcess(
            $xml,
            $component->getType(),
            $this->serverDomain.$component->getDTD()
        );

        $this->validator->validate($xml, $this->serverDomain.$component->getXSD());

        return $xml;
    }

    protected function postProcess($xml, $doctype, $dtd)
    {
        return str_replace(
            '<?xml version="1.0" encoding="UTF-8"?>',
            sprintf('<?xml version="1.0" encoding="UTF-8"?>'."\n".'<!DOCTYPE %s SYSTEM "%s">', $doctype, $dtd),
            $xml
        );
    }
}
