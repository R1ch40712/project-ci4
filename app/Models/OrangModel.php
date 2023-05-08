<?php

namespace App\Models;

use CodeIgniter\Model;

class OrangModel extends Model
{
    protected $table = 'orang';
    protected $useTimestamps = true;
    // field yang diijinkan untuk input manual
    protected $allowedFields = ['nama', 'alamat'];

    public function search($keyword)
    {
        // $builder = $this->table('orang');
        // $builder->like('nama', $keyword);
        // return $builder;

        // versi lebih simple
        return $this->table('orang')->like('nama', $keyword)->orLike('alamat', $keyword);
    }
}
