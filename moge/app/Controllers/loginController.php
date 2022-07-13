<?php

namespace App\Controllers;

use App\Libraries\detailClass;
use App\Models\Muser;
use PhpParser\Node\Stmt\Echo_;

class loginController extends BaseController
{
    var $class, $dbUser;
    public function __construct()
    {
        $this->dbUser = new Muser();
        $this->session = \Config\Services::session();
        $this->session->start();
    }

    public function displayLogin()
    {
        return view('login');
    }
    public function auth()
    {
        // print_r($this->request->getPost());
        if ($this->request->getPost()) {
            $user = $this->dbUser->getUserbyEmail($this->request->getPost('user_email'));
            if ($user) {

                if ($user[0]->PASSWORD == $this->request->getPost('user_password')) {
                    $newdata = [
                        'user_id'  => $user[0]->USER_ID,
                        'logged_in' => true,
                    ];
                    $this->session->Set($newdata);
                    return redirect()->route('class');
                } else {
                    $this->session->setFlashdata('msg', "Incorrect email or password!");
                    return redirect()->route('/');
                }
            } else {
                $this->session->setFlashdata('msg', "Incorrect email or password!");
                return redirect()->route('/');
            }
        }
    }
}
