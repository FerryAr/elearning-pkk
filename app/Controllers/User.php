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
        helper('auth');
        if(logged_in()) {
            if(!in_groups(2)) {
                return redirect()->to('home');
            }
        } else {
           return redirect()->to('login');
        }
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
    public function create() {
        helper('date');
        $request = service('request');
        if($this->request->isAJAX()) {
            $db = db_connect();
            $username = $request->getPost('username');
            $email = $request->getPost('email');
            $password = $request->getPost('password');
            $password_hash = \Myth\Auth\Password::hash($password);
            $now = date("Y-m-d H:i:s", now());
            $data = array(
                'email' => $email,
                'username' => $username,
                'password_hash' => $password_hash,
                'active' => 1,
                'created_at' => $now,
                'updated_at' => $now
            );
            $users = $db->table('users');
            if($users->insert($data)) {
                $user_id = $db->insertID();
                $group_id = $request->getPost('role');
                $builder = $db->table('auth_groups_users');
                $data_group = array(
                    'group_id' => $group_id,
                    'user_id' => $user_id
                );
                if($builder->insert($data_group)) {
                    $arr = array(
                        'msg' => 'Tambah User Berhasil!',
                    );
                    header('Content-type: application/json');
                    echo json_encode($arr);
                } else {
                    $arr = array(
                        'msg' => 'User berhasil ditambahkan namun gagal menetapkan role di user ini, Kemungkinan akun tidak dapat digunakan',
                    );
                    header('Content-type: application/json');
                    echo json_encode($arr);
                }
            } else {
                $arr = array(
                    'msg' => 'Tambah User gagal!',
                );
                header('Content-type: application/json');
                echo json_encode($arr);
            }
 
        }
    }
    public function edit()
    {
        helper('date');
        $request = service('request');
        if($this->request->isAJAX()) {
            $db = db_connect();
            $id = $request->getVar('id');
            $username = $request->getPost('username');
            $email = $request->getPost('email');
            $now = date("Y-m-d H:i:s", now());
            $users = $db->table('users');
            $users->set('email', $email);
            $users->set('username', $username);
            if(isset($password)) {
                $password = $request->getPost('password');
                $password_hash = \Myth\Auth\Password::hash($password);
                $users->set('password_hash', $password_hash);
            }
            $users->set('updated_at', $now);    
            $users->where('id', $id);
            $group_id = $request->getPost('role');
            $builder = $db->table('auth_groups_users');
            $builder->set('group_id', $group_id);
            $builder->where('user_id', $id);
            if(!$users->update()) {
                $arr = array(
                    'msg' => 'Edit User gagal!',
                );
                header('Content-type: application/json');
                echo json_encode($arr);
            } else {
                if(!$builder->update()) {
                    $arr = array(
                        'msg' => 'Edit User berhasil namun Edit role gagal!',
                    );
                    header('Content-type: application/json');
                    echo json_encode($arr);
                } else {
                    $arr = array(
                        'msg' => 'Edit User berhasil!',
                    );
                    header('Content-type: application/json');
                    echo json_encode($arr);
                }
            }
            
        }
    }
    public function delete()
    {
        $session = \Config\Services::session();
        if($this->request->getGet('id')) {
            $id = $this->request->getGet('id');
            $db = db_connect();
            $users = $db->table('users');
            if($users->delete(['id' => $id])) {
                $session->setFlashdata('msg', 'Hapus User berhasil');
                return redirect()->to('User');
            }
            else {
                $session->setFlashdata('msg', 'Hapus User gagal');
                return redirect()->to('User');
            }
        }
    }
}
