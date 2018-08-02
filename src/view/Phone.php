<?php

namespace gorriecoe\Link\View;

use libphonenumber\PhoneNumberFormat;
use libphonenumber\PhoneNumberType;
use libphonenumber\PhoneNumberUtil;
use SilverStripe\View\ViewableData;

/**
 * Phone
 *
 * @package silverstripe-link
 */
class Phone extends ViewableData
{
    /**
     * @var string
     */
    protected $phoneNumber = null;

    /**
     * @var \libphonenumber\PhoneNumberUtil
     */
    protected $library;

    /**
     * @var int
     */
    protected $phoneNumberFormat = PhoneNumberFormat::E164;

    /**
     * The provided phone country.
     *
     * @var string
     */
    protected $country = 'NZ';

    public function __construct($phone)
    {
        $this->phoneNumber = $phone;
        $this->library = PhoneNumberUtil::getInstance();
        parent::__construct($phone);
    }

    /**
     * Format the phone number in international format.
     */
    public function International()
    {
        $this->phoneNumberFormat = PhoneNumberFormat::INTERNATIONAL;
        return $this;
    }
    /**
     * Format the phone number in national format.
     */
    public function National()
    {
        $this->phoneNumberFormat = PhoneNumberFormat::NATIONAL;
        return $this;
    }
    /**
     * Format the phone number in E164 format.
     */
    public function E164()
    {
        $this->phoneNumberFormat = PhoneNumberFormat::E164;
        return $this;
    }
    /**
     * Format the phone number in RFC3966 format.
     */
    public function RFC3966()
    {
        $this->phoneNumberFormat = PhoneNumberFormat::RFC3966;
        return $this;
    }

    /**
     * Set the country to which the phone number belongs to.
     *
     * @param string $country
     */
    public function ofCountry($country)
    {
        $this->country = $country;
        return $this;
    }

    /**
     * Get the PhoneNumber instance of the current number.
     *
     * @return \libphonenumber\PhoneNumber
     */
    public function getInstance()
    {
        return $this->library->parse(
            $this->phoneNumber,
            $this->country
        );
    }

    /**
     * @return HTML
     */
    public function Render()
    {
        $value = $this->library->format(
            $this->Instance,
            $this->phoneNumberFormat
        );
        return $value;
    }

    /**
     * @return HTML
     */
    public function forTemplate()
    {
        return $this->Render();
    }
}
