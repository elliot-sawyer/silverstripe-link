<?php

namespace gorriecoe\Link\Extensions;

use SilverStripe\Core\Convert;
use SilverStripe\Core\Extension;

/**
 * Add sitetree type to link field
 *
 * @package silverstripe-link
 */
class AutomaticMarkupID extends Extension
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
