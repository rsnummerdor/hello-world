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
 * FilerSchedule represents the FilerSchedule information that links sets of
 * reports, Filer identities, Candidates, and Races together to a given year and
 * location.
 *
 * A Filer/Candidate may have a FilerSchedule for each Year/Location/DataType
 * set that they are required to file.
 *
 * @author Roger Nummerdor <rogern@followthemoney.org>
 */
/* =========================== CLASS FilerSchedule ========================== */
class FilerSchedule
{

    public $FilerScheduleID;
    public $FilerID;
    public $GridID;
    public $FilerScheduleDataTypeID;
    public $OptionalDistrictID;
    public $CoreData;
    public $FilerScheduleComment;
    public $FilerScheduleTimestamp;
// These Variables are only for informational purposes. To change them change the Grid ID
    private $Year;
    private $Jurisdiction;


    /**
     * @param array $data
     */
    public function __construct($data)
    {
        $this->loadArray($data);
    }

    public function loadArray()
    {
        $this->FilerID = isset($data['FilerID']) ? $data['FilerID'] : null;
        $this->GridID = isset($data['GridID']) ? $data['GridID'] : null;
        $this->CoreData = isset($data['CoreData']) ? $data['CoreData'] : null;
        $this->FilerScheduleID = isset($data['FilerScheduleID']) ? $data['FilerScheduleID'] : null;
        $this->FilerScheduleDataTypeID = isset($data['FilerScheduleDataTypeID']) ? $data['FilerScheduleDataTypeID'] : null;
        $this->OptionalDistrictID = isset($data['OptionalDistrictID']) ? $data['OptionalDistrictID'] : null;
        $this->FilerScheduleComment = isset($data['FilerScheduleComment']) ? $data['FilerScheduleComment'] : null;
        $this->FilerScheduleTimestamp = isset($data['FilerScheduleTimestamp']) ? $data['FilerScheduleTimestamp'] : null;

        $this->Year = isset($data['Year']) ? $data['Year'] : null;
        $this->Jurisdiction = isset($data['Jurisdiction']) ? $data['Jurisdiction'] : null;
    }

    public function test()
    {
        echo 'Test';
    }

    public function getId()
    {
        return $this->FilerScheduleID;
    }

    public function getYear()
    {
        return $this->Year;
    }

    public function getJurisdiction()
    {
        return $this->Jurisdiction;
    }

    public function save($comment = null)
    {
        $Interface = new FilerScheduleInterface;
        return $Interface->save($this, $comment);
    }

    public function delete($comment = null)
    {
        $Interface = new FilerScheduleInterface;
        return $Interface->delete($this, $comment);
    }

    public function load($FilerScheduleID = null)
    {
        if (empty($FilerScheduleID)) {
            $FilerScheduleID = isset($this->FilerScheduleID) ? $FilerScheduleID : null;
        }
        $Interface = new FilerScheduleInterface;
        $this->loadArray($Interface->load($FilerScheduleID));
    }

    public function changeFilerID($filerID, $comment = null)
    {
        $Interface = new FilerScheduleInterface;
        $text = "modify FilerID from $this->FilerID to $filerID";
        $this->FilerID = $filerID;
        return $Interface->save($this, $text, 2, $comment);
    }

    public function changeCoreData($core, $comment = null)
    {
        $Interface = new FilerScheduleInterface;
        $text = "modify CoreData from $this->CoreData to $core";
        $this->CoreData = $core;
        return $Interface->save($this, $text, 2, $comment);
    }

    public function changeComment($filerScheduleComment, $comment = null)
    {
        $Interface = new FilerScheduleInterface;
        $text = "change FilerScheduleComment";
        $this->FilerScheduleComment = $filerScheduleComment;
        return $Interface->save($this, $text, 2, $comment);
    }

}
