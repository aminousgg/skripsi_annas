<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_controller {


    private $views = "login";
    public function __construct()
    {
        parent::__construct();
        if($this->session->userdata('sesi'))
        {
            redirect(base_url());
        }
        $this->load->model('Generic_model', 'global');
        $this->load->library('Generate', NULL, 'gen');
    }

    public function index()
    {
        $data = [
            'title'     => "Login",
            'sub_title' => "Sistem Bengkel",
            'data'      => []
        ];
        $this->load->view("$this->views/index", $data);
    }


    public function cek()
    {
        $where = [
          'username'=>$this->input->post('username'),
          'password'=>md5($this->input->post('password'))
        ];
        $this->db->where($where);
        $this->db->join('role', 'users.role_id = role.role_id','left');
        $cek = $this->db->get('users');
        if($cek->num_rows()>0)
        {
            $this->session->set_userdata('sesi', $cek->row_array());
            redirect(base_url());
        }
        else
        {
          $this->session->set_flashdata('err_log', 'Username / Password is wrong!');
          redirect(base_url('login'));
        }
    }

}
