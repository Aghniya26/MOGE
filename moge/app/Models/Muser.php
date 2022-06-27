<?php

namespace App\Models;

use CodeIgniter\Model;

class Muser extends Model
{

    public function __construct()
    {
        $this->db = db_connect();
    }
    public function update_access_token($token, $user_id)
    {
        $sql = "UPDATE users SET ACCESS_TOKEN='$token' WHERE user_id=$user_id";
        return $this->db->query($sql);
    }

    public function get_access_token($user_id)
    {
        $sql = "SELECT access_token FROM users WHERE user_id = $user_id";
        return $this->db->query($sql)->getResult();
    }
}
