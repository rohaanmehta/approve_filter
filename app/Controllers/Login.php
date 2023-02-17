<?php

namespace App\Controllers;

class Login extends BaseController
{
    public function view()
    {
        if($this->session->get('username') != ''){
            return view('dashboard');   
        }
        return view('login');   
    }
    public function Auth(){
        helper('cookie');
        $pass = md5($_POST['password']);
        $data = array(
            'email' => $_POST['username'],
            'password' => $pass,
        );
        $time = array(
            'lastlogin'=> date('Y-m-d H:i:s')
        );
        $count = $this->db->table('credentials')->where($data)->countAllResults();
        if($count == 0){
            $result['result'] = '200';
        }else{
            $result['result'] = '400';
            $this->session->set('username',$_POST['username']);
            if($_POST['rememberme'] == 'on'){
                set_cookie('email',$_POST['username'],'0');
                set_cookie('password',$_POST['password'],'0');
            }else{
                delete_cookie('email');
                delete_cookie('password');
            }
            $this->db->table('credentials')->set($time)->where('email',$_POST['username'])->update();
        }
        return $this->response->setJSON($result);
    }

    public function logout(){
        $this->session->remove('username');
        $result['result'] = '400';
        return $this->response->setJSON($result);
    }
}
