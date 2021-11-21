<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx as ReaderXlsx;
use PhpOffice\PhpSpreadsheet\Reader\Xls as ReaderXls;
use PhpOffice\PhpSpreadsheet\Reader\Csv as ReaderCsv;

class Guru extends BaseController
{
    public function index()
    {
        helper('auth');
        if (logged_in()) {
            if (!in_groups(2)) {
                return redirect()->to('home');
            }
        } else {
            return redirect()->to('login');
        }
        $db = db_connect();
        $query = $db->table('guru')
            ->select('guru.id, guru.nip, guru.first_name, guru.last_name, guru.email, guru.alamat, guru.no_telp')
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

    public function json_read_all_guru()
    {
        $arr = [];
        if ($this->request->isAJAX()) {
            $db = db_connect();
            $query = $db->table('guru')
                ->select('guru.id, guru.nip, guru.first_name, guru.last_name, guru.email, guru.alamat, guru.no_telp')
                ->get()->getResult();
            foreach ($query as $q) {
                array_push($arr, array(
                    'id' => $q->id,
                    'nip' => $q->nip,
                    'first_name' => $q->first_name,
                    'last_name' => $q->last_name,
                    'email' => $q->email,
                    'alamat' => $q->alamat,
                    'no_telp' => $q->no_telp,
                ));
            }
            header('Content-Type: application/json');
            echo json_encode($arr);
        }
    }

    // Create Data Guru
    public function create()
    {
        $request = Service('request');
        if ($request->isAJAX()) {
            $db = db_connect();
            $data = array(
                'nip' => $request->getPost('nip'),
                'first_name' => $request->getPost('first_name'),
                'last_name' => $request->getPost('last_name'),
                'email' => $request->getPost('email'),
                'alamat' => $request->getPost('alamat'),
                'no_telp' => $request->getPost('no_telp'),
            );
            $query = $db->table('guru')->insert($data);
            if ($query) {
                $arr = array(
                    'msg' => 'Data guru berhasil ditambahkan',
                );
                header('Content-Type: application/json');
                echo json_encode($arr);
            } else {
                $arr = array(
                    'msg' => 'Data guru gagal ditambahkan',
                );
                header('Content-Type: application/json');
                echo json_encode($arr);
            }
        }
    }

    public function edit()
    {
        $request = service('request');
        if ($request->isAJAX()) {
            $db = db_connect();
            $data = array(
                'nip' => $request->getPost('nip'),
                'first_name' => $request->getPost('first_name'),
                'last_name' => $request->getPost('last_name'),
                'email' => $request->getPost('email'),
                'alamat' => $request->getPost('alamat'),
                'no_telp' => $request->getPost('no_telp'),
            );
            $query = $db->table('guru')
                ->where('id', $request->getPost('id'))
                ->update($data);
            if ($query) {
                $arr = array(
                    'msg' => 'Data guru berhasil diubah',
                );
                header('Content-Type: application/json');
                echo json_encode($arr);
            } else {
                $arr = array(
                    'msg' => 'Data guru gagal diubah',
                );
                header('Content-Type: application/json');
                echo json_encode($arr);
            }
        }
    }
    public function delete()
    {
        $session = \Config\Services::session();
        if ($this->request->getGet('id')) {
            $id = $this->request->getGet('id');
            $db = db_connect();
            $users = $db->table('guru');
            if ($users->delete(['id' => $id])) {
                $session->setFlashdata('msg', 'Hapus User berhasil');
                return redirect()->to('Guru');
            } else {
                $session->setFlashdata('msg', 'Hapus User gagal');
                return redirect()->to('Guru');
            }
        }
    }

    public function json()
    {
        $arr = [];
        if ($this->request->isAJAX()) {
            $id = $this->request->getPost('id');
            $db = db_connect();
            $query = $db->table('guru')
                ->select('guru.id, guru.nip, guru.first_name, guru.last_name, guru.email, guru.alamat, guru.no_telp')
                ->where('guru.id', $id)
                ->get()->getResult();
            foreach ($query as $q) {
                $id = $q->id;
                $nip = $q->nip;
                $first_name = $q->first_name;
                $last_name = $q->last_name;
                $email = $q->email;
                $alamat = $q->alamat;
                $no_telp = $q->no_telp;
                array_push($arr, ['id' => $id, 'nip' => $nip, 'first_name' => $first_name, 'last_name' => $last_name, 'email' => $email, 'alamat' => $alamat, 'no_telp' => $no_telp]);
                // array_push($arr, [
                //     'id' => $q->id,
                //     'nip' => $q->nip,
                //     'nama_guru' => $q->nama_guru,
                //     'email' => $q->email,
                //     'alamat' => $q->alamat,
                //     'no_telp' => $q->no_telp,
                // ]);
            }
            header('Content-Type: application/json');
            echo json_encode($arr);
        }
    }

    public function import_excel()
    {
        $db = db_connect();
        $request = service('request');
        $file = $request->getFile('fileexcel');
        if (!$file->isValid()) {
            session()->setFlashdata('msg', 'File yang anda pilih tidak valid');
            header('Location: ' . base_url('guru'));
        }
        if (empty($file)) {
            session()->setFlashdata('msg', 'File tidak boleh kosong!');
            return redirect()->to('guru');
        }
        $ext = $file->guessExtension();
        if ($ext == 'xls') {
            $reader = new ReaderXls();
        } elseif ($ext == 'xlsx') {
            $reader = new ReaderXlsx();
        } elseif ($ext == 'csv') {
            $reader = new ReaderCsv();
        } else {
            session()->setFlashdata('msg', 'File yang diupload harus berformat .xls, .xlsx atau .csv');
            return redirect()->to('guru');
        }
        $spreadsheet = $reader->load($file->getTempName());
        $data = $spreadsheet->getActiveSheet()->toArray();
        foreach ($data as $x => $d) {
            if ($x == 0) {
                continue;
            }
            $nip = $d[0];
            $first_name = $d[1];
            $last_name = $d[2];
            $email = $d[3];
            $alamat = $d[4];
            $no_telp = $d[5];

            $cekNip = $db->table('guru')->where('nip', $nip)->countAllResults();
            if ($cekNip > 0) {
                $db->table('guru')
                    ->where('nip', $nip)
                    ->update(array(
                        'nip' => $nip,
                        'first_name' => $first_name,
                        'last_name' => $last_name,
                        'email' => $email,
                        'alamat' => $alamat,
                        'no_telp' => $no_telp,
                    ));
                if ($db->affectedRows() > 0) {
                    echo '<head>';
                    echo '<script>';
                    echo 'alert("Data berhasil diimport"); window.location.href="' . base_url('guru') . '";';
                    echo '</script>';
                    echo '</head>';
                } else {
                    echo '<head>';
                    echo '<script>';
                    echo 'alert("Data gagal diimport"); window.location.href="' . base_url('guru') . '";';
                    echo '</script>';
                    echo '</head>';
                }
            } else {
                $db->table('guru')->insert([
                    'nip' => $nip,
                    'first_name' => $first_name,
                    'last_name' => $last_name,
                    'email' => $email,
                    'alamat' => $alamat,
                    'no_telp' => $no_telp,
                ]);


                if ($db->affectedRows() > 0) {
                    echo '<head>';
                    echo '<script>';
                    echo 'alert("Data berhasil diimport"); window.location.href="' . base_url('guru') . '";';
                    echo '</script>';
                    echo '</head>';
                } else {
                    echo '<head>';
                    echo '<script>';
                    echo 'alert("Data gagal diimport"); window.location.href="' . base_url('guru') . '";';
                    echo '</script>';
                    echo '</head>';
                }
            }
        }
    }
    public function export_guru()
    {
        $db = db_connect();
        $spreadsheet = new Spreadsheet();
        $query = $db->table('guru')
            ->select('guru.id, guru.nip, guru.first_name, guru.last_name, guru.email, guru.alamat, guru.no_telp')
            ->get()->getResult();
        $spreadsheet->setActiveSheetIndex(0);
        $spreadsheet->getActiveSheet()->setCellValue('A1', 'NIP');
        $spreadsheet->getActiveSheet()->setCellValue('B1', 'Nama Depan');
        $spreadsheet->getActiveSheet()->setCellValue('C1', 'Nama Belakang');
        $spreadsheet->getActiveSheet()->setCellValue('D1', 'Email');
        $spreadsheet->getActiveSheet()->setCellValue('E1', 'No Telp');
        $spreadsheet->getActiveSheet()->setCellValue('F1', 'Alamat');
        $i = 2;
        foreach ($query as $row) {
            $spreadsheet->getActiveSheet()->setCellValue('A' . $i, $row->nip);
            $spreadsheet->getActiveSheet()->setCellValue('B' . $i, $row->first_name);
            $spreadsheet->getActiveSheet()->setCellValue('C' . $i, $row->last_name);
            $spreadsheet->getActiveSheet()->setCellValue('D' . $i, $row->email);
            $spreadsheet->getActiveSheet()->setCellValue('E' . $i, $row->no_telp);
            $spreadsheet->getActiveSheet()->setCellValue('F' . $i, $row->alamat);
            $i++;
        }
        $writer = new Xlsx($spreadsheet);
        $filename = 'Data Guru.xlsx';
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        //$writer->save($filename);
        ob_end_clean();
        $writer->save('php://output');
        die();
    }
}
