<?php

namespace gorriecoe\Link\Extensions;

use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\TextField;
use SilverStripe\Core\Extension;
use SilverStripe\Core\Convert;

/**
 * Add sitetree type to link field
 *
 * @package silverstripe-link
 */
class DefineableMarkupID extends Extension
{
    /**
     * Database fields
     * @var array
     */
    private static $db = [
        'IDCustomValue' => 'Text'
    ];

    /**
     * Update Fields
     * @return FieldList
     */
    public function updateCMSFields(FieldList $fields)
    {
        $owner = $this->owner;
        $fields->addFieldToTab(
            'Root.Main',
            TextField::create(
                'IDCustomValue',
                _t(__CLASS__ . '.ID', 'ID')
            )
            ->setDescription(_t(__CLASS__ . '.IDCUSTOMVALUE', 'Define an ID for the link.  This is particularly useful for google tracking.'))
        );
        return $fields;
    }

    /**
     * Event handler called before writing to the database.
     */
    public function onBeforeWrite()
    {
        $owner = $this->owner;
        $owner->IDCustomValue = Convert::raw2url($owner->IDCustomValue);
    }

    /**
     * Renders an HTML ID attribute for this link
     */
    public function updateIDValue(&$id)
    {
        $owner = $this->owner;
        if ($owner->IDCustomValue) {
            $id = $owner->IDCustomValue;
        }
    }
}
