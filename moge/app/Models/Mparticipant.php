<?php

namespace App\Models;

use CodeIgniter\Model;

class Mparticipant extends Model
{

    public function __construct()
    {
        $this->db = db_connect();
    }

    public function countParticipants()
    {
        $sql = "SELECT COUNT(PTC_ID) AS PARTICIPANTS FROM participant";

        return $this->db->query($sql)->getResult();
    }

    public function getAllParticipants()
    {
        $sql = "SELECT ptc_name, ptc_email FROM participant";

        return $this->db->query($sql)->getResult();
    }
}
