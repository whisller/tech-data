<?php

namespace Whisller\TechData\Components;

use JMS\Serializer\Annotation as Serializer;

/**
 * @Serializer\XmlRoot("DeliverTo")
 */
class DeliverToComponent
{
    /**
     * @Serializer\Type("Whisller\TechData\Components\AddressComponent")
     * @Serializer\SerializedName("Address")
     */
    protected $address;

    public function setAddress(AddressComponent $address)
    {
        $this->address = $address;
    }
}
