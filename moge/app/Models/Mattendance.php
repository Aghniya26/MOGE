<?php

namespace App\Models;

use CodeIgniter\Model;

class Mattendance extends Model
{

    public function __construct()
    {
        $this->db = db_connect();
    }

    public function createAttendancce($meeting_id, $ptc_id, $join_time, $leave_time, $date, $duration)
    {
        $sql = "INSERT INTO `attendance` (`MEETING_ID`, `PTC_ID`, `JOIN_TIME`, `LEAVE_TIME`, `DATE`, `DURATION`) VALUES 
        ($meeting_id, $ptc_id, '$join_time', '$leave_time', '$date', '$duration')";

        return $this->db->query($sql);
    }
    public function getEvaluation($pm, $ci)
    {
        $sql = "call proc_getEvaluation($pm, $ci)";
        return $this->db->query($sql)->getResult();
    }
}
