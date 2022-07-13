<?php

namespace App\Controllers;

use App\Libraries\detailClass;
use App\Models\Mclass;

use App\Models\Mparticipant;

use App\Models\Mview;

class atdController extends BaseController
{
    var $class;
    public function __construct()
    {
        $this->class = new detailClass();
        $this->session = \Config\Services::session();
        $this->session->start();
    }

    public function index()
    {
        if ($this->session->get("logged_in") == true) {
            $class = new Mclass();
            $participant = new Mparticipant();
            $view = new Mview();
            if (!$this->request->getPost()) {
                $pm = 0.8;
                $lt = 15;
            } else {
                $pm = $this->request->getPost('pm') / 100;
                $lt = $this->request->getPost('lt');
            }

            $data = array(
                'class' => $class->getClass($this->session->get("user_id")),
                'total_ptc' => $participant->countParticipants($this->session->get("class_id")),
                'avg_atd' => $view->avgAttendance($pm,  $this->session->get("class_id")),
                'InTime_atd' => $view->t5InTime($pm, $lt,  $this->session->get("class_id"), 5),
                'absent_atd' => $view->t5Absent($pm,  $this->session->get("class_id"), 5),
                'late_atd' => $view->t5Late($pm, $lt,  $this->session->get("class_id"), 5),
                'join_leave' => $view->t5JoinLeave(),
                'diagram' => $view->getDiagramData($pm, $lt,  $this->session->get("class_id")),
                'meetings' => $view->getMeetings($this->session->get("class_id")),
                'atdMeetings' => $view->getAtdMeeting($pm, $lt,  $this->session->get("class_id")),
                'participants' => $view->getParticipantsName($this->session->get("class_id")),
                'percentMin' => $pm, 'late' => $lt
            );


            return view('attendance', $data);
        }
    }
}
