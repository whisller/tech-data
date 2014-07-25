<?php

namespace Whisller\TechData\Components;

use JMS\Serializer\Annotation as Serializer;

/**
 * @Serializer\XmlRoot("Address")
 */
class AddressComponent implements ComponentInterface
{
    /**
     * @Serializer\Type("string")
     * @Serializer\SerializedName("Name1")
     */
    protected $addressLine1;
    /**
     * @Serializer\Type("string")
     * @Serializer\SerializedName("Name2")
     */
    protected $addressLine2;
    /**
     * @Serializer\Type("string")
     * @Serializer\SerializedName("Name3")
     */
    protected $addressLine3;
    /**
     * @Serializer\Type("string")
     * @Serializer\SerializedName("Name4")
     */
    protected $addressLine4;
    /**
     * @Serializer\Type("string")
     * @Serializer\SerializedName("Street")
     */
    protected $street;
    /**
     * @Serializer\Type("string")
     * @Serializer\SerializedName("ZIP")
     */
    protected $zip;
    /**
     * @Serializer\Type("string")
     * @Serializer\SerializedName("City")
     */
    protected $city;
    /**
     * @Serializer\Type("string")
     * @Serializer\SerializedName("District")
     */
    protected $district;
    /**
     * @Serializer\Type("string")
     * @Serializer\SerializedName("Country")
     */
    protected $country;
    /**
     * @Serializer\Type("string")
     * @Serializer\SerializedName("DeliveryNoteLanguage")
     */
    protected $deliveryNoteLanguage;
    /**
     * @Serializer\Type("string")
     * @Serializer\SerializedName("ContactName")
     */
    protected $contactName;
    /**
     * @Serializer\Type("string")
     * @Serializer\SerializedName("ContactPhone")
     */
    protected $contactPhone;
    /**
     * @Serializer\Type("string")
     * @Serializer\SerializedName("ContactMail")
     */
    protected $contactEmail;

    public function __construct($addressLine1, $street, $city, $country)
    {
        $this->addressLine1 = $addressLine1;
        $this->street = $street;
        $this->city = $city;
        $this->country = $country;
    }

    public function setAddressLine2($address)
    {
        $this->addressLine2 = $address;
    }

    public function setAddressLine3($address)
    {
        $this->addressLine3 = $address;
    }

    public function setAddressLine4($address)
    {
        $this->addressLine4 = $address;
    }

    public function setZip($zip)
    {
        $this->zip = $zip;
    }

    public function setDisctrict($district)
    {
        $this->district = $district;
    }

    public function setDeliveryNoteLanguage($language)
    {
        $this->deliveryNoteLanguage = $language;
    }

    public function setContactName($contactName)
    {
        $this->contactName = $contactName;
    }

    public function setContactPhone($contactPhone)
    {
        $this->contactPhone = $contactPhone;
    }

    public function setContactEmail($email)
    {
        $this->contactEmail = $email;
    }
}
