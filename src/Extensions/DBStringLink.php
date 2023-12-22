<?php

namespace gorriecoe\Link\Extensions;

use SilverStripe\Core\Convert;
use SilverStripe\ORM\DataExtension;
use gorriecoe\Link\View\Phone;

/**
 * Adds methods to DBString to help manipulate the output suitable for links
 *
 * @property \SilverStripe\ORM\FieldType\DBString&\gorriecoe\Link\Extensions\DBStringLink $owner
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
        $value = $this->owner->value;
        if ($value) {
            return Phone::create($value);
        }
    }
}
