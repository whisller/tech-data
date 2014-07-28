<?php

namespace Whisller\TechData\Components;

interface BaseComponentInterface
{
    public function getXSD();
    public function getDTD();
    public function getType();
}
