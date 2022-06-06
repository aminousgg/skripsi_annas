<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Generate {

    public function __construct()
    {
        $this->ci =& get_instance();
    }

    public function build($class)
    {

    }

    private function view()
    {

    }
    private function controller()
    {
        
    }
    private function ddl()
    {

    }



    public function action($role_akses, $id)
    {
        $action_one = "";
        $action_loop = "";
        $link_up = base_url('admin/mahasiswa/update/'.$id);
        $link_del = base_url('admin/mahasiswa/delete');
        if($role_akses['create'])
        {
            $action_one .= '<button class="btn btn-primary btn-sm">Tambah</button>';
        }
        if($role_akses['update'])
        {
            $action_loop .= "<a href='$link_up' class='btn btn-primary btn-sm'>Update</a>";

        }
        if($role_akses['delete'])
        {
            $action_loop .= "
            <form method='post' action='$link_del' style='display: inline-grid;'>
                <input type='hidden' name='id' value='$id'>
                <button class='btn btn-danger btn-sm'>Delete</button>
            </form>
            ";
        }
        return [
            'one'   => $action_one,
            'loop'  => $action_loop
        ];
    }


    public function labelTable($field)
    {
        $display="";
        foreach($field as $row)
        {
            if($row['field']=="created_at" || $row['field']=="updated_at" || $row['field']=="id")
            {
                continue;
            }
            $name = $row['display_name'];
            $display .= "<th>$name</th>";
        }
        return $display;
    }


    public function displayTable($field, $data, $action)
    {
        $view = "
        
        ";
    }

    public function input($label, $name, $value, $type, $placeholder)
    {
        return "
        <div class='row mb-2'>
            <label class='col-3 font-weight-bold mt-2'>$label</label>
            <input class='col-9 form-control' name='$name' type='$type' value='$value' placeholder='$placeholder'>
        </div>
        ";
    }

    public function inputSelect($label, $name, $value, $placeholder, $data)
    {
        $option = "<option value=''>-- Pilih --</option>";;
        foreach($data as $row)
        {
            $value_ = $row['value'];
            $name_ = $row['name'];
            if($value == $value_)
            {
                $option .= "<option value='$value_' selected>$name_</option>";
            }
            else
            {
                $option .= "<option value='$value_'>$name_</option>";
            }
            
        }
        return "
        <div class='row mb-2'>
            <label class='col-3 font-weight-bold mt-2'>$label</label>
            <select class='form-control col-9' name='$name'>
                $option
            </select>
        </div>
        ";
    }


    public function inputEnter($label, $name, $value, $type, $placeholder, $isActive=true)
    {

        $dis = "";
        if($isActive == false)
        {
            $dis = "disabled";
        }

        return "
        <div class='form-group'>
            <label class='font-weight-bold mt-2'>$label</label>
            <input class='form-control' name='$name' type='$type' value='$value' placeholder='$placeholder' $dis>
        </div>
        ";
    }

    public function inputEnterSelect($label, $name, $value, $placeholder, $data)
    {
        $option = "<option value=''>-- Pilih --</option>";;
        foreach($data as $row)
        {
            $value_ = $row['value'];
            $name_ = $row['name'];
            if($value == $value_)
            {
                $option .= "<option value='$value_' selected>$name_</option>";
            }
            else
            {
                $option .= "<option value='$value_'>$name_</option>";
            }
            
        }
        return "
        <div class='form-group'>
            <label class='font-weight-bold mt-2'>$label</label>
            <select class='form-control' name='$name'>
                $option
            </select>
        </div>
        ";
    }
}