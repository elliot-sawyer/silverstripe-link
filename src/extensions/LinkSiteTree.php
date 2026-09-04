<?php

namespace gorriecoe\Link\Extensions;

use gorriecoe\Link\Models\Link;
use SilverStripe\CMS\Model\SiteTree;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\TreeDropdownField;
use SilverStripe\Forms\TextField;
use SilverStripe\Core\Extension;
use UncleCheese\DisplayLogic\Forms\Wrapper;

/**
 * Add sitetree type to link object
 *
 * @package silverstripe-link
 *
 * @property Link|$this owner
 * @property int SiteTreeID
 * @method SiteTree SiteTree()
 */
class LinkSiteTree extends Extension
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
     * Defines the label used in the sitetree dropdown.
     * @param String $sitetree_field_label
     */
    private static $sitetree_field_label = 'MenuTitle';

    /**
     * Update Fields
     * @param FieldList $fields
     */
    public function updateCMSFields(FieldList $fields)
    {
        $owner = $this->owner;
        $config = $owner->config();
        $sitetree_field_label = $config->get('sitetree_field_label') ? : 'MenuTitle';

        // Insert site tree field after the file selection field
        $fields->insertAfter(
            'Type',
            Wrapper::create(
                $sitetreeField = TreeDropdownField::create(
                    'SiteTreeID',
                    _t(__CLASS__ . '.PAGE', 'Page'),
                    SiteTree::class
                )
                ->setTitleField($sitetree_field_label),
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
            $sitetreeField->setDescription(_t(__CLASS__ . '.DELETEDWARNING', 'Warning: The selected page appears to have been deleted or unpublished. This link may not appear or may be broken in the frontend'));
        }
    }

    /**
     * @return bool
     */
    public function updateIsCurrent(&$status)
    {
        $owner = $this->owner;
        if (
            $owner->Type == 'SiteTree' &&
            isset($owner->SiteTreeID) &&
            $owner->CurrentPage instanceof SiteTree &&
            $currentPage = $owner->CurrentPage
        ){
            $status = $currentPage === $owner->SiteTree() || $currentPage->ID === $owner->SiteTreeID;
        }
    }

    /**
     * @return bool
     */
    public function updateIsSection(&$status)
    {
        $owner = $this->owner;
        if (
            $owner->Type == 'SiteTree' &&
            isset($owner->SiteTreeID) &&
            $owner->CurrentPage instanceof SiteTree &&
            $currentPage = $owner->CurrentPage
        ){
            $status = $owner->isCurrent() || in_array($owner->SiteTreeID, $currentPage->getAncestors()->column());
        }
    }

    /**
     * @return bool
     */
    public function updateIsOrphaned(&$status)
    {
        $owner = $this->owner;
        if (
            $owner->Type == 'SiteTree' &&
            isset($owner->SiteTreeID) &&
            $owner->CurrentPage instanceof SiteTree &&
            $currentPage = $owner->CurrentPage
        ){
            // Always false for root pages
            if (empty($owner->SiteTree()->ParentID)) {
                $status = false;
                return;
            }

            // Parent must exist and not be an orphan itself
            $parent = $this->Parent();
            $status = !$parent || !$parent->exists() || $parent->isOrphaned();
        }
    }
}
