<?php

namespace nimsp\FollowTheMoney;

/*
 * This file is part of the FollowTheMoney package created by the
 * National Institute on Money in State Politics.
 *
 *  (c) National Institute for Money in State Politics <is@followthemoney.org>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

/**
 * Description of FilerScheduleInterface
 *
 * @author Roger Nummerdor <rogern@followthemoney.org>
 */
class FilerScheduleInterface
{

    private $DB;

    public function __construct()
    {
        global $NIMSPv4;
        $this->DB = $NIMSPv4;
    }

    /* ======================= load ========================================= */

    public function load($FilerScheduleID)
    {
        if (empty($FilerScheduleID)) {
            exit("Cant load a record without an ID.");
        }
        $stmt = $this->DB->prepare('
            SELECT FilerScheduleID, FilerID, GridID, FilerScheduleDataTypeID,
                OptionalDistrictID, CoreData, FilerScheduleComment,
                FilerScheduleTimestamp, Year, Jurisdiction
            FROM FilerSchedule JOIN Grid USING (GridID)
            WHERE FilerScheduleID = :FilerScheduleID ');
        $stmt->bindParam(':FilerScheduleID', $FilerScheduleID);
        $stmt->execute();

        $result = $stmt->get_result();
        $data = $result->fetch_assoc();

        $stmt->free_result();
        return new FilerSchedule($data);
    }

    /* ======================= save ========================================= */

    public function save(FilerSchedule $FS, $text = null, $changeTypeID = null, $comment = null)
    {
// If the ID is set, we're updating an existing record
        if (isset($FS->FilerScheduleID)) {
            return $this->update($FS, $text, $changeTypeID, $comment);
        }

        $stmt = $this->DB->prepare('
            INSERT
            INTO FilerSchedule
                (FilerID, GridID, FilerScheduleDataTypeID,
                OptionalDistrictID, CoreData, FilerScheduleComment )
            VALUES ( ?,?,?,?,?,? ) ');
        $stmt->bind_param('iiiiis', $FS->FilerID, $FS->GridID, $FS->FilerScheduleDataTypeID, $FS->OptionalDistrictID, $FS->CoreData, $FS->FilerScheduleComment);
        $retVal = $stmt->execute();
        $FS->FilerScheduleID = $this->DB->insert_id;
        if (empty($text)) {
            $text = "created FilerSchedule $FS->FilerScheduleID containing::$FS->FilerID,$FS->GridID,$FS->OptionalDistrictID,$FS->CoreData,$FS->FilerScheduleDataTypeID";
        }
        $this->log($FS->FilerScheduleID, 1, $text);
        return $retVal;
    }

    /* ======================= update ======================================= */

    public function update(FilerSchedule $FS, $text = null, $changeTypeID = 2, $comment = null)
    {
        if (empty($FS->FilerScheduleID)) {
// We can't update a record unless it exists...
            exit('Cannot update FilerSchedule that does not yet exist in the database.');
        }
        if (empty($changeTypeID) || $changeTypeID < 2) {
            $changeTypeID = 2; // MODIFY
        }
        $stmt = $this->DB->prepare('
            UPDATE FilerSchedule
            SET FilerID = ?, GridID = ?, FilerScheduleDataTypeID = ?,
                OptionalDistrictID = ?, CoreData = ?, FilerScheduleComment = ?
            WHERE FilerScheduleID = ? ');
        $stmt->bindParam('iiiiisi', $FS->FilerID, $FS->GridID, $FS->FilerScheduleDataTypeID, $FS->OptionalDistrictID, $FS->CoreData, $FS->FilerScheduleComment, $FS->FilerScheduleID);
        $retVal = $stmt->execute();
        $this->log($FS->FilerScheduleID, $changeTypeID, $text, $comment);
        return $retVal;
    }

    /* ======================= delete ======================================= */

    public function delete(FilerSchedule $FS, $text = null, $changeTypeID = 4, $comment = null)
    {
        if (empty($FS->FilerScheduleID)) {
// We can't delete a record unless it exists...
            exit('Cannot delete a FilerSchedule that does not yet exist in the database.');
        }

        $stmt = $this->DB->prepare('
            DELETE FilerSchedule
            WHERE FilerScheduleID = ? ');
        if (empty($text)) {
            $text = "deleted FilerSchedule containing::$FS->FilerID,$FS->GridID,$FS->OptionalDistrictID,$FS->CoreData,$FS->FilerScheduleDataTypeID";
        }
        $stmt->bindParam('i', $FS->FilerScheduleID);
        $retVal = $stmt->execute();
        $this->log($FS->FilerScheduleID, $changeTypeID, $text, $comment);
        return $retVal;
    }

    /* ======================= log ========================================== */

    public function log($fsID, $changeTypeID, $text = null, $comment = '')
    {
        global $CHANGEUSERID;

        $data = array(
            'FilerScheduleID' => $fsID,
            'Text' => $text,
            'ResearcherID' => $CHANGEUSERID,
            'ChangeTypeID' => $changeTypeID,
            'Comment' => $comment);

        $FSLog = new FilerScheduleLog($data);
        $FSLog->log();
    }

}
