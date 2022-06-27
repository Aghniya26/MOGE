<?php

namespace App\Models;

use CodeIgniter\Model;

class Mmeeting extends Model
{
    public function createMeeting($class_id, $date, $start_time, $end_time, $duration, $meeting_order, $uuid)
    {

        $sql = "INSERT INTO `meeting` (`CLASS_ID`, `DATE`, `START_TIME`, `END_TIME`, `DURATION`, `MEETING_ORDER`, `UUID`) VALUES
        ($class_id, '$date', '$start_time', '$end_time', '$duration', '$meeting_order', '$uuid')";
        return $this->db->query($sql);
    }

    public function getCurrentID($uuid)
    {
        $sql = "SELECT meeting_id FROM meeting WHERE uuid='$uuid'";
        return $this->db->query($sql)->getResult();
    }
}
