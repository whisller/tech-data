<?php

namespace Whisller\TechData\Transformers;

use JMS\Serializer\SerializerInterface;
use Whisller\TechData\Components\ComponentInterface;
use Whisller\TechData\TechDataDTDValidator;

class TransformerToXml
{
    protected $serializer;
    protected $dtdValidator;
    protected $mode;
    protected $xsd = [
        'test' => [
            'OrderEnv' => 'https://integratex.quality.techdata.de:443/ix/dtd/ixOrder4.xsd',
        ],
        'live' => [
            'OrderEnv' => 'https://integratex.techdata.com:443/ix/dtd/ixOrder4.xsd',
        ]
    ];
    protected $dtd = [
        'test' => [
            'OrderEnv' => 'https://integratex.quality.techdata.de:443/ix/dtd/ixOrder4.dtd',
        ],
        'live' => [
            'OrderEnv' => 'https://integratex.techdata.com:443/ix/dtd/ixOrder4.dtd',
        ]
    ];
    protected $componentToDoctype = [
        'Whisller\TechData\Components\OrderEnvComponent' => 'OrderEnv'
    ];

    public function __construct(SerializerInterface $serializer, TechDataDTDValidator $dtdValidator, $mode = 'test')
    {
        $this->serializer = $serializer;
        $this->dtdValidator = $dtdValidator;
        $this->mode = $mode;
    }

    public function transform(ComponentInterface $component)
    {
        $xml = $this->serializer->serialize($component, 'xml');

        $doctype = $this->componentToDoctype[get_class($component)];

        $xml = $this->postProcess(
            $xml,
            $doctype,
            $this->dtd[$this->mode][$doctype]
        );

        $this->dtdValidator->validate($xml);

        return $xml;
    }

    protected function postProcess($xml, $doctype, $dtd)
    {
        return preg_replace(
            preg_quote('/<?xml version="1.0" encoding="UTF-8"?>/'),
            sprintf("<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n<!DOCTYPE %s SYSTEM \"%s\">", $doctype, $dtd),
            $xml
        );
    }
}
