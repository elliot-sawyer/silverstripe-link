<?php

namespace gorriecoe\Link\Extensions;

use gorriecoe\Link\Models\Link;
use Page;
use Sheadawson\DependentDropdown\Forms\DependentDropdownField;
use SilverStripe\CMS\Model\SiteTree;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\TreeDropdownField;
use SilverStripe\Forms\TextField;
use SilverStripe\ORM\DataExtension;
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
class LinkSiteTree extends DataExtension
{
    /**
     * Database fields
     * @var array
     */
    private static $db = [
        'QueryString' => 'Varchar(255)',
        'Anchor' => 'Varchar(255)',
    ];

    /**
     * Has_one relationship
     * @var array
     */
    private static $has_one = [
        'SiteTree' => SiteTree::class
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
     * @param string $sitetree_field_label
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
        $sitetree_field_label = $config->get('sitetree_field_label') ?: 'MenuTitle';

        // Get source data for the ElementID field
        $anchorOptions = function ($pageID) {
            $anchorOptions = [];
            $page = Page::get_by_id($pageID);
            if($page) {
                $list = $page->getAnchorsOnPage();
                $anchorOptions = array_combine($list, $list);
            }

            if (!empty($anchorOptions)) {
                $results = array_merge(
                    ['' => _t(__CLASS__ . '.SELECTANCHOR', '(Select an anchor)')],
                    $anchorOptions
                );
            } else {
                $results = [
                    '' => _t(__CLASS__ . '.ANCHORSNOTAVAILABLE', '(Anchors are not available for the selected page)')
                ];
            }

            return $results;
        };

        // Get field label for the ElementID field
        $anchorLabel = _t(__CLASS__  . '.AnchorLabel', 'Anchor on page');

        // Insert site tree field after the file selection field
        $fields->insertAfter(
            'Type',
            Wrapper::create(
                $sitetreeField = TreeDropdownField::create(
                    'SiteTreeID',
                    _t(__CLASS__ . '.PAGE', 'Page'),
                    SiteTree::class
                )
                    ->setTitleField($sitetree_field_label)
                    ->setHasEmptyDefault(true),
                TextField::create(
                    'Querystring',
                    _t(__CLASS__ . '.QUERYSTRING', 'Querystring')
                ),
                DependentDropdownField::create(
                    'Anchor',
                    $anchorLabel,
                    $anchorOptions
                )
                    ->setDepends($sitetreeField),
            )
            ->displayIf('Type')->isEqualTo('SiteTree')->end()
        );

        // Display warning if the selected page is deleted or unpublished
        if ($owner->SiteTreeID && !$owner->SiteTree()->isPublished()) {
            $sitetreeField->setDescription(_t(__CLASS__ . '.DELETEDWARNING', 'Warning: The selected page appears to have been deleted or unpublished. This link may not appear or may be broken in the frontend'));
        }
    }

    public function updateIsCurrent(&$status)
    {
        $owner = $this->owner;
        if (
            $owner->Type == 'SiteTree' &&
            isset($owner->SiteTreeID) &&
            $owner->CurrentPage instanceof SiteTree &&
            $currentPage = $owner->CurrentPage
        ) {
            $status = $currentPage === $owner->SiteTree() || $currentPage->ID === $owner->SiteTreeID;
        }
    }

    public function updateIsSection(&$status)
    {
        $owner = $this->owner;
        if (
            $owner->Type == 'SiteTree' &&
            isset($owner->SiteTreeID) &&
            $owner->CurrentPage instanceof SiteTree &&
            $currentPage = $owner->CurrentPage
        ) {
            $status = $owner->isCurrent() || in_array($owner->SiteTreeID, $currentPage->getAncestors()->column());
        }
    }

    public function updateIsOrphaned(&$status)
    {
        $owner = $this->owner;
        if (
            $owner->Type == 'SiteTree' &&
            isset($owner->SiteTreeID) &&
            $owner->CurrentPage instanceof SiteTree &&
            $currentPage = $owner->CurrentPage
        ) {
            // Always false for root pages
            if (empty($owner->SiteTree()->ParentID)) {
                $status = false;
                return;
            }

            // Parent must exist and not be an orphan itself
            $parent = $owner->Parent();
            $status = !$parent || !$parent->exists() || $parent->isOrphaned();
        }
    }


    /**
     * {@inheritDoc}
     */
    public function onBeforeWrite()
    {
        parent::onBeforeWrite();

        $owner = $this->getOwner();

        if (empty($owner->Title) && $owner->Type === "SiteTree" && $owner->SiteTreeID && $owner->ElementID && $element = $owner->Element()) {
            $owner->Title = $element->Title;
        }
        $owner->Querystring = $owner->Querystring ? str_replace('?', '', (string) $owner->QueryString) : $owner->Querystring;
        $owner->Anchor = $owner->Anchor ? str_replace('#', '', (string) $owner->Anchor) : $owner->Anchor;
    }
}
