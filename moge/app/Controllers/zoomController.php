<?php

namespace App\Controllers;

use App\Libraries\zoomAuth;
use App\Models\Mattendance;
use App\Models\Mmeeting;
use App\Models\Mparticipant;
use App\Models\Muser;
use DateTime;
use phpDocumentor\Reflection\Types\This;

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
        $data = array(
            "client_id" => $this->zoomAuth->CLIENT_ID,
            "redirect_uri" => $this->zoomAuth->REDIRECT_URI
        );

        return view('zoomTest', $data);
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
        // print($token['access_token']);
        $this->db->update_access_token($token['access_token'], $this->session->get('user_id'));
        $this->db->update_refresh_token($token['refresh_token'], $this->session->get('user_id'));
        return redirect()->to(base_url('class'));
    }

    public function addParticipants($current_id, $uuid)
    {


        $client = new \GuzzleHttp\Client(['base_uri' => 'https://api.zoom.us']);


        $accessToken = $this->db->get_access_token($this->session->get('user_id'))[0]->access_token;

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

                if ($ptc_id != null) {
                    $this->dbAttendance->createAttendancce(
                        $current_id,
                        $ptc_id[0]->ptc_id,
                        $join_time->format('Y-m-d H:i:s '),
                        $leave_time->format('Y-m-d H:i:s '),
                        $join_time->format('Y-m-d '),
                        $join_time->diff($leave_time)->format('%i')
                    );
                }
            }
        }

        return redirect()->to(base_url('attendance'));
    }

    public function addMeeting()
    {

        if ($this->request->getPost()) {
            try {
                $uuid = $this->request->getPost('uuid');
                $meeting_order = $this->request->getPost('meeting_order');


                $client = new \GuzzleHttp\Client(['base_uri' => 'https://api.zoom.us']);

                $accessToken = $this->db->get_access_token($this->session->get('user_id'))[0]->access_token;


                $response = $client->request('GET', '/v2/report/meetings/' . $uuid . '/', [
                    "headers" => [
                        "Authorization" => "Bearer $accessToken"
                    ]
                ]);

                $data = json_decode($response->getBody());
                $start_time = new DateTime($data->start_time);
                $end_time = new DateTime($data->end_time);
                $current_id = $this->dbMeeting->nextInsertMeetingId()[0]->AUTO_INCREMENT;
                $this->dbMeeting->createMeeting(
                    $this->session->get("class_id"),
                    $start_time->format('Y-m-d'),
                    $start_time->format('Y-m-d H:i:s '),
                    $end_time->format('Y-m-d H:i:s '),
                    (strtotime($data->end_time) - strtotime($data->start_time)) / 60,
                    $meeting_order,
                    $data->id
                );


                $this->addParticipants($current_id, $uuid);
            } catch (\Exception $e) {
                if ($e->getCode() == 404) {

                    $this->session->setFlashdata('warning', "Meeting ID not found or has expired, please check that meeting id you entered is correct!");
                } elseif ($e->getCode() == 401) {

                    $refresh_token = $this->db->get_refresh_token($this->session->get('user_id'))[0]->access_token;

                    $client = new \GuzzleHttp\Client(['base_uri' => 'https://zoom.us']);

                    $response = $client->request('POST', '/oauth/token', [
                        "headers" => [
                            "Authorization" => "Basic " . base64_encode($this->zoomAuth->CLIENT_ID . ':' . $this->zoomAuth->CLIENT_SECRET)
                        ],
                        'form_params' => [
                            "grant_type" => "refresh_token",
                            "refresh_token" => $refresh_token
                        ],
                    ]);

                    $token = json_decode($response->getBody()->getContents(), true);

                    $this->db->update_access_token($token['access_token'], $this->session->get('user_id'));
                    $this->db->update_refresh_token($token['refresh_token'], $this->session->get('user_id'));
                    $this->session->setFlashdata('warning', "acces_token is expired, please try again");
                } elseif ($e->getCode() == 400) {
                    $e->getMessage();
                }
                return redirect()->to(base_url('attendance'));
            }
        }
    }
}
