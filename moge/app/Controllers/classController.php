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
        $data = array(
            'class' => $this->dbClass->getClass()
        );



        // $this->session->set("username", 3); // setting session data


        // echo $this->session->get("class_id");
        return view('class', $data);
    }
    public function currentClass($class_id)
    {
        $this->session->set("class_id", $class_id);
        return redirect()->route('attendance');
    }

    public function add()
    {

        if ($this->request->getPost()) {
            $this->dbClass->createClass(
                2,
                $this->request->getPost('title'),
                $this->request->getPost('detail'),
                $this->request->getPost('room'),
                $this->request->getPost('num_meetings'),
                $this->request->getPost('color')
            );
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
