<?php

namespace Whisller\TechData\Components;

use JMS\Serializer\Annotation as Serializer;

/**
 * @Serializer\XmlRoot("DeliverTo")
 */
class DeliverTo
{
    /**
     * @Serializer\Type("Whisller\TechData\Components\Address")
     * @Serializer\SerializedName("Address")
     */
    protected $address;

    public function setAddress(Address $address)
    {
        $this->address = $address;
    }
}
