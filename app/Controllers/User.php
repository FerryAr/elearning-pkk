<?php 
namespace App\Controllers;

class User extends BaseController {
    // public function json()
    // {
    //     $db = db_connect();
    //     $builder = $db->table('users')
    //             ->select('users.id, users.username, users.email, aut_groups.name')
    //             ->join('auth_groups_users', 'auth_groups_users.user_id=users.id', 'left')
    //             ->join('auth_groups', 'auth_groups.id=auth_groups_users.group_id', 'left');
    //     return DataTable::of($builder)->addNumbering()->toJson();
    // }
    public function data() {
        $db = db_connect();
        $query = $db->table('users')
        ->select('users.username, users.email, auth_groups.name')
        ->join('auth_groups_users', 'auth_groups_users.user_id=users.id', 'left')
        ->join('auth_groups', 'auth_groups.id=auth_groups_users.group_id', 'left')
        ->get()->getResult();
    }
    public function index() {
        //if(logged_in()) {
            //if(!in_groups(1)) {
                //return redirect()->to('home');
            //}
        //} else {
        //    return redirect()->to('login');
        //}
        $db = db_connect();
        $query = $db->table('users')
        ->select('users.id, users.username, users.email, auth_groups.name')
        ->join('auth_groups_users', 'auth_groups_users.user_id=users.id', 'left')
        ->join('auth_groups', 'auth_groups.id=auth_groups_users.group_id', 'left')
        ->get()->getResult();
        $role = $db->table('auth_groups')
                ->select('auth_groups.id, auth_groups.name')
                ->get()->getResult();
        $data = array(
            'data_user' => $query,
            'role' => $role,
            'title' => 'Data Master User | Elearning',
            'page' => 'Data Master User'
        );
        echo view('_template/header', $data);
        echo view('users/index');
        echo view('_template/footer');
    }
    public function json() {
        $arr = [];
    }
}
