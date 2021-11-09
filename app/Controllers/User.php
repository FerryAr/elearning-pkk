<?php 
namespace App\Controllers;

use CodeIgniter\HTTP\IncomingRequest;

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
            'page' => 'Data Master User',
        );
        echo view('_template/header', $data);
        echo view('users/index');
        echo view('_template/footer');
    }
    public function json() {
        if($this->request->isAJAX()) {
            $request = service('request');
            $id = $request->getPost('id');
            $arr = [];
            $db = db_connect();
            $query = $db->table('users')
                ->select('users.id, users.username, users.email, auth_groups_users.group_id')
                ->join('auth_groups_users', 'auth_groups_users.user_id=users.id', 'left')
                ->where('users.id', $id)
                ->get()->getResult();
            foreach($query as $q) {
                $id = $q->id;
                $username = $q->username;
                $email = $q->email;
                $role_id = $q->group_id;
                array_push($arr, ['id' => $id, 'username' => $username, 'email'=>$email, 'role_id'=>$role_id]);
            }
            header("Content-Type: application/json");
            echo json_encode($arr);
        }
    }
    public function edit()
    {
        $users = model(UserModel::class);
        $request = service('request');
        if($this->request->isAJAX()) {
            $id = $request->getVar('id');
            $username = $request->getPost('username');
            $email = $request->getPost('password');
            $password = $request->getPost('password');
            $password_hash = \Myth\Auth\Password::hash($password);
            $user = $users->where('id', $id);
            $user->username = $username;
            $user->email = $email;
            $user->password = $password_hash;

            if(!$users->save($user)) {
                $arr = array(
                    'msg' => 'Edit User gagal!',
                    'id' => $id
                );
                header('Content-type: application/json');
                echo json_encode($arr);
            }

            $db = db_connect();
            $group_id = $request->getPost('role');
            $builder = $db->table('auth_group_users');
            $builder->set('group_id', $group_id);
            $builder->where('user_id', $id);

            if(!$builder->update()) {
                $arr = array(
                    'msg' => 'Edit User gagal!'
                );
                header('Content-type: application/json');
                echo json_encode($arr);
            }
            
        }
    }
}
