<?php

namespace gorriecoe\Link\Tasks;

use SilverStripe\Dev\BuildTask;
use Sheadawson\Linkable\Models\Link as OldLink;
use gorriecoe\Link\Models\Link;

/**
 * Description
 *
 * @package silverstripe
 * @subpackage mysite
 */
class SheadawsonLinkableToLinkTask extends BuildTask
{
    /**
     * @var bool $enabled If set to FALSE, keep it from showing in the list
     * and from being executable through URL or CLI.
     */
    protected $enabled = true;

    /**
     * @var string $title Shown in the overview on the TaskRunner
     * HTML or CLI interface. Should be short and concise, no HTML allowed.
     */
    protected $title = 'Migrate linkable to link';

    /**
     * @var string $description Describe the implications the task has,
     * and the changes it makes. Accepts HTML formatting.
     */
    protected $description = 'Migrates linkable db fields to link';

    /**
     * This method called via the TaskRunner
     *
     * @param SS_HTTPRequest $request
     */
    public function run($request)
    {
        $oldRecords = OldLink::get();
        echo _t(
            __CLASS__ . '.FOUNDRECORDS',
            'Found {Count} Linkable records',
            [
                'Count' => $oldRecords->Count()
            ]
        );
        echo "<br>";
        foreach ($oldRecords as $oldRecord) {
            $oldRecord = $oldRecord->toMap();
            $oldRecordID = $oldRecord['ID'];
            unset($oldRecord['ClassName'], $oldRecord['RecordClassName'], $oldRecord['ID']);
            $recordID = Link::create(
                $oldRecord
            )->write();
            echo _t(
                __CLASS__ . '.MIGRATED',
                'Migrated from linkable {OldLinkTitle}({OldRecordID}) to link({RecordID})',
                [
                    'OldLinkTitle' => $oldRecord['Title'],
                    'OldRecordID' => $oldRecordID,
                    'RecordID' => $recordID
                ]
            );
            echo "<br>";
        }
        echo _t(
            __CLASS__ . '.FOUNDMIGRATED',
            'Found {Count} Link records',
            [
                'Count' => Link::get()->Count()
            ]
        );
    }
}
