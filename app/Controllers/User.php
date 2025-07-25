<?php

namespace App\Controllers;

use App\Models\UserModel;

class User extends BaseController
{
  public function index()
  {
    $title = 'Daftar User';
    $Models = new UserModel;
    $users = $Models->findAll();
    return view('user/index', compact('title', 'users'));
  }

  public function login()
  {
    helper(['form']);
    $email = $this->request->getPost('email');
    $password = $this->request->getPost('password');
    if (!$email) {
      return view('user/login');
    }

    $session = session();
    $model = new UserModel();
    $login = $model->where('useremail', $email)->first();
    if ($login) {
      $pass = $login['userpassword'];
      if (password_verify($password, $pass)) {
        $login_data = [
          'user_id' => $login['id'],
          'user_name' => $login['username'],
          'user_email' => $login['useremail'],
          'logged_in' => TRUE,
        ];
        $session->set($login_data);
        return redirect('admin/artikel');
      } else {
        $session->setFlashdata("flash_msg", "Password salah.");
        return redirect()->to('/user/login');
      }
    } else {
      $session->setFlashdata("flash_msg", "email tidak terdaftar.");
      return redirect()->to('/user/login');
    }
  }
}
