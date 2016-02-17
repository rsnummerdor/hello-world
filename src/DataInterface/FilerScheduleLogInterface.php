<?php

/*
 * This file is part of the FollowTheMoney package created by the
 * National Institute on Money in State Politics.
 *
 *  (c) National Institute for Money in State Politics <is@followthemoney.org>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace nimsp\FollowTheMoney;

/**
 * Description of FilerScheduleLogInterface
 *
 * @author Roger Nummerdor <rogern@followthemoney.org>
 */
class FilerScheduleLogInterface
{
    private $DB;

    public function __construct()
    {
        global $NIMSPv4;
        $this->DB = $NIMSPv4;
    }

    /* ======================= save ========================================= */

    public function save(FilerScheduleLog $FSL)
    {
        $stmt = $this->DB->prepare('
            INSERT
            INTO Research.FilerScheduleLog
                    (ResearcherID, ChangeTypeID, FSID, FilerScheduleLogText, FilerScheduleLogComment)
            VALUES ( ?,?,?,?,? ) ');
        $stmt->bind_param('iiiss', $FSL->ResearcherID, $FSL->FilerScheduleID, $FSL->ChangeTypeID, $FSL->Text, $FSL->Comment);
        $FSL->FilerScheduleLogID = $this->DB->insert_id;
        return $stmt->execute();
    }

    /* ======================= updateComment =================================== */

    public function updateComment(FilerScheduleLog $FSL)
    {
        if (empty($FSL->FilerScheduleLogID)) {
// We can't update a record unless it exists...
            exit('Cannot update an FilerScheduleLog record without a FilerScheduleLogID.');
        }

        $stmt = $this->DB->prepare('
            UPDATE Research.FilerScheduleLog
            SET FilerScheduleComment = ?
            WHERE FilerScheduleLogID = ? ');
        $stmt->bindParam('si', $FSL->Comment, $FSL->FilerScheduleLogID);
        $retVal = $stmt->execute();
        return $retVal;
    }
}
