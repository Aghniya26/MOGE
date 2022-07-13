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
    public function update_refresh_token($refresh_token, $user_id)
    {
        $sql = "UPDATE users SET REFRESH_TOKEN='$refresh_token' WHERE user_id=$user_id";
        return $this->db->query($sql);
    }

    public function get_access_token($user_id)
    {
        $sql = "SELECT access_token FROM users WHERE user_id = $user_id";
        return $this->db->query($sql)->getResult();
    }
    public function get_refresh_token($user_id)
    {
        $sql = "SELECT refresh_token FROM users WHERE user_id = $user_id";
        return $this->db->query($sql)->getResult();
    }
    public function getUserById($user_id)
    {
        $sql = "SELECT * FROM users WHERE user_id = $user_id";
        return $this->db->query($sql)->getResult();
    }
    public function updateNameById($user_id, $first_name, $last_name)
    {
        $sql = "UPDATE users SET first_name='$first_name', last_name='$last_name' WHERE user_id = $user_id";
        return $this->db->query($sql);
    }
    public function updateEmailById($user_id, $email)
    {
        $sql = "UPDATE users SET email='$email' WHERE user_id = $user_id";
        return $this->db->query($sql);
    }
    public function updatePasswordById($user_id, $password)
    {
        $sql = "UPDATE users SET `password`='$password' WHERE user_id = $user_id";
        return $this->db->query($sql);
    }
    public function deleteUserById($user_id)
    {
        $sql = "DELETE FROM users WHERE user_id = $user_id";
        return $this->db->query($sql);
    }
    public function getUserbyEmail($email)
    {
        $sql = "SELECT * FROM users WHERE email='$email'";
        return $this->db->query($sql)->getResult();
    }
    public function createuser($email, $password, $first_name, $last_name)
    {
        $sql = "INSERT INTO `users` ( `EMAIL`, `PASSWORD`, `FIRST_NAME`, `LAST_NAME`) VALUES
        ( '$email', '$password', '$first_name', '$last_name')";
        return $this->db->query($sql);
    }
}
