<?php

namespace Whisller\TechData\BuilderComponents;

class BodyComponent extends AbstractComponent
{
    protected function initialize()
    {
        $this->currentXml = $this->parentXml->addChild('Body');
    }

    public function addLine($id)
    {
        return new LineComponent($this->currentXml, $this, ['id' => $id]);
    }
}
