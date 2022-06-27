<?php

namespace App\Controllers;

use App\Libraries\detailClass;
use App\Models\Mview;

class detailAtdController extends BaseController
{
    var $class;
    public function __construct()
    {
        $this->class = new detailClass();
        $this->session = \Config\Services::session();
        $this->session->start();
    }

    public function index($id, $pm)
    {

        $view = new Mview();
        $data = array(
            'atdDetail' => $view->getDetailAtdMeeting($this->session->get("class_id"), $id),
            'atdCount' => $view->getCountDetailJoinLeave($this->session->get("class_id"), $id),
            'meetings' => $view->getMeetings($this->session->get("class_id")),
            'participant' => $view->getParticipantName($this->session->get("class_id"), $id),
            'avg_atd' => $view->getAvgAtdById($this->session->get("class_id"), $id, $pm)

        );
        return view('detailAttendance', $data);
    }
}
