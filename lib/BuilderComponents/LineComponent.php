<?php

namespace Whisller\TechData\BuilderComponents;

class LineComponent extends AbstractComponent
{
    protected function initialize()
    {
        $this->currentXml = $this->parentXml->addChild('Line');
        $this->currentXml->addAttribute('ID', $this->getParameter('id'));
    }

    public function setItemId($id)
    {
        $this->currentXml->addChild('ItemID', $id);

        return $this;
    }

    public function setQty($quntity)
    {
        $this->currentXml->addChild('Qty', $quntity);

        return $this;
    }
}
