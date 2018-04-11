<?php

namespace gorriecoe\Link\Extensions;

use SilverStripe\Core\Convert;
use SilverStripe\ORM\DataExtension;

/**
 * Adds methods to DBString to help manipulate the output suitable for links
 *
 * @package silverstripe-link
 */
class DBStringLink extends DataExtension
{
    /**
     * Provides string replace to allow link friendly urls
     * @return string
     */
    public function LinkFriendly()
    {
        return Convert::raw2url($this->owner->value);
    }

    /**
     * @alias LinkFriendly
     * @return string
     */
    public function URLFriendly()
    {
        return $this->LinkFriendly($this->owner->value);
    }

    /**
     * Provides string replace to allow phone number friendly urls
     * @return string
     */
    public function PhoneFriendly()
    {
        $ReplacementMap = array(
            'a'=>'2', 'b'=>'2', 'c'=>'2',
            'd'=>'3', 'e'=>'3', 'f'=>'3',
            'g'=>'4', 'h'=>'4', 'i'=>'4',
            'j'=>'5', 'k'=>'5', 'l'=>'5',
            'm'=>'6', 'n'=>'6', 'o'=>'6',
            'p'=>'7', 'q'=>'7', 'r'=>'7', 's'=>'7',
            't'=>'8', 'u'=>'8', 'v'=>'8',
            'w'=>'9', 'x'=>'9', 'y'=>'9', 'z'=>'9',
            '+'=>'00',
            ' '=>''
        );
        $value = str_ireplace(
            array_keys($ReplacementMap),
            array_values($ReplacementMap),
            $this->owner->value
        );

        // Strip out everything else
        $value = preg_replace('/[^0-9\,]+/', '', $value);

        return $value;
    }
}
