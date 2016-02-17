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
 * Description of FilerScheduleLog
 *
 * @author Roger Nummerdor <rogern@followthemoney.org>
 */
class FilerScheduleLog
{

    public $FilerScheduleLogID;
    public $ResearcherID;
    public $ChangeTypeID;
    public $FilerScheduleID;
    public $Text;
    public $Comment;
    public $FilerScheduleLogTimestamp;

    public function __construct($data)
    {
        $this->FilerScheduleLogID = isset($data['FilerScheduleLogID']) ? $data['FilerScheduleLogID'] : null;
        $this->ResearcherID = isset($data['ResearcherID']) ? $data['ResearcherID'] : null;
        $this->ChangeTypeID = isset($data['ChangeTypeID']) ? $data['ChangeTypeID'] : null;
        $this->FilerScheduleID = isset($data['FilerScheduleID']) ? $data['FilerScheduleID'] : null;
        $this->Text = isset($data['Text']) ? $data['Text'] : null;
        $this->Comment = isset($data['Comment']) ? $data['Comment'] : null;
        $this->FilerScheduleLogTimestamp = isset($data['FilerScheduleLogTimestamp']) ? $data['FilerScheduleLogTimestamp'] : null;
    }

    public function log()
    {
        $Interface = new FilerScheduleLogInterface();
        return $Interface->save($this);
    }

    public function updateComment($comment)
    {
        $this->Comment = $comment;
        $Interface = new FilerScheduleLogInterface();
        return $Interface->updateComment($this);
    }

    public function appendComment($comment)
    {
        $this->Comment .= $comment;
        $Interface = new FilerScheduleLogInterface();
        return $Interface->updateComment($this);
    }

}
