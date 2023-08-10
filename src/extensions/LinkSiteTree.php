<?php

namespace gorriecoe\Link\Extensions;

use DNADesign\Elemental\Models\BaseElement;
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
        'Anchor' => 'Varchar(255)',
    ];

    /**
     * Has_one relationship
     * @var array
     */
    private static $has_one = [
        'SiteTree' => SiteTree::class,
        'Element' => BaseElement::class,
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
     * @var string
     */
    private static $element_prefix = '#e';

    /**
     * Update Fields
     * @param FieldList $fields
     */
    public function updateCMSFields(FieldList $fields)
    {
        $owner = $this->owner;
        $config = $owner->config();
        $sitetree_field_label = $config->get('sitetree_field_label') ? : 'MenuTitle';

        // Get source data for the ElementID field
        $elenmentFieldSource = function ($pageID) {
            $elements = $this->getElements($pageID);

            if (!empty($elements)) {
                $results = array_merge(
                    ['' => _t(__CLASS__ . '.SelectBlock', '(Select a block)')],
                    $elements
                );
            }
            else {
                $results = [
                    '' => _t(__CLASS__ . '.BlockIsNotAvailable', '(Block is not available for the selected page)')
                ];
            }

            return $results;
        };
        
        // Get field label for the ElementID field
        $elenmentFieldLabel = _t(__CLASS__  . '.SpecificBlockOnThePage', 'Specific Block on the Page');
        
        // Additional information for the Anchor field
        $anchorIngoringInfo = _t(
            __CLASS__  . '.AnchorIngoringInfo',
            '. Note that this field is ignored if <strong>{field}</strong> field is set.',
            ['field' => $elenmentFieldLabel]
        );

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
                DependentDropdownField::create(
                    'ElementID',
                    $elenmentFieldLabel,
                    $elenmentFieldSource
                )
                ->setDepends($sitetreeField),
                TextField::create(
                    'Anchor',
                    _t(__CLASS__ . '.ANCHOR', 'Anchor/Querystring')
                )
                ->setDescription(_t(__CLASS__ . '.ANCHORINFO', 'Include # at the start of your anchor name or, ? at the start of your querystring') . $anchorIngoringInfo)
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

    /**
     *  Get elements for the given page ID
     */
    public function getElements(int $pageID): array
    {
        $elements = [];

        if ($page = Page::get_by_id($pageID)) {
            if ($page->hasMethod('supportsElemental') && $page->supportsElemental()) {
                $elementalAreas = $page->getElementalRelations();
    
                foreach ($elementalAreas as $areaName) {
                    foreach ($page->$areaName->Elements() as $element) {
                        $elements[$element->ID] = $element->Title;
                    }
                }
            }
        }

        return $elements;
    }

    /**
     * Update link url
     */
    public function updateLinkURL(&$linkUrl)
    {
        if ($linkUrl && $this->owner->Type === 'SiteTree' && $this->owner->ElementID) {
            if ($this->owner->Anchor) {
                $linkUrl = strtok($linkUrl, "?");
                $linkUrl = strtok($linkUrl, "#");
            }

            $linkUrl = $linkUrl . $this->owner->config()->get('element_prefix') . $this->owner->ElementID;
        }
    }

    /**
     * {@inheritDoc}
     */
    public function onBeforeWrite()
    {
        parent::onBeforeWrite();

        $owner = $this->owner;

        if (empty($owner->Title) && $owner->Type === "SiteTree" && $owner->SiteTreeID && $owner->ElementID && $element = $owner->Element()) {
            $owner->Title = $element->Title;
        }
    }
}
