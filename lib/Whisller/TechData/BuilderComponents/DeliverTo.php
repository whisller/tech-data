<?php

namespace Whisller\TechData\BuilderComponents;

class DeliverTo extends AbstractComponent
{
    protected function initialize()
    {
        $this->currentXml = $this->parentXml->addChild('DeliverTo');
    }
}
