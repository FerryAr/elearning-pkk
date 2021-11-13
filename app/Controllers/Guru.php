<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx as ReaderXlsx;
use PhpOffice\PhpSpreadsheet\Reader\Xls as ReaderXls;
use PhpOffice\PhpSpreadsheet\Reader\Csv as ReaderCsv;
use CodeIgniter\HTTP\IncomingRequest;

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
            ->select('guru.id, guru.nip, guru.nama_guru, guru.email, guru.alamat, guru.no_telp')
            ->join('users', 'guru.email=users.email', 'left')
            ->join('auth_groups_users', 'users.id=auth_groups_users.user_id')
            ->where('auth_groups_users.group_id', 3)
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
    public function import_excel()
    {
        // if($this->request->getVar('submit')) {
             $file = $this->request->getFile('fileexcel');
        //     if(empty($file)) {
        //         $this->session->setFlashdata('msg', 'File tidak boleh kosong!');
        //         header('Location: ' . base_url('guru'));
        //     }
        //     $ext = $file->guessExtension();
        //     if($ext == 'xls') {
        //         $reader = new ReaderXls();
        //     } elseif($ext == 'xlsx') {
        //         $reader = new ReaderXlsx();
        //     } elseif($ext == 'csv') {
        //         $reader = new ReaderCsv();
        //     } else {
        //         $this->session->setFlashdata('msg', 'File yang diupload harus berformat .xls, .xlsx atau .csv');
        //         header('Location: ' . base_url('guru'));
        //     }
        //     $spreadsheet = $reader->load($file);
        //     $data = $spreadsheet->getActiveSheet()->toArray();
        //     foreach($data as $x => $row) {
        //         if($x == 0) {
        //             continue;
        //         }
        //         $nip = $row[0];
        //         $nama_guru = $row[1];
        //         $email = $row[2];
        //         $no_telp = $row[3];
        //         $alamat = $row[4];
        //         $cekNip = $this->db->table('guru')->where('nip', $nip)->get()->getResult();
        //         if(count($cekNip) > 0) {
        //             $query = $this->db->table('guru')->where('nip', $nip)->update([
        //                 'nama_guru' => $nama_guru,
        //                 'email' => $email,
        //                 'no_telp' => $no_telp,
        //                 'alamat' => $alamat
        //             ]);
        //             if($query) {
        //                 $this->session->setFlashdata('msg', 'Data berhasil diimport');
        //                 return redirect()->to('guru');
        //             } else {
        //                 $this->session->setFlashdata('msg', 'Data gagal diimport');
        //                 return redirect()->to('guru');
        //             }
        //         } else {
        //             $query = $this->db->table('guru')->insert([
        //                 'nip' => $nip,
        //                 'nama_guru' => $nama_guru,
        //                 'email' => $email,
        //                 'no_telp' => $no_telp,
        //                 'alamat' => $alamat
        //             ]);
        //             if($query) {
        //                 $this->session->setFlashdata('msg', 'Data berhasil diimport');
        //                 return redirect()->to('guru');
        //             } else {
        //                 $this->session->setFlashdata('msg', 'Data gagal diimport');
        //                 return redirect()->to('guru');
        //             }
        //         }
        //     }
        // }
        var_dump($file);
            
    }
}
