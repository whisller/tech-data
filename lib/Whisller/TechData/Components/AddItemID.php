<?php

namespace Whisller\TechData\Components;

use JMS\Serializer\Annotation as Serializer;

/**
 * @Serializer\XmlRoot("AddItemID")
 */
class AddItemID
{
    /**
     * @Serializer\XmlAttribute
     * @Serializer\Type("string")
     * @Serializer\SerializedName("Type")
     */
    protected $type;

    /**
     * @Serializer\XmlValue
     * @Serializer\Type("string")
     */
    protected $value;

    public function __construct($type, $value)
    {
        $this->type = $type;
        $this->value = $value;
    }
}
