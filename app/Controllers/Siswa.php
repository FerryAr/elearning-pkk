<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Siswa extends BaseController
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
        $query = $db->table('siswa')
            ->select('siswa.nis, siswa.first_name, siswa.last_name, siswa.email, siswa.alamat, siswa.tanggal_lahir ,kelas.nama_kelas, jurusan.nama_jurusan')
            ->join('kelas', 'kelas.id = siswa.id_kelas')
            ->join('jurusan', 'jurusan.id = kelas.id_jurusan')
            ->join('users', 'users.email = siswa.email')
            ->join('auth_groups_users', 'users.id=auth_groups_users.user_id')
            ->where('auth_groups_users.group_id', 4)
            ->get()
            ->getResult();
        $kelas = $db->table('kelas')
            ->select('kelas.id, kelas.nama_kelas')
            ->get()
            ->getResult();
        $data = array(
            'siswa' => $query,
            'title' => 'Data Master Siswa | Elearning',
            'page' => 'Data Master Siswa',
            'kelas' => $kelas
        );
        echo view('_template/header', $data);
        echo view('siswa/index');
        echo view('_template/footer');
    }
    public function json() {
        if($this->request->isAJAX()) {
            $arr = [];
            $db = db_connect();
            $nis = $this->request->getPost('nis');
            $query = $db->table('siswa')
                ->select('siswa.nis, siswa.first_name, siswa.last_name, siswa.email, siswa.alamat, siswa.tanggal_lahir ,kelas.id')
                ->join('kelas', 'kelas.id = siswa.id_kelas')
                //->join('users', 'users.email = siswa.email')
                //->join('auth_groups_users', 'users.id=auth_groups_users.user_id')
                ->where('siswa.nis', $nis)
                ->get()
                ->getResult();
            foreach ($query as $row) {
                array_push($arr, 
                    array(
                        'nis' => $row->nis,
                        'first_name' => $row->first_name,
                        'last_name' => $row->last_name,
                        'email' => $row->email,
                        'alamat' => $row->alamat,
                        'tanggal_lahir' => $row->tanggal_lahir,
                        'id_kelas' => $row->id
                    )
                );
            }
            echo json_encode($arr);
            header('Content-Type: application/json');
        }
    }

    public function create() {
        if($this->request->isAJAX()) {
            $db = db_connect();
            $data = array(
                'nis' => $this->request->getPost('nis'),
                'first_name' => $this->request->getPost('first_name'),
                'last_name' => $this->request->getPost('last_name'),
                'email' => $this->request->getPost('email'),
                'alamat' => $this->request->getPost('alamat'),
                'tanggal_lahir' => $this->request->getPost('tanggal_lahir'),
                'id_kelas' => $this->request->getPost('id_kelas')
            );
            $query = $db->table('siswa')->insert($data);
            if($query) {
                $response = array(
                    'msg' => 'Data berhasil disimpan'
                );
                header('Content-Type: application/json');
                echo json_encode($response);
            } else {
                $response = array(
                    'msg' => 'Data gagal disimpan'
                );
                header('Content-Type: application/json');
                echo json_encode($response);
            }
            
        }
    }
    public function json_read_all_siswa() {
        if($this->request->isAJAX()) {
            $db = db_connect();
            $arr = [];
            $query = $db->table('siswa')
                ->select('siswa.nis, siswa.first_name, siswa.last_name, siswa.email, siswa.alamat, siswa.tanggal_lahir')
                // ->join('kelas', 'kelas.id = siswa.id_kelas', 'inner')
                // ->join('jurusan', 'jurusan.id = kelas.id_jurusan', 'inner')
                //->join('users', 'users.email = siswa.email', 'inner')
                //->join('auth_groups_users', 'users.id=auth_groups_users.user_id')
                ->where('siswa.id_kelas', NULL)
                ->get()
                ->getResult();
            foreach($query as $q) {
                array_push($arr, array(
                    'nis' => $q->nis,
                    'first_name' => $q->first_name,
                    'last_name' => $q->last_name,
                    'email' => $q->email,
                    'alamat' => $q->alamat,
                    'tanggal_lahir' => $q->tanggal_lahir
                ));
            }
            header('Content-Type: application/json');
            echo json_encode($arr);
        }
    }
    public function edit() {
        if($this->request->isAJAX()) {
            $db = db_connect();
            $data = array(
                'nis' => $this->request->getPost('nis'),
                'first_name' => $this->request->getPost('first_name'),
                'last_name' => $this->request->getPost('last_name'),
                'email' => $this->request->getPost('email'),
                'alamat' => $this->request->getPost('alamat'),
                'tanggal_lahir' => $this->request->getPost('tanggal_lahir'),
                'id_kelas' => $this->request->getPost('id_kelas')
            );
            $query = $db->table('siswa')->where('nis', $this->request->getPost('nis'))->update($data);
            if($query) {
                $response = array(
                    'msg' => 'Data berhasil diubah'
                );
                header('Content-Type: application/json');
                echo json_encode($response);
            } else {
                $response = array(
                    'msg' => 'Data gagal diubah'
                );
                header('Content-Type: application/json');
                echo json_encode($response);
            }
        }
    }
}
