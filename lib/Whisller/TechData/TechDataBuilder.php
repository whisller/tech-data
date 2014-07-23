<?php

namespace Whisller\TechData;

use SimpleXMLElement;
use Whisller\TechData\BuilderComponents\OrderComponent;

class TechDataBuilder
{
    private $xml;
    private $template = '<?xml version="1.0" encoding="ISO-8859-1" ?><!DOCTYPE OrderEnv SYSTEM "%s"><OrderEnv AuthCode="%s" MsgID="%d"></OrderEnv>';

    public function __construct($dtd, $authCode, $msgId)
    {
        $this->xml = new SimpleXMLElement(sprintf($this->template, $dtd, $authCode, $msgId));
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
