<?php

namespace gorriecoe\Link\View;

use libphonenumber\PhoneNumberFormat;
use libphonenumber\PhoneNumberUtil;
use \libphonenumber\PhoneNumber;
use SilverStripe\View\ViewableData;

/**
 * Phone
 *
 * @package silverstripe-link
 */
class Phone extends ViewableData
{
    /**
     * @var \libphonenumber\PhoneNumberUtil
     */
    protected $library;

    /**
     * @var \libphonenumber\PhoneNumber
     */
    protected $instance;

    /**
     * @var int
     */
    protected $phoneNumberFormat = PhoneNumberFormat::E164;

    /**
     * The country the user is dialing from.
     *
     * @var string
     */
    protected $fromCountry;

    private static $default_country = 'NZ';

    public function __construct($phone)
    {
        $this->library = PhoneNumberUtil::getInstance();
        $country = $this->config()->get('default_country');
        $this->instance = $this->library->parse($phone, $country);
        parent::__construct($phone);
    }

    /**
     * Format the phone number in international format.
     *
     * @return gorriecoe\Link\View\Phone
     */
    public function International()
    {
        $this->phoneNumberFormat = PhoneNumberFormat::INTERNATIONAL;
        return $this;
    }

    /**
     * Format the phone number in national format.
     *
     * @return gorriecoe\Link\View\Phone
     */
    public function National()
    {
        $this->phoneNumberFormat = PhoneNumberFormat::NATIONAL;
        return $this;
    }

    /**
     * Format the phone number in E164 format
     *
     * @return gorriecoe\Link\View\Phone.
     */
    public function E164()
    {
        $this->phoneNumberFormat = PhoneNumberFormat::E164;
        return $this;
    }

    /**
     * Format the phone number in RFC3966 format.
     *
     * @return gorriecoe\Link\View\Phone
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
     * @return gorriecoe\Link\View\Phone
     */
    public function To($country)
    {
        $country = $this->library->getMetadataForRegion($country);
        $this->instance->setCountryCode($country->getCountryCode());
        return $this;
    }

    /**
     * Set the country the user is dialing from.
     *
     * @param string $country
     * @return gorriecoe\Link\View\Phone
     */
    public function From($country)
    {
        $this->fromCountry = $country;
        return $this;
    }

    /**
     * Sets whether this phone number uses a leading zero.
     *
     * @param bool $value True to use italian leading zero, false otherwise.
     * @return gorriecoe\Link\View\Phone
     */
    public function LeadingZero($value = true)
    {
        $this->instance->setItalianLeadingZero($value);
        return $this;
    }

    /**
     * @return HTML
     */
    public function Render()
    {
        if ($this->fromCountry) {
            return $this->library->formatOutOfCountryCallingNumber(
                $this->instance,
                $this->fromCountry
            );
        } else {
            return $this->library->format(
                $this->instance,
                $this->phoneNumberFormat
            );
        }
    }

    /**
     * @return HTML
     */
    public function forTemplate()
    {
        return $this->Render();
    }
}
