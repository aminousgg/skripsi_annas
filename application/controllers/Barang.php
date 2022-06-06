<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include("libraries/autoload.php");
use GroceryCrud\Core\GroceryCrud;
use GroceryCrud\Core\Model\whereModel;


class Barang extends CI_controller {


    private $views = "barang";
    private $modul = "";
    public function __construct()
    {
        parent::__construct();
        $database = include('database.php'); //config database Grocery
        $config = include('config.php'); //config library Grocery
        $this->crud = new GroceryCrud($config, $database); //initialize Grocery
        /* start Grocery global configuration */
        $this->crud->setLanguage("Indonesian");
        $this->crud->setLangString('close_modal', 'Tutup');
        // $this->crud->setTheme('bootstrap-v4');
        // $this->crud->unsetSettings();
        $this->crud->unsetJquery();

        $this->load->helper('download');
        $this->load->helper("security");

        $this->load->model('Generic_model', 'global');
        $this->load->library('Generate', NULL, 'gen');
    }

    public function index()
    {
        $this->crud->setTable('barang');
        $this->crud->setSubject('barang', 'Daftar Barang');
        $this->crud->setRelation('divisi_id', 'divisi', 'nama_divisi');
        $this->crud->unsetColumns(['created_at']);
        $this->crud->unsetFields(['created_at',]);
        $this->crud->unsetEditFields(['kode_barang']);
        $this->crud->setRelation('golongan_id', 'golongan', 'nama_golongan');
        $this->crud->displayAs('golongan_id', 'golongan');
        $this->crud->displayAs('divisi_id', 'divisi');
        $output = $this->crud->render();
	        if ($output->isJSONResponse) {
	            header('Content-Type: application/json; charset=utf-8');
	            echo $output->output;
	            exit;
	        }

        $data = [
            'title'     => "Master Barang",
            'sub_title' => "&nbsp;",
            'gcrud'     => 1,
            'css_files' => $output->css_files,
  	        'js_files' =>$output->js_files,
  	        'output' =>$output->output,
        ];
        $this->load->view("$this->views/index", $data);
    }

    public function merk()
    {
        $this->crud->setTable('merk');
        $this->crud->setSubject('Merk', 'Daftar Merk');

        $output = $this->crud->render();
          if ($output->isJSONResponse) {
              header('Content-Type: application/json; charset=utf-8');
              echo $output->output;
              exit;
          }

        $data = [
            'title'     => "Merk Barang",
            'sub_title' => "&nbsp;",
            'gcrud'     => 1,
            'css_files' => $output->css_files,
            'js_files' =>$output->js_files,
            'output' =>$output->output,
        ];
        $this->load->view("$this->views/index", $data);
    }

    public function get_barang()
    {
        $id = $this->input->get('barang_id');
        $barang = $this->db->select('*')
        ->from('barang b')
        ->join('golongan g', 'b.golongan_id = g.golongan_id', 'left')
        ->where('barang_id', $id)
        ->get()->row_array();
        echo json_encode($barang);
    }

    public function get_tahun()
    {
        $tahun = $this->db->select('year(tanggal_masuk) as tahun')
        ->from('barang')
        ->where('tanggal_masuk is NOT NULL', NULL, FALSE)
        ->where('barang_id', $this->input->get('barang_id'))->get()->row_array();
        $res = (int)$this->input->get('tahun') - (int)$tahun['tahun'];
        echo json_encode($res);
    }

}
