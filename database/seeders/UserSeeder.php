<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Akun awal. "legacy_email" = email lama dari versi sebelumnya; jika akun lama
     * itu masih ada, akun tersebut diperbarui (bukan dibuat akun baru yang dobel).
     */
    private const ACCOUNTS = [
        [
            'email' => 'admin@gmail.com',
            'legacy_email' => 'admin@ptxyz.com',
            'name' => 'Administrator',
            'role' => User::ROLE_ADMIN,
        ],
        [
            'email' => 'asesor@gmail.com',
            'legacy_email' => 'asesor@ptxyz.com',
            'name' => 'Asesor',
            'role' => User::ROLE_ASESOR,
        ],
    ];

    public function run(): void
    {
        foreach (self::ACCOUNTS as $account) {
            $user = User::where('email', $account['email'])->first()
                ?? User::where('email', $account['legacy_email'])->first();

            if ($user) {
                // Akun sudah ada: perbarui email, nama, dan role. Password tidak diubah.
                $user->update([
                    'email' => $account['email'],
                    'name' => $account['name'],
                    'role' => $account['role'],
                ]);

                continue;
            }

            User::create([
                'email' => $account['email'],
                'name' => $account['name'],
                'role' => $account['role'],
                'password' => 'password',
            ]);
        }
    }
}
