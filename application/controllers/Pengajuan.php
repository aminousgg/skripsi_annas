<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pengajuan extends CI_controller {


    private $views = "pengajuan";
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
            'title'     => "Pengajuan",
            'sub_title' => "Pengajuan Asset Barang",
            'data'      => "",
        ];
        $this->load->view("$this->views/index", $data);
    }

    public function input()
    {
        $data = [
            'title'     => "Pengajuan",
            'sub_title' => "Input Asset Barang",
            'data'      => "",
        ];
        $this->load->view("$this->views/input", $data);
    }

    public function create()
    {
        if(!$this->input->post())
        {
            echo "Error Input";
        }
        else
        {
            $angka = rand(1000,9999);
            $kode = "BRG-NEW-".$angka;
            $barang = [
                'kode_barang'           => $kode,
                'nama_barang'           => $this->input->post('nama_barang'),
                'jumlah'                => $this->input->post('jumlah'),
                'satuan'                => $this->input->post('satuan'),
                'harga'                 => $this->input->post('harga_barang')
            ];
            $pengajuan = [
                'tanggal'       => date('Y-m-d'),
                'kode_barang'   => $kode,
                'pegawai_id'    => $this->input->post('pegawai_id'),
                'keterangan'    => $this->input->post('keterangan')
            ];
            $this->db->insert('barang', $barang);
            $this->db->insert('pengajuan', $pengajuan);
            redirect(base_url('pengajuan'));
        }
    }

    public function terima()
    {
        // print_r($this->input->post()); die;
        $kode_lama = $this->db->get_where('barang', ['barang_id'=>$this->input->post('id')])->row_array()['kode_barang'];
        $this->db->where('barang_id', $this->input->post('id'));
        $data = [
            'kode_barang'       => $this->input->post('kode_barang'),
            'tanggal_masuk'     => date('Y-m-d'),
            'golongan_id'       => $this->input->post('golongan_id'),
            'status'      => $this->input->post('status')
        ];

        $pengajuan = [
            'kode_barang' => $this->input->post('kode_barang'),
        ];
        $this->db->update('barang', $data);
        $pengajuan_id = $this->db->get_where('pengajuan',['kode_barang'=>$kode_lama])->row_array()['pengajuan_id'];
        // echo $kode_lama." ".$pengajuan_id; die;
        $this->db->where('pengajuan_id', $pengajuan_id);
        $this->db->update('pengajuan', $pengajuan);
        redirect(base_url('pengajuan'));
    }

    public function tolak()
    {
        $kode_lama = $this->db->get_where('barang', ['barang_id'=>$this->input->post('id')])->row_array()['kode_barang'];
        $this->db->where('barang_id', $this->input->post('id'));
        $data = [
            'tanggal_masuk'     => date('Y-m-d'), 
            'status'      => $this->input->post('status')
        ];
        $this->db->update('barang', $data);
        redirect(base_url('pengajuan'));
    }

}
