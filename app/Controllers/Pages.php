<?php

namespace App\Controllers;


class Pages extends BaseController
{
    public function index()
    {
        // $faker = \Faker\Factory::create();
        // dd($faker->address);

        $data['judul'] = 'Home';
        return view('pages/home', $data);
    }
    public function about()
    {
        $data['judul'] = 'About';
        return view('pages/about', $data);
    }
    public function contact()
    {
        $data = [
            'judul' => 'Contact Us',
            'alamat' => [
                [
                    'tipe' => 'Rumah',
                    'alamat' => 'JL.abc No.123',
                    'kota' => 'Malang',
                ],
                [
                    'tipe' => 'Kantor',
                    'alamat' => 'JL.bca No.321',
                    'kota' => 'Malang',

                ]
            ]
        ];
        return view('pages/contact', $data);
    }
}
