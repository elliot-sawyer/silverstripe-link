<?php

namespace gorriecoe\Link\Extensions;

use gorriecoe\Link\Models\Link;
use SilverStripe\Core\Extension;

/**
 * Fixes duplicate link in SiteTree
 *
 * @package silverstripe-link
 */
class SiteTreeLink extends Extension
{
    /**
     * Event handler called before duplicating a sitetree object.
     */
    public function onBeforeDuplicate()
    {
        $owner = $this->owner;
        //loop through has_one relationships and reset any Link fields
        if($hasOne = $owner->Config()->get('has_one')){
            foreach ($hasOne as $field => $fieldType) {
                if ($fieldType === Link::class) {
                    $owner->{$field.'ID'} = 0;
                }
            }
        }
    }
}
