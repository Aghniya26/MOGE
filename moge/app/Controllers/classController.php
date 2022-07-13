<?php

namespace App\Controllers;

use App\Libraries\detailClass;
use App\Models\Mclass;


class classController extends BaseController
{
    var $dbClass, $class, $atdController;
    public function __construct()
    {
        $this->dbClass = new Mclass();
        $this->class = new detailClass();
        $this->atdController = new atdController();
        $this->session = \Config\Services::session();
        $this->session->start();
    }
    public function index()
    {
        if ($this->session->get("logged_in") == true) {
            $data = array(
                'class' => $this->dbClass->getClass($this->session->get('user_id'))
            );

            return view('class', $data);
        } else {
            $this->session->setFlashdata('msg', "Please log in!");
            return redirect()->route('/');
        }
    }
    public function currentClass($class_id)
    {
        $this->session->set("class_id", $class_id);
        return redirect()->route('attendance');
    }

    public function add()
    {
        $count = $this->dbClass->countClass($this->session->get('user_id'));
        if ($count[0]->totalClass <= 5) {
            if ($this->request->getPost()) {
                $this->dbClass->createClass(
                    $this->session->get('user_id'),
                    $this->request->getPost('title'),
                    $this->request->getPost('detail'),
                    $this->request->getPost('room'),
                    $this->request->getPost('num_meetings'),
                    $this->request->getPost('color')
                );
            }
        } else {
            $this->session->setFlashdata('msg', "you've reached teh limit of maximum class!");
        }


        return redirect()->route('class');
    }
    public function edit()
    {
        print_r($this->request->getPost());
        if ($this->request->getPost()) {
            $this->dbClass->updateClass(
                $this->request->getPost('class_id'),
                $this->request->getPost('title'),
                $this->request->getPost('detail'),
                $this->request->getPost('room'),
                $this->request->getPost('num_meetings'),
                $this->request->getPost('color')
            );
        }
        return redirect()->route('class');
    }
    public function delete()
    {
        print_r($this->request->getPost());
        if ($this->request->getPost()) {
            $this->dbClass->deleteClass(
                $this->request->getPost('class_id')
            );
        }
        return redirect()->route('class');
    }
}
