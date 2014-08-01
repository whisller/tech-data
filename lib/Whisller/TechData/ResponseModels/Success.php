<?php

namespace Whisller\TechData\ResponseModels;

use JMS\Serializer\Annotation as Serializer;

class Success
{
    /**
     * @Serializer\Type("string")
     * @Serializer\SerializedName("Success")
     * @Serializer\XmlValue
     */
    protected $message;
}
