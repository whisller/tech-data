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
            'OrderEnv',
            'http://intcom.xml.quality.techdata.de:8080/XMLGate/XMLGateResponse.dtd'
        );

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

    protected function prepareRequestData($component, $doctype, $dtd)
    {
        return preg_replace(
            preg_quote('/<?xml version="1.0" encoding="UTF-8"?>/'),
            sprintf("<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n<!DOCTYPE %s SYSTEM \"%s\">", $doctype, $dtd),
            $this->serializer->serialize($component, 'xml')
        );
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
