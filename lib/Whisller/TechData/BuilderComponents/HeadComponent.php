<?php

namespace Whisller\TechData\BuilderComponents;

class HeadComponent extends AbstractComponent implements Component
{
    protected function initialize()
    {
        $this->currentXml = $this->parentXml->addChild('Head');
    }

    public function setTitle($title)
    {
        $this->currentXml->addChild('Title', $title);

        return $this;
    }

    public function setOrderDate($orderDate)
    {
        $this->currentXml->addChild('OrderDate', $orderDate);

        return $this;
    }

    public function addDeliverTo()
    {
        return new DeliverTo($this->currentXml, $this);
    }

    public function setDelivery($type, $full)
    {
        $delivery = $this->currentXml->addChild('Delivery');
        $delivery->addAttribute('Type', $type);
        $delivery->addAttribute('Full', $full);

        return $this;
    }

    public function end()
    {
        return $this->parent;
    }
} 
