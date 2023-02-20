<?php

namespace App\Controllers;

class Download extends BaseController
{
    public function view()
    {
        return view('download');
    }
    function download_csv(){
        $startdate = $_POST['startdate'];
        $enddate = $_POST['enddate'];
        $startdate = date('Y-m-d',strtotime($startdate));
        $enddate = date('Y-m-d',strtotime($enddate));
        $csv = $this->db->table('csv')->select('image,name,sku,price,date')->where('is_deleted','0')->where('is_approved','1')->where('date >=',$startdate)->where('date <=',$enddate)->get()->getResultArray();
        $data = 'image,name,sku,price,date';
        foreach($csv as $row){
            $data = $data.'
'.$row['image'].','.$row['name'].','.$row['sku'].','.$row['price'].','.$row['date'];
        }
        // create file
        $downloadname = 'CSV_'.date('Y-m-d').'.csv';
        $myfile = fopen("public/uploads/" . $downloadname, "w");
        fwrite($myfile, $data);
        $result['name'] = $downloadname;
        return $this->response->setJSON($result);
    }

    function unlink(){
        if(is_file("public/uploads/".$_POST['name'])){
            unlink("public/uploads/".$_POST['name']);
        }
    }
}
