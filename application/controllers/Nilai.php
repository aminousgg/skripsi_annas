<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Nilai extends CI_controller {


    private $views = "nilai";
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

    public function gol_1()
    {
        $data = [
            'title'     => "Dashboard",
            'sub_title' => "Nilai Depresiasi Golongan I",
            'data'      => "",
        ];
        $this->load->view("$this->views/gol_1", $data);
    }

    public function gol_up()
    {
        $data = [
            'title'     => "Dashboard",
            'sub_title' => "Nilai Depresiasi Golongan II - V",
            'data'      => "",
        ];
        $this->load->view("$this->views/gol_up", $data);
    }

    public function other()
    {

    }

}
