<?php

namespace App\Controllers;

use App\Models\KomikModel;

class Komik extends BaseController
{
    protected $komikModel;
    protected $helpers = ['form'];

    public function __construct()
    {
        $this->komikModel = new KomikModel();
    }

    public function index()
    {
        // cara konek db tanpa model
        // $db = \Config\Database::connect();
        // $komik = $db->query('SELECT * from komik');
        // dd($komik);
        // foreach ($komik->getResultArray() as $row) {
        //     d($row);
        // }
        // $komik = $this->komikModel->findAll();
        $data = [
            'judul' => 'Daftar Komik',
            'komik' => $this->komikModel->getKomik()
        ];
        return view('komik/index', $data);
    }
    public function detail($slug)
    {
        $data = [
            'judul' => 'Detail komik',
            'komik' => $this->komikModel->getKomik($slug)
        ];

        // jika komik tidak ada di tabel
        if (empty($data['komik'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Judul komik ' . $slug . ' tidak ditemukan');
        }
        return view('komik/detail', $data);
    }
    public function create()
    {
        // session();
        $data = [
            'judul' => 'Form Tambah Data Komik',
            'validation' => \Config\Services::validation()
        ];
        return view('komik/create', $data);
    }
    public function save()
    {
        // getVar untuk mengambil apapun get/post bisa
        // dd($this->request->getVar());
        // url_title membuat string menjadi huruf kecil semua dan spasi hilang

        // validasi input
        if (!$this->validate([
            'judul' => [
                'rules' => 'required|is_unique[komik.judul]',
                'errors' => [
                    'required' => '{field} komik harus di isi!',
                    'is_unique' => '{field} komik telah tersedia.'
                ]
            ],
            'penulis' => [
                'rules' => 'alpha|max_length[50]',
                'errors' => [
                    'alpha' => 'karakter {field} yang diijinkan hanya alphabet!',
                    'max_length' => 'karakter {field} tidak boleh lebih dari 50'
                ]
            ],
            'sampul' => [
                'rules' => 'max_size[sampul,1024]|is_image[sampul]|mime_in[sampul,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'max_size' => 'Ukuran gambar terlalu besar',
                    'is_image' => 'yang anda pilih bukan gambar',
                    'mime_in' => 'yang anda pilih bukan gambar',
                ]
            ]
        ])) {
            // mengambil pesan kesalahan
            // $validation = \Config\Services::validation();
            // dd($validation);
            // return redirect()->to('/komik/create')->withInput()->with('validation', $validation);
            return redirect()->to('/komik/create')->withInput();
        }

        // ambil gambar
        $filesampul = $this->request->getFile('sampul');
        // mengecek apakah tidak ada file gambar yang di upload
        if ($filesampul->getError() == 4) {
            $namasampul = 'default.png';
        } else {
            // generate nama sampul random
            $namasampul = $filesampul->getRandomName();
            // pindahkan file ke folder image
            $filesampul->move('assets/image', $namasampul);
            // ambil nama file sampul
            // $namasampul = $filesampul->getName();
        }

        $slug = mb_url_title($this->request->getVar('judul'), '-', true);
        $this->komikModel->save([
            'judul' => $this->request->getVar('judul'),
            'slug' => $slug,
            'penulis' => $this->request->getVar('penulis'),
            'penerbit' => $this->request->getVar('penerbit'),
            'sampul' => $namasampul,
        ]);

        session()->setFlashdata('pesan', 'Data berhasil ditambahkan');
        return redirect()->to('/komik');
    }
    public function delete($id)
    {
        // cri gambar berdasarkan id
        $komik = $this->komikModel->find($id);
        // cek jika file gambar default
        if ($komik['sampul'] != 'default.png') {
            // hapus gambar
            unlink('assets/image/' . $komik['sampul']);
        }


        $this->komikModel->delete($id);
        session()->setFlashdata('pesan', 'Data berhasil dihapus');
        return redirect()->to('/komik');
    }
    public function edit($slug)
    {
        $data = [
            'judul' => 'Form Ubah Data Komik',
            'validation' => \Config\Services::validation(),
            'komik' => $this->komikModel->getKomik($slug)
        ];
        return view('komik/update', $data);
    }
    public function update($id)
    {
        // cek judul
        $oldKomik = $this->komikModel->getKomik($this->request->getVar('slug'));
        if ($oldKomik['judul'] == $this->request->getVar('judul')) {
            $rule_judul = 'required';
        } else {
            $rule_judul = 'required|is_unique[komik.judul]';
        }
        if (!$this->validate([
            'judul' => [
                'rules' => $rule_judul,
                'errors' => [
                    'required' => '{field} judul komik harus di isi!',
                    'is_unique' => '{field} Judul komik telah tersedia.'
                ]
            ],
            'sampul' => [
                'rules' => 'max_size[sampul,1024]|is_image[sampul]|mime_in[sampul,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'max_size' => 'Ukuran gambar terlalu besar',
                    'is_image' => 'yang anda pilih bukan gambar',
                    'mime_in' => 'yang anda pilih bukan gambar',
                ]
            ]

        ])) {
            // mengambil pesan kesalahan
            // $validation = \Config\Services::validation();
            return redirect()->to('/komik/edit/' . $this->request->getVar('slug'))->withInput();
        }

        $fileSampul = $this->request->getFile('sampul');

        // cek gambar,apakah tetap gambar lama 
        if ($fileSampul->getError() == 4) {
            $namaSampul = $this->request->getVar('sampulLama');
        } else {
            // generate nama file random
            $namaSampul = $fileSampul->getRandomName();
            // pindahkan gambar
            $fileSampul->move('assets/image', $namaSampul);
            // hapus file yang lama
            unlink('assets/image' . $this->request->getVar('sampulLama'));
        }

        $slug = mb_url_title($this->request->getVar('judul'), '-', true);
        $this->komikModel->save([
            'id' => $id,
            'judul' => $this->request->getVar('judul'),
            'slug' => $slug,
            'penulis' => $this->request->getVar('penulis'),
            'penerbit' => $this->request->getVar('penerbit'),
            'sampul' => $namaSampul,
        ]);

        session()->setFlashdata('pesan', 'Data berhasil diubah');
        return redirect()->to('/komik');
    }
}
