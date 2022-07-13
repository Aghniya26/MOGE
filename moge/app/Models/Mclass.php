<?php

namespace App\Models;

use CodeIgniter\Commands\Utilities\Publish;
use CodeIgniter\Model;

class Mclass extends Model
{

    public function __construct()
    {
        $this->db = db_connect();
    }

    public function getClass($user_id)
    {
        $sql = "SELECT * FROM class WHERE `USER_ID`='$user_id'";

        return $this->db->query($sql)->getResult();
    }
    public function countClass($user_id)
    {
        $sql = "SELECT count(user_id) as totalClass FROM class WHERE `USER_ID`='$user_id'";

        return $this->db->query($sql)->getResult();
    }


    public function createClass($user_id, $title_class, $detail_class, $room, $num_meetings, $color)
    {
        $sql = "INSERT INTO `class` ( `USER_ID`, `TITLE_CLASS`, `DETAIL_CLASS`, `ROOM`, `NUM_MEETINGS`, `COLOR`) VALUES
        ($user_id, '$title_class', '$detail_class', '$room', '$num_meetings', '$color')";
        return $this->db->query($sql);
    }
    public function updateClass($class_id, $title_class, $detail_class, $room, $num_meetings, $color)
    {
        $sql = "UPDATE `class` SET `TITLE_CLASS`='$title_class', `DETAIL_CLASS`='$detail_class', `ROOM`= '$room', `NUM_MEETINGS`='$num_meetings', `COLOR`='$color' WHERE class_id=$class_id";
        return $this->db->query($sql);
    }
    public function deleteClass($class_id)
    {
        $sql = "DELETE FROM class WHERE class_id=$class_id";
        return $this->db->query($sql);
    }
}
