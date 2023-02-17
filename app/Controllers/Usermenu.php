<?php

namespace App\Controllers;

class Usermenu extends BaseController
{
    public function view()
    {
        $data['result'] = $this->db->table('credentials')->get()->getResultArray();
        return view('usermenu',$data);
    }
}
