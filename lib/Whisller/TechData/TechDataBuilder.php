<?php

namespace Whisller\TechData;

use SimpleXMLElement;
use Whisller\TechData\BuilderComponents\OrderComponent;

class TechDataBuilder
{
    private $xml;

    public function __construct($dtd)
    {
        $this->xml = new SimpleXMLElement('<?xml version="1.0" encoding="ISO-8859-1" ?><!DOCTYPE OrderEnv SYSTEM "'.$dtd.'"><OrderEnv AuthCode="123456" MsgID="1"></OrderEnv>');
    }

    public function addOrder($currency)
    {
        return (new OrderComponent($this->xml, null, ['currency' => $currency]));
    }

    public function __toString()
    {
        return (string) $this->xml->asXML();
    }
} 
