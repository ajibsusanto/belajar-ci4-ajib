<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\UserModel;

class AuthController extends BaseController
{   protected $user;

    function __construct()
    {
        helper('form');
        $this->user= new UserModel();
    }
    public function logout()
{
    session()->destroy();
    return redirect()->to('login');
}
    public function login()
{
    if ($this->request->getPost()) {
        $username = $this->request->getVar('username');
        $password = $this->request->getVar('password');

        //$dataUser = ['username' => 'admin', 'password' => '202cb962ac59075b964b07152d234b70', 'role' => 'admin']; // passw 123
        $dataUser=$this->user->where(['username' => $username])->first();
        //if ($username == $dataUser['username']) {
        if($dataUser){
            if(password_verify($password,$dataUser['password'])){    
            //if (md5($password) == $dataUser['password']) {
                session()->set([
                    'username' => $dataUser['username'],
                    'role' => $dataUser['role'],
                    'isLoggedIn' => TRUE
                ]);

                return redirect()->to(base_url('/'));
            } else {
                session()->setFlashdata('failed', 'Username & Password Salah');
                return redirect()->back();
            }
        } else {
            session()->setFlashdata('failed', 'Username Tidak Ditemukan');
            return redirect()->back();
        }
    } else {
        return view('v_login');
    }
}
}
