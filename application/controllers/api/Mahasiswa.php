<?php

use Restserver\Libraries\REST_Controller;

defined('BASEPATH') or exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
/** @noinspection PhpIncludeInspection */
//To Solve File REST_Controller not found
require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Mahasiswa extends REST_Controller
{

    function __construct($config = 'rest')
    {
        parent::__construct($config);
        $this->load->model('Mahasiswamodel', 'model');
    }

    public function index_get()
    {
        $data = $this->model->getMahasiswa();
        // $data2 = $this->model->getMahasiswa();
        // var_dump(json_encode($data));
        $this->set_response([
            'status' => TRUE,
            'code' => 200,
            'message' => 'Success',
            'data' => $data,
            // 'datakhusus' => $data2,
        ], REST_Controller::HTTP_OK);
    }

    public function sendmail_post()
    {
        $to_email = $this->post('email');
        $this->load->library('email');
        $this->email->from('wantonius@dtales.my.id', 'Admin dtales.my.id');
        $this->email->to($to_email);
        $this->email->subject('Important Message');
        $this->email->message("
            <center>
                <h1 style='color: #FF5555; font-weight: bold;'>WELCOME TO OUR SERVER</h1>
                <p>Kami Siap Melayani Anda!</p>
            </center>
        </body>
        ");

        if ($this->email->send()) {
            $this->set_response([
                'status' => TRUE,
                'code' => 200,
                'message' => 'Success to send email notification to Your account!, please check your email inbox'
            ], REST_Controller::HTTP_OK);
        } else {
            $this->set_response([
                'status' => FALSE,
                'code' => 404,
                'message' => 'Failed to send email notification!'
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }
}