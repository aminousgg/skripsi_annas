<?php
class Generic_model  extends CI_Model {
    
    private $table = "coba";
    public function getField($table)
    {
        return $this->db->query("
        SELECT `COLUMN_NAME` AS 'field', capital( REPLACE(`COLUMN_NAME`, '_', ' ') ) display_name
        FROM `INFORMATION_SCHEMA`.`COLUMNS` 
        WHERE `TABLE_SCHEMA`='generator_test' 
            AND `TABLE_NAME`='coba'
        ")->result();
    }

    public function allData($table)
    {
        return $this->db->get($table)->result_array();
    }

    public function getFieldTable($table)
    {
        return $this->db->query("
        SELECT `COLUMN_NAME` AS 'field', capital( REPLACE(`COLUMN_NAME`, '_', ' ') ) display_name
        FROM `INFORMATION_SCHEMA`.`COLUMNS` 
        WHERE `TABLE_SCHEMA`='simbelmawa' AND `COLUMN_NAME` NOT IN ('created_at', 'updated_at')
            AND `TABLE_NAME`='$table'
        ")->result_array();
    }

    public function getObjectFieldTable($table)
    {
        return $this->db->query("
        SELECT `COLUMN_NAME` AS 'field',
        CASE
            WHEN capital( REPLACE(`COLUMN_NAME`, '_', ' ') ) = 'Deskripsi' THEN 'Abstrak'
            ELSE capital( REPLACE(`COLUMN_NAME`, '_', ' ') )
        END
        display_name
            FROM `INFORMATION_SCHEMA`.`COLUMNS` 
            WHERE `TABLE_SCHEMA`='simbelmawa' AND `COLUMN_NAME` NOT IN ('created_at', 'updated_at')
                AND `TABLE_NAME`='$table'
        ")->result();
    }

    public function usersGet()
    {
        return $this->db->query("
        SELECT u.*, r.role_name
        FROM view_users u
        LEFT JOIN role r ON u.role_id = r.id
        ")->result();
    }


    public function MhsPembimbingTake($nim)
    {
        return $this->db->select('pt.*, pd.nama as nama_dosen')
                        ->from('pembimbing_take pt')
                        ->join('person_dosen pd','pt.nip_dosen = pd.nip','left')
                        ->where('nim_mahasiswa', $nim)
                        ->get()->result();
    }

    public function DsnPembimbingTake($nip)
    {
        return $this->db->select('pt.*, pm.nama as nama_mahasiswa')
                        ->from('pembimbing_take pt')
                        ->join('person_mahasiswa pm','pt.nim_mahasiswa = pm.nim','left')
                        ->where('nip_dosen', $nip)
                        ->get()->result();
    }

    public function bedahValueSelect($table)
    {
        $data = $this->db->get($table)->result();
        $res = [];
        foreach($data as $row)
        {
            $res[]  = [
                'value' => $row->nip,
                'name'  => $row->nama
            ];
        }
        return $res;
        
    }

    public function bedahValueSelectJenis($table)
    {
        $data = $this->db->get($table)->result();
        $res = [];
        foreach($data as $row)
        {
            $res[]  = [
                'value' => $row->id,
                'name'  => $row->nama_jenis
            ];
        }
        return $res;
        
    }


    public function MhsProposal($nim)
    {
        return $this->db->query("
        SELECT p.id, p.judul_proposal, CONCAT(LEFT(p.deskripsi, 30), ' <a href=`#`>Read more</a>') as deskripsi, p.pengusul, pm.nama AS nama_pengusul , p.pembimbing, pd.nama AS nama_pembimbing, p.status, p.file 
        FROM proposal p
        LEFT JOIN person_mahasiswa pm ON p.pengusul = pm.nim
        LEFT JOIN person_dosen pd ON p.pembimbing = pd.nip
        WHERE p.pengusul = '$nim'
        ")->result();
    }

    public function MhsReviewProposalList($nim, $status)
    {
        return $this->db->query("
        SELECT p.id, p.judul_proposal, CONCAT(LEFT(p.deskripsi, 30), ' <a href=`#`>Read more</a>') as deskripsi, p.pengusul, pm.nama AS nama_pengusul , p.pembimbing, pd.nama AS nama_pembimbing, p.status, p.file 
        FROM proposal p
        LEFT JOIN person_mahasiswa pm ON p.pengusul = pm.nim
        LEFT JOIN person_dosen pd ON p.pembimbing = pd.nip
        WHERE p.pengusul = '$nim' AND p.status = '$status'
        ")->result();
    }

    public function DsnProposal($nip)
    {
        return $this->db->query("
        SELECT p.id, p.judul_proposal, CONCAT(LEFT(p.deskripsi, 30), ' <a href=`#`>Read more</a>') as deskripsi, p.pengusul, pm.nama AS nama_pengusul , p.pembimbing, pd.nama AS nama_pembimbing, p.status, p.file 
        FROM proposal p
        LEFT JOIN person_mahasiswa pm ON p.pengusul = pm.nim
        LEFT JOIN person_dosen pd ON p.pembimbing = pd.nip
        WHERE p.pembimbing = '$nip'
        ")->result();
    }

    public function MhsGetPembimbing($nim)
    {
        return $this->db->query("
        SELECT pt.id, pt.nip_dosen, pd.nama AS nama_dosen
        FROM pembimbing_take pt
        LEFT JOIN person_dosen pd ON pt.nip_dosen = pd.nip
        WHERE pt.nim_mahasiswa = '$nim'")->row_array();
    }


    public function MhsStateStatus($jenis, $nim)
    {
        $status = "";
        if($jenis=="pembimbing")
        {
            $isian = $this->db->get_where('pembimbing_take', ['nim_mahasiswa'=>$nim])->num_rows();
            if($isian < 1)
            {
                $status = "belum";
            }
            else
            {
                $status = $this->db->get_where('pembimbing_take', ['nim_mahasiswa'=>$nim])->row_array()['status'];
            }
        }
        if($jenis=="proposal")
        {
            $isian = $this->db->get_where('proposal', ['pengusul'=>$nim]);
            if($isian->num_rows() < 1)
            {
                $status = "belum";
            }
            else
            {
                $status = $isian->num_rows()['status'];
            }
        }
        return $status;
    }


    public function MhsCekTambah($jenis, $nim)
    {
        if($jenis == "pembimbing")
        {
            $cek = $this->db->query("
            SELECT pt.status
            FROM pembimbing_take pt
            WHERE pt.nim_mahasiswa = '$nim'
            ORDER BY id DESC
            LIMIT 1
            ")->row_array();
            if($cek == NULL)
            {
                return true;
            }
            if($cek['status'] == "Ditolak")
            {
                return true;
            }
            if($cek['status'] == "Pending")
            {
                return false;
            }
            if($cek['status'] == "Disetujui")
            {
                return false;
            }
            if($cek['status'] == null || $cek == [])
            {
                return true;
            }
        }
        if($jenis == "proposal")
        {
            $cek = $this->db->query("
            SELECT pt.status
            FROM proposal pt
            WHERE pt.pengusul = '$nim'
            ORDER BY id DESC
            LIMIT 1
            ")->row_array();
            // var_dump($cek); die;
            if($cek == NULL)
            {
                return true;
            }
            if($cek['status'] == "Proses")
            {
                return false;
            }
            if($cek['status'] == "Pending")
            {
                return false;
            }
            if($cek['status'] == "Diterima")
            {
                return false;
            }
            if($cek['status'] == null)
            {
                return true;
            }
        }
    }


    public function DsnDetailProposal($proposal_id)
    {
        return $this->db->query("
            SELECT p.id AS id_proposal, lb.id AS id_log, p.judul_proposal, lb.tanggal, lb.tahapan_id, tb.nama_tahapan, lb.check_status, lb.pesan AS catatan
            FROM proposal p
            LEFT JOIN log_bimbingan lb ON lb.proposal_id = p.id
            LEFT JOIN tahapan_bimbingan tb ON lb.tahapan_id = tb.id
            WHERE p.id = '$proposal_id'
        ")->result();
    }

    public function MhsDetailProposal($proposal_id)
    {
        return $this->db->query("
            SELECT p.id AS id_proposal, lb.id AS id_log, p.judul_proposal, lb.tanggal, lb.tahapan_id, tb.nama_tahapan, lb.check_status, lb.pesan AS catatan
            FROM proposal p
            LEFT JOIN log_bimbingan lb ON lb.proposal_id = p.id
            LEFT JOIN tahapan_bimbingan tb ON lb.tahapan_id = tb.id
            WHERE p.id = '$proposal_id'
        ")->result();
    }

    public function reviewProposal()
    {
        return $this->db->query(
            "SELECT p.*, pm.`nama` AS nama_pengusul, pd.`nama` AS nama_pembimbing, DATE(created_at) tanggal
            FROM proposal p
            LEFT JOIN person_mahasiswa pm ON p.`pengusul` = pm.`nim`
            LEFT JOIN person_dosen pd ON p.`pembimbing` = pd.`nip`
            WHERE p.status = 'Diterima'"
        )->result();
    }


    public function checkTahapanOn($proposal_id)
    {
        
        $res = $this->db->query("
            SELECT lb.tahapan_id + 1 AS tahapan_id
            FROM log_bimbingan lb
            WHERE lb.check_status = '1' AND lb.proposal_id = '$proposal_id'
            ORDER BY lb.tahapan_id DESC
            LIMIT 1
        ")->row_array();

        if($res == NULL)
        {
            return 1;
        }
        else
        {
            return $res['tahapan_id'];
        }
    }

    public function getAllProposalAdmin()
    {
        return $this->db->query(
            "SELECT p.*, pm.nama AS nama_pengusul, pd.nama AS nama_pembimbing, jp.nama_jenis AS jenis,
            CONCAT(LEFT(p.deskripsi, 30), ' <a href=#>Read more</a>') AS abstrak
            FROM proposal p
            LEFT JOIN person_mahasiswa pm ON p.pengusul = pm.nim
            LEFT JOIN person_dosen pd ON p.pembimbing = pd.nip
            LEFT JOIN jenis_proposal jp ON p.id_jenis = jp.id"
        )->result_array();
    }

    // public function MhscheckTambahOn_()
    // {

    // }

    public function adminDashboard()
    {
        return [
            'proposal'  => $this->db->get('proposal')->num_rows(),
            'pembimbing'=> $this->db->get('person_dosen')->num_rows(),
            'mahasiswa'=> $this->db->get('person_mahasiswa')->num_rows(),
            'proposal_diterima' => $this->db->get_where('proposal',['status'=>'Diterima'])->num_rows()
        ];
    }

    public function reviewGetHeadForm($id)
    {
        return $this->db->query(
            "SELECT id, head_kriteria
            FROM view_penilaian
            WHERE proposal_id = '$id'
            GROUP BY head_kriteria
            ORDER BY head_kriteria desc"
        )->result();
    }

    public function efekUbahJenisProposal($proposal_id, $id_jenis, $id_jenis_terbaru)
    {
        $res = false;
        $get_nilai = $this->db->query(
            "SELECT fn.id AS id_nilai, fn.`proposal_id`, p.`judul_proposal`, p.`deskripsi`, p.`file`, p.`pengusul`, pm.`nama` AS nama_pengusul, p.`pembimbing`, pd.`nama` AS nama_pembimbing,
            p.id_jenis
            FROM form_nilai fn
            LEFT JOIN proposal p ON fn.proposal_id = p.id
            LEFT JOIN person_mahasiswa pm ON p.`pengusul` = pm.`nim`
            LEFT JOIN person_dosen pd ON p.`pembimbing` = pd.`nip`
            WHERE fn.proposal_id = '$proposal_id' AND p.id_jenis = '$id_jenis'"
        )->result();

        foreach($get_nilai as $row_nilai)
        {
            $this->db->where('id', $row_nilai->id_nilai);
            $res = $this->db->delete('form_nilai');
        }

        // $proposal_id = $this->input->post('proposal_id');
        // $jenis = $this->db->get_where('proposal', ['id' => $proposal_id])->row_array()['id_jenis'];
        
        $form = $this->db->get_where('form_penilaian_proposal', ['jenis_proposal_id'=>$id_jenis_terbaru])->result();
        foreach($form as $row)
        {
            $data_nilai = [
                'proposal_id'   => $proposal_id,
                'penilaian_id'  => $row->id
            ];
            $this->db->insert('form_nilai', $data_nilai);
        }

        return $res;
        
    }



}