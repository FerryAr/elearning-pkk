<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Guru extends BaseController
{
    public function index()
    {
        helper('auth');
        if(logged_in()) {
            if(!in_groups(2)) {
                return redirect()->to('home');
            }
        } else {
           return redirect()->to('login');
        }
        $db = db_connect();
        $query = $db->table('guru')
            ->select('guru.id, guru.nip, guru.nama_guru, guru_email')
            ->join('users', 'guru.email=users.email', 'left')
            ->join('auth_groups_users', 'users.id=auth_groups_users.user_id')
            ->where('auth_groups_users.group_id', 2)
            ->get()->getResult();
        $data = array(
            'data_guru' => $query,
            'title' => 'Data Master Guru | Elearning',
            'page' => 'Data Master Guru',
        );
        echo view('_template/header', $data);
        echo view('guru/index');
        echo view('_template/footer');
    }
}
