<?php

namespace Whisller\TechData;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Message\Response;
use JMS\Serializer\SerializerInterface;
use Whisller\TechData\Components\OrderEnvComponent;
use Whisller\TechData\Exceptions\TechDataException;
use Whisller\TechData\ResponseModels\XGResponse;

class TechDataClient
{
    protected $httpClient;
    protected $serializer;

    public function __construct(ClientInterface $client, SerializerInterface $serializer)
    {
        $this->httpClient = $client;
        $this->serializer = $serializer;
    }

    public function sendOrders(OrderEnvComponent $orderEnv)
    {
        /** @var Response $response */
        $response = $this->httpClient->post(
            'https://intcom.xml.quality.techdata.de/XMLGate/inbound',
            [
                'body' => [
                    'xmlmsg' => $this->serializer->serialize($orderEnv, 'xml'),
                ]
            ]
        );

        $this->processResponse($response);
    }

    private function processResponse(Response $response)
    {
        $this->checkIfIsFailure((string) $response->getBody());


    }

    private function checkIfIsFailure($body)
    {
        /** @var XGResponse $XGResponse */
        $XGResponse = $this->serializer->deserialize($body, 'Whisller\TechData\ResponseModels\XGResponse', 'xml');

        if ($XGResponse->isFailure()) {
            throw new TechDataException(
                trim($XGResponse->getFailure()->getMessage()),
                $XGResponse->getFailure()->getCode()
            );
        }
    }
}
