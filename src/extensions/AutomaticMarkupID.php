<?php

namespace gorriecoe\Link\Extensions;

use SilverStripe\Core\Convert;
use SilverStripe\ORM\DataExtension;

/**
 * Add sitetree type to link field
 *
 * @package silverstripe-link
 */
class AutomaticMarkupID extends DataExtension
{
    /**
     * Renders an HTML ID attribute for this link
     */
    public function updateIDValue(&$id)
    {
        $owner = $this->owner;
        if ($owner->Title) {
            $id = Convert::raw2url($owner->Title);
        }
    }
}
