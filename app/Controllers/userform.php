<?php

namespace App\Controllers;

class userform extends BaseController
{
    public function view()
    {
        return view('userform');
    }
    public function edit_user($id=null)
    {
        $data['update'] = $this->db->table('credentials')->where('id',$id)->get()->getResultArray();
        return view('userform',$data);
    }
    public function add_User(){
        $data = array(
            'firstname'=>$_POST['firstname'],
            'lastname'=>$_POST['lastname'],
            'email'=>$_POST['email'],
            'password'=>md5($_POST['password']),
        );        
        $id = $_POST['autoid'];
        $this->validation->setRule("firstname", "First Name ", "required");
        $this->validation->setRule("lastname", "Last Name ", "required");
        $this->validation->setRule("email", "Email ", "required|is_unique[credentials.email,id,{$id}]");
        $this->validation->setRule("password", "Password ", "required");

        if ($this->validation->withRequest($this->request)->run()) {
            if($_POST['autoid'] == ''){
                $this->db->table('credentials')->insert($data);
            }else{
                $this->db->table('credentials')->set($data)->where('id',$_POST['autoid'])->update();
            }
        } else {
            $json = array(
                "error" => true,
                "firstname" => $this->validation->getError("firstname"),
                "lastname" => $this->validation->getError("lastname"),
                "email" => $this->validation->getError("email"),
                "password" => $this->validation->getError("password")
            );
        }
        $json['result'] = '400';
        return $this->response->setJson($json);
    }

    public function delete_User($id = null){
        $data = array(
            'id' => $id
        );
        $this->db->table('credentials')->delete($data);
        return $this->response->setJson($data);
    }
}
