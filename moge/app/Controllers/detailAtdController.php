<?php

namespace App\Controllers;

use App\Models\Mview;

class detailAtdController extends BaseController
{

    public function index($id, $pm)
    {

        $view = new Mview();
        $data = array(
            'atdDetail' => $view->getDetailAtdMeeting('CLS-00001', $id),
            'atdCount' => $view->getCountDetailJoinLeave('CLS-00001', $id),
            'meetings' => $view->getMeetings('CLS-00001'),
            'participant' => $view->getParticipantName('CLS-00001', $id),
            'avg_atd' => $view->getAvgAtdById('CLS-00001', $id, $pm)

        );
        return view('detailAttendance', $data);
    }
}
