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
        $xml = $this->prepareRequestData(
            $orderEnv,
            'http://intcom.xml.quality.techdata.de:8080/XMLGate/XMLGateResponse.dtd'
        );

        /** @var Response $response */
        $response = $this->httpClient->post(
            'https://intcom.xml.quality.techdata.de/XMLGate/inbound',
            [
                'body' => [
                    'xmlmsg' => $xml,
                ]
            ]
        );

        $this->processResponse($response);
    }

    private function prepareRequestData($component, $dtd)
    {
        return preg_replace(
            preg_quote('/<?xml version="1.0" encoding="UTF-8"?>/'),
            sprintf("<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n<!DOCTYPE InvoicEnv SYSTEM \"%s\">", $dtd),
            $this->serializer->serialize($component, 'xml')
        );
    }

    private function processResponse(Response $response)
    {
        $this->checkIfItIsFailure((string) $response->getBody());


    }

    private function checkIfItIsFailure($body)
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
