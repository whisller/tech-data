<?php

namespace Whisller\TechData\BuilderComponents;

class OrderComponent extends AbstractComponent implements Component
{
    protected function initialize()
    {
        $this->currentXml = $this->parentXml->addChild('Order');
        $this->currentXml->addAttribute('Currency', $this->getParameter('currency'));
    }

    public function addHead()
    {
        return new HeadComponent($this->currentXml, $this);
    }

    public function addBody()
    {
        return new BodyComponent($this->currentXml, $this);
    }

    public function end()
    {
        return $this->parent;
    }
}
