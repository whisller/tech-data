<?php

namespace Whisller\TechData\ResponseModels;

use JMS\Serializer\Annotation as Serializer;

/**
 * @Serializer\XmlRoot("XGResponse")
 */
class Response
{
    /**
     * @Serializer\Type("Whisller\TechData\ResponseModels\Failure")
     * @Serializer\XmlList(entry = "Failure")
     * @Serializer\SerializedName("Failure")
     */
    protected $failure;
    /**
     * @Serializer\Type("Whisller\TechData\ResponseModels\Success")
     * @Serializer\XmlList(entry = "Success")
     * @Serializer\SerializedName("Success")
     */
    protected $success;

    /**
     * @return Failure
     */
    public function getFailure()
    {
        return $this->failure;
    }

    /**
     * @return Success
     */
    public function getSuccess()
    {
        return $this->success;
    }

    public function isFailure()
    {
        return !empty($this->failure);
    }
}
