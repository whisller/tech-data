<?php

namespace Whisller\TechData\ResponseModels;

use JMS\Serializer\Annotation as Serializer;

/**
 * @Serializer\XmlRoot("XGResponse")
 */
class XGResponse
{
    /**
     * @Serializer\Type("Whisller\TechData\ResponseModels\Failure")
     * @Serializer\XmlList(entry = "Failure")
     * @Serializer\SerializedName("Failure")
     */
    protected $failure;

    /**
     * @return Failure
     */
    public function getFailure()
    {
        return $this->failure;
    }

    public function isFailure()
    {
        return !empty($this->failure);
    }
}
