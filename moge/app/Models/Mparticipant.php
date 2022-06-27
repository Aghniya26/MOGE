<?php

namespace App\Models;

use CodeIgniter\Model;

class Mparticipant extends Model
{

    public function __construct()
    {
        $this->db = db_connect();
    }

    public function countParticipants($class_id)
    {
        $sql = "SELECT COUNT(PTC_ID) AS PARTICIPANTS FROM participant where class_id=$class_id";

        return $this->db->query($sql)->getResult();
    }

    public function getAllParticipants($class_id)
    {
        $sql = "SELECT ptc_name, ptc_email, ptc_id FROM participant where class_id=$class_id";

        return $this->db->query($sql)->getResult();
    }

    public function getPtcId($zoom_id)
    {
        $sql = "SELECT ptc_id from participant WHERE zoom_id='$zoom_id'";
        return $this->db->query($sql)->getResult();
    }

    public function updatePtc($ptc_id, $ptc_name, $ptc_email)
    {

        $sql = "UPDATE participant SET ptc_name='$ptc_name', ptc_email='$ptc_email' where ptc_id=$ptc_id";
        return $this->db->query($sql);
    }
    public function deletePtc($ptc_id)
    {
        $sql = "DELETE FROM participant WHERE ptc_id=$ptc_id";
        return $this->db->query($sql);
    }

    public function createPtc($class_id, $ptc_name, $ptc_email, $zoom_id)
    {

        $sql = "INSERT INTO participant (`CLASS_ID`, `PTC_NAME`, `PTC_EMAIL`,`ZOOM_ID` ) VALUES ($class_id, '$ptc_name', '$ptc_email', '$zoom_id')";
        return $this->db->query($sql);
    }
}
