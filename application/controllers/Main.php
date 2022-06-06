<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_controller {


    private $views = "dashboard";
    public function __construct()
    {
        parent::__construct();
        if(!$this->session->userdata('sesi'))
        {
            redirect(base_url('login'));
        }
        $this->load->model('Generic_model', 'global');
        $this->load->library('Generate', NULL, 'gen');
    }

    public function index()
    {
        $data = [
            'title'     => "Dashboard",
            'sub_title' => "Sistem Informasi Asset Barang",
            'data'      => "",
        ];
        $this->load->view("$this->views/index", $data);
    }

    public function logout()
    {
        $this->session->unset_userdata('sesi');
        redirect(base_url());
    }

    public function other()
    {

    }

}
