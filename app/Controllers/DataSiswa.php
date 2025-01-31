<?php

namespace App\Controllers;

use App\Models\DataSiswaModel;
use Config\Services;
use PSpell\Config;

class DataSiswa extends BaseController
{
    protected $dataSiswaModel;
    public function __construct()
    {
        $this->dataSiswaModel = new DataSiswaModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Data Siswa',
            'siswa' => $this->dataSiswaModel->getSiswa()
        ];

        return view('dataSiswa/index', $data);
    }

    public function tambah()
    {
        $data = [
            'title' => 'Tambah Siswa',
            'validation' => \Config\Services::validation()
        ];

        return view('dataSiswa/tambah', $data);
    }

    public function simpan()
    {
        if (!$this->validate([
            'nis'           => 'required|is_unique[data_siswa.nis]',
            'nama_siswa'    => 'required',
            'tgl_lahir'     => 'required',
            'jns_kelamin'   => 'required',
            'alamat'        => 'required',
            'tahun_masuk'   => 'required'
        ])) {
            $validation = \Config\Services::validation();

            // dd($validation);

            return redirect()->to('/siswa/tambah')->withInput();
        }


        $this->dataSiswaModel->save([
            'nis'           => $this->request->getVar('nis'),
            'nama_siswa'    => $this->request->getVar('nama_siswa'),
            'tgl_lahir'     => $this->request->getVar('tgl_lahir'),
            'jns_kelamin'   => $this->request->getVar('jns_kelamin'),
            'alamat'        => $this->request->getVar('alamat'),
            'tahun_masuk'   => $this->request->getVar('tahun_masuk')
        ]);

        return redirect()->to('/siswa');
    }

    public function hapus()
    {
        $this->dataSiswaModel->delete($id = 'nis');

        return redirect()->to('/siswa');
    }
}
