<?php

namespace App\Controllers;

class Csv extends BaseController
{
    public function view()
    {
        $data['result'] = $this->db->table('csv')->where('is_deleted','0')->get()->getResultArray();
        return view('csv',$data);
    }

    public function delete_csv($id = null){
        $data = array(
            'id' => $id
        );
        $this->db->table('csv')->set('is_deleted','1')->where($data)->update();
        return $this->response->setJson($data);
    }

    public function approve_csv($id = null){
        $data = array(
            'id' => $id
        );
        $check = $this->db->table('csv')->where($data)->get(1)->getResultArray();
        if($check[0]['is_approved'] == '0'){
            $this->db->table('csv')->set('is_approved','1')->where($data)->update();
        }else{
            $this->db->table('csv')->set('is_approved','0')->where($data)->update();
        }
        return $this->response->setJson($data);
    }

    public function file_upload()
    {
        $file = $this->request->getFile('file');
        if(is_file("public/uploads/test.csv")){
            unlink("public/uploads/test.csv");
        }
        $file->move(ROOTPATH . 'public/uploads/', 'test.csv');
        $arr = array(array(), array());
        $num = 0;
        $row = 0;
        $handle = fopen("public/uploads/test.csv", "r");

        //remove all commas
        while ($data = fgetcsv($handle, 1000, ",")) {
            $num = count($data);
            for ($c = 0; $c < $num; $c++) {
                $str = str_replace(',', ' ', $data[$c]);
                $arr[$row][$c] = $str;
            }
            $row++;
        }
        // echo'<pre>';print_r($arr);exit;
        for($k = 1; $k < count($arr); $k++){
            $data = array(
                'image' => $arr[$k][0],
                'name' => $arr[$k][1],
                'sku' => $arr[$k][2],
                'price' => $arr[$k][3],
                'date' => date('Y-m-d'),
            );
            $this->db->table('csv')->insert($data);
        }
        unlink("public/uploads/test.csv");
        $result['success'] = '400';
        return $this->response->setJSON($result);
    }
}