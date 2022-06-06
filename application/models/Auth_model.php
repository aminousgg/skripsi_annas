<?php
class Auth_model  extends CI_Model {
    
    private $table = "coba";
    public function check($where)
    {
        $username = $where['username'];
        $password = $where['password'];
        $res = $this->db->query("
            SELECT *
            FROM (
                SELECT u.*, pd.nama
                FROM users u
                LEFT JOIN person_dosen pd ON u.person_id = pd.nip
                UNION
                SELECT u.*, pm.nama
                FROM users u
                LEFT JOIN person_mahasiswa pm ON u.person_id = pm.nim
                ) AS usr
            WHERE usr.nama IS NOT NULL AND usr.username = '$username' AND usr.password = '$password'
            GROUP BY usr.username
        ");
        if($res->row_array()['role_id']==1)
        {
            return [
                'role'  => 1,
                'data'  => $res->row_array()
            ];
        }
        elseif($res->row_array()['role_id']==2)
        {
            return [
                'role'  => 2,
                'data'  => $res->row_array()
            ];
        }
        elseif($res->row_array()['role_id']==4)
        {
            return [
                'role'  => 4,
                'data'  => $res->row_array()
            ];
        }
        elseif($res->row_array()['role_id']==3)
        {
            return [
                'role'  => 3,
                'data'  => $res->row_array()
            ];
        }
        else
        {
            return 0;
        }
    }

    public function allData($table)
    {
        return $this->db->get($table)->result_array();
    }
}