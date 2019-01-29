<?php

namespace gorriecoe\Link\Extensions;

use SilverStripe\ORM\DataExtension;

/**
 * Allows usage of link model with has_many relationships.
 */
class SortableLink extends DataExtension
{
    private static $db = [
        'Sort' => 'Int'
    ];
}