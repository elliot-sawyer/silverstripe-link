<?php

namespace gorriecoe\Link\Extensions;

use SilverStripe\CMS\Model\SiteTree;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\TreeDropdownField;
use SilverStripe\Forms\TextField;
use SilverStripe\ORM\DataExtension;
use UncleCheese\DisplayLogic\Forms\Wrapper;

/**
 * Add sitetree type to link field
 *
 * @package silverstripe-link
 */
class LinkSiteTree extends DataExtension
{
    /**
     * Database fields
     * @var array
     */
    private static $db = [
        'Anchor' => 'Varchar(255)',
    ];

    /**
     * Has_one relationship
     * @var array
     */
    private static $has_one = [
        'SiteTree' => SiteTree::class,
    ];

    /**
     * A map of object types that can be linked to
     * Custom dataobjects can be added to this
     *
     * @var array
     **/
    private static $types = [
        'SiteTree' => 'Page on this website',
    ];

    /**
     * Update Fields
     * @param FieldList $fields
     */
    public function updateCMSFields(FieldList $fields)
    {
        $owner = $this->owner;

        // Insert site tree field after the file selection field
        $fields->insertAfter(
            'Type',
            Wrapper::create(
                TreeDropdownField::create(
                    'SiteTreeID',
                    _t(__CLASS__ . '.PAGE', 'Page'),
                    SiteTree::class
                ),
                TextField::create(
                    'Anchor',
                    _t(__CLASS__ . '.ANCHOR', 'Anchor/Querystring')
                )
                ->setDescription(_t(__CLASS__ . '.ANCHORINFO', 'Include # at the start of your anchor name or, ? at the start of your querystring'))
            )
            ->displayIf('Type')->isEqualTo('SiteTree')->end()
        );

        // Display warning if the selected page is deleted or unpublished
        if ($owner->SiteTreeID && !$owner->SiteTree()->isPublished()) {
            $fields
                ->dataFieldByName('SiteTreeID')
                ->setDescription(_t(__CLASS__ . '.DELETEDWARNING', 'Warning: The selected page appears to have been deleted or unpublished. This link may not appear or may be broken in the frontend'));
        }
    }
}
