<?php

namespace Whisller\TechData\ResponseModels;

use JMS\Serializer\Annotation as Serializer;

/**
 * @Serializer\XmlRoot("Failure")
 */
class Failure
{
    /**
     * @Serializer\XmlAttribute
     * @Serializer\Type("integer")
     */
    protected $code;

    /**
     * @Serializer\Type("string")
     * @Serializer\SerializedName("Failure")
     * @Serializer\XmlValue
     */
    protected $message;

    public function getCode()
    {
        return $this->code;
    }

    public function getMessage()
    {
        return $this->message;
    }
}
