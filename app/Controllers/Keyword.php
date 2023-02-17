<?php

namespace App\Controllers;

class Keyword extends BaseController
{
    public function view()
    {
        $data['update'] = $this->db->table('restrictions')->where('id','1')->get(1)->getResultArray();
        return view('keyword',$data);
    }
    public function add_keyword(){
        $backup = $this->db->table('restrictions')->where('id','1')->get(1)->getResultArray();
        $data = array(
            'brand_res' => trim($_POST['brand_res'],','),
            'item_res' => trim($_POST['item_res'],','),
            'shipping_res' => trim($_POST['shipping_res'],',')
        );
        $backup_data = array(
            'brand_res' => $backup[0]['brand_res'],
            'item_res' => $backup[0]['item_res'],
            'shipping_res' => $backup[0]['shipping_res'],
        );
        $this->db->table('restrictions')->set($data)->where('id','1')->update();
        $this->db->table('backup_restrictions')->set($backup_data)->where('id','1')->update();
        return $this->response->setJSON($data);
    }
}
