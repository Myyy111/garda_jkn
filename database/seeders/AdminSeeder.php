<?php

namespace Database\Seeders;

use App\Models\AdminUser;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        AdminUser::updateOrCreate(
            ['username' => 'admin'],
            [
                'password' => 'password',
                'name' => 'Administrator',
                'role' => 'administrator',
            ]
        );

        \App\Models\BpjsKeliling::firstOrCreate(
            ['title' => 'Layanan Desa Bumiharjo'],
            [
                'description' => 'Kecamatan Keling, Jepara. Fokus pendaftaran peserta baru.',
                'event_date' => '2026-04-12',
                'location' => 'Balai Desa Bumiharjo',
                'staff_count' => 2,
                'status' => 'scheduled',
            ]
        );

        \App\Models\BpjsKeliling::firstOrCreate(
            ['title' => 'Sosialisasi JKN Mobile'],
            [
                'description' => 'Pasar Bangsri. Edukasi penggunaan aplikasi JKN Mobile.',
                'event_date' => '2026-04-15',
                'location' => 'Pasar Bangsri, Jepara',
                'staff_count' => 3,
                'status' => 'scheduled',
            ]
        );
    }
}
