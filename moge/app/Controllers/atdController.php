<?php

namespace App\Controllers;

use App\Models\Mclass;

use App\Models\Mparticipant;

use App\Models\Mview;

class atdController extends BaseController
{

    public function index()
    {
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
            'class' => $class->getClass(),
            'total_ptc' => $participant->countParticipants(),
            'avg_atd' => $view->avgAttendance($pm, 'CLS-00001'),
            'InTime_atd' => $view->t5InTime($pm, $lt, 'CLS-00001', 5),
            'absent_atd' => $view->t5Absent($pm, 'CLS-00001', 5),
            'late_atd' => $view->t5Late($pm, $lt, 'CLS-00001', 5),
            'join_leave' => $view->t5JoinLeave(),
            'diagram' => $view->getDiagramData($pm, $lt, 'CLS-00001'),
            'meetings' => $view->getMeetings('CLS-00001'),
            'atdMeetings' => $view->getAtdMeeting($pm, $lt, 'CLS-00001'),
            'participants' => $view->getParticipantsName('CLS-00001'),
            'percentMin' => $pm, 'late' => $lt
        );
        return view('attendance', $data);
    }
}
