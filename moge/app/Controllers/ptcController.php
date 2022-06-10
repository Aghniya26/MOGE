<?php

namespace App\Controllers;

use App\Models\Mparticipant;

class ptcController extends BaseController
{
    public function index()
    {
        $participant = new Mparticipant();
        $data = array(
            'participants' => $participant->getAllParticipants()
        );
        return view('participant', $data);
    }
}
