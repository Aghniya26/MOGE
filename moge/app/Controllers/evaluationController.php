<?php

namespace App\Controllers;

use App\Libraries\detailClass;
use App\Models\Mattendance;
use App\Models\Mparticipant;

class evaluationController extends BaseController
{
    var $dbAtd, $class;
    public function __construct()
    {

        $this->class = new detailClass();
        $this->dbAtd = new Mattendance();
        $this->session = \Config\Services::session();
        $this->session->start();
    }
    public function index()
    {
        if ($this->session->get("logged_in") == true) {
            if (!$this->request->getPost()) {
                $pm = 0.8;
                $total_pm = 0.8;
            } else {
                $pm = $this->request->getPost('pm') / 100;
                $total_pm = $this->request->getPost('total_pm');
            }
            $participant = new Mparticipant();
            $data = array(
                'participant' => $this->dbAtd->getEvaluation($pm, $this->session->get("class_id")),
                'total_pm' => $total_pm,
                'pm' => $pm
            );
            return view('evaluation', $data);
        }
    }

    public function import()
    {
        return view('importParticipants');
    }
}
