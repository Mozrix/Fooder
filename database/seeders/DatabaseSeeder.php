<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Kategori;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $akun = [
            [
                'nama' => 'Admin Fooder',
                'email' => 'admin@fooder.test',
                'role' => 'admin',
            ],
            [
                'nama' => 'Seller Fooder',
                'email' => 'seller@fooder.test',
                'role' => 'seller',
            ],
            [
                'nama' => 'Customer Fooder',
                'email' => 'customer@fooder.test',
                'role' => 'customer',
            ],
        ];

        $seller = null;

        foreach ($akun as $data) {
            $user = User::updateOrCreate(
                ['email' => $data['email']],
                [
                    'nama' => $data['nama'],
                    'role' => $data['role'],
                    'password' => 'password',
                ]
            );

            if ($data['role'] === 'seller') {
                $seller = $user;
            }
        }

        $seller->toko()->firstOrCreate([], [
            'nama_toko' => 'Toko Seller Fooder',
            'deskripsi' => 'Toko contoh untuk pengembangan.',
        ]);

        $kategori = [
            ['nama_kategori' => 'Makanan'],
            ['nama_kategori' => 'Minuman'],
            ['nama_kategori' => 'Cemilan'],
        ];

        foreach ($kategori as $data) {
            Kategori::updateOrCreate(
                ['nama_kategori' => $data['nama_kategori']],
                $data
            );
        }
    }
}