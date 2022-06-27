<?php

namespace App\Controllers;

use PHPExcel;
use PHPExcel_IOFactory;
use App\Libraries\detailClass;
use App\Models\Mparticipant;

class ptcController extends BaseController
{
    var $dbPtc, $class;
    public function __construct()
    {
        $this->dbPtc = new Mparticipant();
        $this->class = new detailClass();
        $this->session = \Config\Services::session();
        $this->session->start();
    }
    public function index()
    {

        $data = array(
            'participants' => $this->dbPtc->getAllParticipants($this->session->get("class_id"))
        );
        return view('participant', $data);
    }

    public function import()
    {
        $file_excel = $this->request->getFile('fileexcel');
        if ($file_excel) {
            $ext = $file_excel->getClientExtension();
            if ($ext == 'xls') {
                $render = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
            } else {
                $render = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
            }
            $spreadsheet = $render->load($file_excel);

            $data = $spreadsheet->getActiveSheet()->toArray();
            foreach ($data as $x => $row) {
                if ($x == 0) {
                    continue;
                }


                $name = $row[0];
                $email = $row[1];
                $zoom_id = $row[2];
                $this->dbPtc->createPtc($this->session->get("class_id"), $name, $email, $zoom_id);
            }
        }
        return redirect()->route('participant');
    }
    public function edit()
    {
        if ($this->request->getPost()) {
            $this->dbPtc->updatePtc($this->request->getPost('ptc_id'), $this->request->getPost('name'), $this->request->getPost('email'));
        }
        return redirect()->route('participant');
    }
    public function delete()
    {
        if ($this->request->getPost()) {
            $this->dbPtc->deletePtc($this->request->getPost('ptc_id'));
        }
        return redirect()->route('participant');
    }
}
