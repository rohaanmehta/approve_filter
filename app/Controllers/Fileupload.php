<?php

namespace App\Controllers;

class Fileupload extends BaseController
{
    public function view()
    {
        return view('fileupload');
    }

    public function unlink()
    {
        $downloadname = date('d-M-Y') . '.csv';
        unlink("public/uploads" . '/' . $downloadname);
        $result['success'] = '400';
        return $this->response->setJSON($result);
    }

    public function file_upload()
    {
        $file = $this->request->getFile('file');
        if(is_file("public/uploads/test.csv")){
            unlink("public/uploads/test.csv");
        }
        $file->move(ROOTPATH . 'public/uploads/', 'test.csv');
        $data_res = $this->db->table('restrictions')->where('id', '1')->get(1)->getResultArray();
        $replace_Array_brand = explode(',', $data_res[0]['brand_res']);
        $replace_Array_product = explode(',', $data_res[0]['item_res']);
        $replace_Array_shipping = explode(',', $data_res[0]['shipping_res']);
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
        $errors = 0;
        $i  = 0;

        //remove all brand res
        foreach ($arr as $rows) {
            for ($j = 1; $j < 3; $j++) {
                foreach ($replace_Array_brand as $res) {
                    if (strpos($arr[$i][$j], $res) !== false) {
                        if(strpos($arr[$i][3],'Brand restrictions (' . $res . ')') === false){
                            if(isset($arr[$i][3]) && !empty($arr[$i][3])){
                                $arr[$i][3] .= ' | Brand restrictions (' . $res . ')';
                            }else{
                                $arr[$i][3] .= ',Brand restrictions (' . $res . ')';
                            }
                            $errors = $errors + 1;
                        }
                    }
                }
            }
            $i++;
        }

        // remove all product res
        $k  = 0;
        foreach ($arr as $rows2) {
            for ($j = 1; $j < 3; $j++) {
                foreach ($replace_Array_product as $res2) {
                    if (strpos($arr[$k][$j], $res2) !== false) {
                        if(strpos($arr[$k][3],'Product restrictions (' . $res2 . ')') === false){
                            if(isset($arr[$k][3]) && !empty($arr[$k][3])){
                                $arr[$k][3] .= ' | Product restrictions (' . $res2 . ')';
                            }else{
                                $arr[$k][3] .= ',Product restrictions (' . $res2 . ')';
                            }
                            $errors = $errors + 1;
                        }
                    }
                }
            }
            $k++;
        }

        //remove all shippin res
        $p  = 0;
        foreach ($arr as $rows3) {
            for ($j = 1; $j < 3; $j++) {
                foreach ($replace_Array_shipping as $res3) {
                    if (strpos($arr[$p][$j], $res3) !== false) {
                        if(strpos($arr[$p][3],'Shipping restrictions (' . $res3 . ')') === false){
                            if(isset($arr[$p][3]) && !empty($arr[$p][3])){
                                $arr[$p][3] .= ' | Shipping restrictions (' . $res3 . ')';
                            }else{
                                $arr[$p][3] .= ',Shipping restrictions (' . $res3 . ')';
                            }
                            $errors = $errors + 1;
                        }
                    }
                }
            }
            $p++;
        }
        $arr[0][3] = ',Comments';
        $csv = '';
        foreach ($arr as $str) {
            $csv = $csv . '
' . $str[0] . ',' . $str[1] . ',' . $str[2];
            if (isset($str[3])) {
                $csv = $csv . $str[3];
            }
        }

        // stats
        $statistics = $this->db->table('statistics')->where('id', '1')->get(1)->getResultArray();
        $stats = array(
            'filter_words' => $errors + $statistics[0]['filter_words'],
            'filter_times' => $statistics[0]['filter_times'] + 1,
        );
        $this->db->table('statistics')->set($stats)->where('id', '1')->update();
        $csv = trim($csv, ',');
        $downloadname = date('d-M-Y') . '.csv';
        if(is_file("public/uploads/".$downloadname)){
            unlink("public/uploads" . '/' . $downloadname);
        }
        $myfile = fopen("public/uploads/" . $downloadname, "w");
        fwrite($myfile, $csv);
        if(fclose($myfile)){
	        unlink("public/uploads/test.csv");
        	$result['success'] = '400';
        	return $this->response->setJSON($result);
	    }
    }
}
