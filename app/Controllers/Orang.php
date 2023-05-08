<?php

namespace App\Controllers;

use App\Models\OrangModel;

class Orang extends BaseController
{
    protected $orangModel;
    public function __construct()
    {
        $this->orangModel = new OrangModel();
    }

    public function index()
    {
        $currrentPage = $this->request->getVar('page_orang') ? $this->request->getVar('page_orang') : 1;
        // d($this->request->getVar('keyword'));

        $keyword = $this->request->getVar('keyword');
        if ($keyword) {
            $this->orangModel->search($keyword);
        } else {
            $orang = $this->orangModel;
        }

        $data = [
            'judul' => 'Daftar Orang',
            // 'orang' => $this->orangModel->findAll()
            'orang' => $orang->paginate(6, 'orang'),
            'pager' => $this->orangModel->pager,
            'currentPage' => $currrentPage
        ];
        return view('orang/index', $data);
    }
}
