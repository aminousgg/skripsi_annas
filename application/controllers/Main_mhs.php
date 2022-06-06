<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main_mhs extends CI_controller {
    

    private $views = "";
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Generic_model', 'global');
    }

    public function index()
    {
        $data = [
            'title'     => "Validasi Proposal",
            'sub_title' => "Data Pembimbingan Usulan Proposal PKM"
        ];
        $this->load->view("", $data);
    }

    
    public function other()
    {
        
    }

}