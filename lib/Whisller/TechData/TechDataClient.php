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
    protected $mode;

    public function __construct(ClientInterface $client, SerializerInterface $serializer, $mode = 'test')
    {
        $this->httpClient = $client;
        $this->serializer = $serializer;
        $this->mode = $mode;
    }

    public function sendOrders($xml)
    {
        /** @var Response $response */
        $response = $this->httpClient->post(
            'https://intcom.xml.techdata-europe.com:443/XMLGate/inbound',
            [
                'body' => [
                    'xmlmsg' => $xml,
                ]
            ]
        );

        $this->processResponse($response);
    }

    protected function processResponse(Response $response)
    {
        $this->checkIfItIsFailure((string) $response->getBody());
    }

    protected function checkIfItIsFailure($body)
    {
        /** @var XGResponse $XGResponse */
        $XGResponse = $this->serializer->deserialize($body, 'Whisller\TechData\ResponseModels\XGResponse', 'tech_data');

        if ($XGResponse->isFailure()) {
            throw new TechDataException(
                trim($XGResponse->getFailure()->getMessage()),
                $XGResponse->getFailure()->getCode()
            );
        }
    }
}
