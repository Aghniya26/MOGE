<?php

namespace App\Controllers;

use App\Libraries\zoomAuth;
use App\Models\Mattendance;
use App\Models\Mmeeting;
use App\Models\Mparticipant;
use App\Models\Muser;
use DateTime;

class zoomController extends BaseController
{

    var $zoomAuth, $db, $dbMeeting, $dbParticipant, $dbAttendance;
    public function __construct()
    {
        $this->zoomAuth = new zoomAuth();
        $this->db = new Muser();
        $this->dbMeeting = new Mmeeting();
        $this->dbParticipant = new Mparticipant();
        $this->dbAttendance = new Mattendance();
        $this->session = \Config\Services::session();
        $this->session->start();
    }
    public function index()
    {

        return view('zoomTest');
    }
    public function callback()
    {


        $client = new \GuzzleHttp\Client(['base_uri' => 'https://zoom.us']);

        $response = $client->request('POST', '/oauth/token', [
            "headers" => [
                "Authorization" => "Basic " . base64_encode($this->zoomAuth->CLIENT_ID . ':' . $this->zoomAuth->CLIENT_SECRET)
            ],
            'form_params' => [
                "grant_type" => "authorization_code",
                "code" => $_GET['code'],
                "redirect_uri" => $this->zoomAuth->REDIRECT_URI
            ],
        ]);

        $token = json_decode($response->getBody()->getContents(), true);
        $this->db->update_access_token($token['access_token'], 2);
    }

    public function addParticipants($uuid)
    {


        $client = new \GuzzleHttp\Client(['base_uri' => 'https://api.zoom.us']);




        $accessToken = $this->db->get_access_token(2)[0]->access_token;

        $response = $client->request('GET', '/v2/report/meetings/' . $uuid . '/participants', [
            "headers" => [
                "Authorization" => "Bearer $accessToken"
            ]
        ]);

        $data = json_decode($response->getBody());



        if (!empty($data)) {
            foreach ($data->participants as $p) {

                $join_time = new DateTime($p->join_time);
                $leave_time = new DateTime($p->leave_time);

                $ptc_id = $this->dbParticipant->getPtcId($p->id);
                $meeting_id = $this->dbMeeting->getCurrentID($uuid);
                if ($ptc_id != null) {
                    $this->dbAttendance->createAttendancce(
                        $meeting_id[0]->meeting_id,
                        $ptc_id[0]->ptc_id,
                        $join_time->format('Y-m-d H:i:s '),
                        $leave_time->format('Y-m-d H:i:s '),
                        $join_time->format('Y-m-d '),
                        $join_time->diff($leave_time)->format('%i')
                    );
                }
            }
        }

        return redirect()->to('attendance');
    }

    public function addMeeting()
    {

        if ($this->request->getPost()) {
            $uuid = $this->request->getPost('uuid');
            $meeting_order = $this->request->getPost('meeting_order');


            $client = new \GuzzleHttp\Client(['base_uri' => 'https://api.zoom.us']);

            $accessToken = $this->db->get_access_token(2)[0]->access_token;

            $response = $client->request('GET', '/v2/report/meetings/' . $uuid . '/', [
                "headers" => [
                    "Authorization" => "Bearer $accessToken"
                ]
            ]);

            $data = json_decode($response->getBody());
            $start_time = new DateTime($data->start_time);
            $end_time = new DateTime($data->end_time);
            $this->dbMeeting->createMeeting(
                $this->session->get("class_id"),
                $start_time->format('Y-m-d'),
                $start_time->format('Y-m-d H:i:s '),
                $end_time->format('Y-m-d H:i:s '),
                (strtotime($data->end_time) - strtotime($data->start_time)) / 60,
                $meeting_order,
                $data->id
            );
            $this->addParticipants($uuid);
        }
    }
}
