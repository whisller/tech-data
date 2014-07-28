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
    const MODE_TEST = 'test';
    const MODE_LIVE = 'live';

    protected $httpClient;
    protected $serializer;
    protected $validator;
    protected $mode;
    protected $baseDomain = [
        self::MODE_TEST => 'https://integratex.quality.techdata.de:443',
        self::MODE_LIVE => 'https://integratex.techdata.com:443',
    ];

    public function __construct(
        ClientInterface $client,
        SerializerInterface $serializer,
        TechDataValidator $validator,
        $mode = self::MODE_TEST
    ) {
        $this->httpClient = $client;
        $this->serializer = $serializer;
        $this->validator = $validator;
        $this->mode = $mode;
    }

    public function sendOrders(BaseComponentInterface $component)
    {
        $xml = $this->transform($component);

        /** @var Response $response */
        $response = $this->httpClient->post(
            'https://intcom.xml.techdata-europe.com:443/XMLGate/inbound',
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
            $this->baseDomain[$this->mode].$component->getDTD()
        );

        $this->validator->validate($xml, $this->baseDomain[$this->mode].$component->getXSD());

        return $xml;
    }

    protected function postProcess($xml, $doctype, $dtd)
    {
        return str_replace(
            '<?xml version="1.0" encoding="UTF-8"?>',
            sprintf("<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n<!DOCTYPE %s SYSTEM \"%s\">", $doctype, $dtd),
            $xml
        );
    }
}
