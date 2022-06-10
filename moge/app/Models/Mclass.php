<?php

namespace App\Models;

use CodeIgniter\Model;

class Mclass extends Model
{

    public function __construct()
    {
        $this->db = db_connect();
    }

    public function getClass()
    {
        $sql = "SELECT * FROM class";

        return $this->db->query($sql)->getResult();
    }
}
