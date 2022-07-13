<?php

namespace App\Controllers;

use App\Libraries\detailClass;
use App\Models\Muser;
use PhpParser\Node\Stmt\Echo_;

class userController extends BaseController
{
    var $class, $dbUser;
    public function __construct()
    {
        $this->class = new detailClass();
        $this->dbUser = new Muser();
        $this->session = \Config\Services::session();
        $this->session->start();
    }

    public function displaySettings()
    {
        if ($this->session->get("logged_in") == true) {
            $data = array(
                'user' => $this->dbUser->getUserById($this->session->get('user_id'))
            );
            return view('setting', $data);
        } else {
            $this->session->setFlashdata('msg', "Please log in!");
            return redirect()->route('/');
        }
    }
    public function displayRegister()
    {

        return view('register');
    }
    public function edit()
    {
        // print_r($this->request->getPost());
        if ($this->request->getPost('user_id')) {
            if ($this->request->getPost('f_name') && $this->request->getPost('l_name')) {
                $this->dbUser->updateNameById(
                    $this->request->getPost('user_id'),
                    $this->request->getPost('f_name'),
                    $this->request->getPost('l_name')
                );
            } elseif ($this->request->getPost('email')) {
                $this->dbUser->updateEmailById(
                    $this->request->getPost('user_id'),
                    $this->request->getPost('email')
                );
            } elseif ($this->request->getPost('cur_password')) {
                $user = $this->dbUser->getUserById($this->request->getPost('user_id'));
                if ($this->request->getPost('cur_password') == $user[0]->PASSWORD) {
                    $this->dbUser->updatePasswordById(
                        $this->request->getPost('user_id'),
                        $this->request->getPost('new_password')
                    );
                }
            }
        }
        return redirect()->route('settings');
    }
    public function delete()
    {
        if ($this->request->getPost('user_id')) {
            $this->dbUser->deleteUserById($this->request->getPost('user_id'));
            echo 'success';
            echo $this->request->getPost('user_id');
        }
    }
    public function add()
    {
        if ($this->request->getPost()) {
            if (!$this->dbUser->getUserbyEmail($this->request->getPost('email'))) {
                $this->dbUser->createuser(
                    $this->request->getPost('email'),
                    $this->request->getPost('new_password'),
                    $this->request->getPost('f_name'),
                    $this->request->getPost('l_name')
                );
                $user = $this->dbUser->getUserbyEmail($this->request->getPost('email'));
                $newdata = [
                    'user_id'  => $user[0]->USER_ID,
                    'logged_in' => true,
                ];
                $this->session->Set($newdata);
                return redirect()->route('loginzoom');
            } else {
                $this->session->setFlashdata('msg', "Email is already used!");
                return redirect()->route('register');
            }
        }
    }

    public function logout()
    {
        session_destroy();
        return redirect()->route('/');
    }
}
