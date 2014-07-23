<?php

namespace Whisller\TechData\BuilderComponents;

use SimpleXMLElement;

abstract class AbstractComponent implements Component
{
    /**
     * @var Component|null
     */
    protected $parent;
    /**
     * @var SimpleXMLElement
     */
    protected $parentXml;
    /**
     * @var SimpleXMLElement
     */
    protected $currentXml;
    /**
     * @var array
     */
    private $parameters;

    public function __construct(SimpleXMLElement $parentXml, Component $parent = null, array $parameters = [])
    {
        $this->parentXml = $parentXml;
        $this->parent = $parent;
        $this->parameters = $parameters;

        $this->initialize();
    }

    abstract protected function initialize();

    public function getParameter($name)
    {
        return $this->parameters[$name];
    }

    public function end()
    {
        return $this->parent;
    }
} 
