<?php

namespace App\Models;

use CodeIgniter\Model;

class Mview extends Model
{

    public function __construct()
    {
        $this->db = db_connect();
    }

    public function avgAttendance($percent_meeting, $class_id)
    {
        $sql = "CALL proc_getAvgAtd($percent_meeting, $class_id);";

        return $this->db->query($sql)->getResult();
    }

    public function t5InTime($percent_meeting, $join_time, $class_id, $limit)
    {
        $sql = "CALL proc_getInTimeAtd($percent_meeting, $join_time, $class_id, $limit);";

        return $this->db->query($sql)->getResult();
    }

    public function t5Absent($percent_meeting, $class_id, $limit)
    {
        $sql = "CALL proc_getAbsentAtd($percent_meeting, $class_id, $limit);";

        return $this->db->query($sql)->getResult();
    }

    public function t5Late($percent_meeting, $join_time, $class_id, $limit)
    {
        $sql = "CALL  proc_getLateAtd($percent_meeting, $join_time, $class_id, $limit);";

        return $this->db->query($sql)->getResult();
    }

    public function t5JoinLeave()
    {
        $sql = "CALL  proc_getJoinLeave();";

        return $this->db->query($sql)->getResult();
    }


    public function getDiagramData($percent_meeting, $join_time, $class_id)
    {
        $sql = "CALL proc_getDiagramData($percent_meeting, $join_time, $class_id);";

        return $this->db->query($sql)->getResult();
    }

    public function getMeetings($class_id)
    {
        $sql = "SELECT meeting_id FROM `meeting` where CLASS_ID=$class_id";

        return $this->db->query($sql)->getResult();
    }


    public function getAtdMeeting($percent_meeting, $join_time, $class_id)
    {
        $sql = "call proc_getAtdMeeting($percent_meeting, $join_time, $class_id)";

        return $this->db->query($sql)->getResult();
    }

    public function getParticipantsName($class_id)
    {
        $sql = "SELECT ptc_name, ptc_id FROM `participant` where CLASS_ID=$class_id";

        return $this->db->query($sql)->getResult();
    }

    public function getParticipantName($class_id, $ptc_id)
    {
        $sql = "SELECT ptc_name FROM `participant` where CLASS_ID=$class_id and PTC_ID=$ptc_id";

        return $this->db->query($sql)->getResult();
    }

    public function getDetailAtdMeeting($class_id, $ptc_id)
    {
        $sql = "call proc_getDetailAtd($class_id,$ptc_id)";
        return $this->db->query($sql)->getResult();
    }

    public function getCountDetailJoinLeave($class_id, $ptc_id)
    {
        $sql = "call proc_getCountDetailJoinLeave($class_id,$ptc_id)";
        return $this->db->query($sql)->getResult();
    }

    public function getAvgAtdById($class_id, $ptc_id, $percent_meeting)
    {
        $sql = "call proc_getAvgAtdById($class_id,$ptc_id, $percent_meeting)";
        return $this->db->query($sql)->getResult();
    }
}
