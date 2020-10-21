<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'name'          => 'Ripan',
                'username'      => 'dev',
                'email'         => 'ripanmajid13@gmail.com',
                'password'      => Hash::make('48691412'),
                'created_by'    => 1,
                'updated_by'    => 1,
                'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'    => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'name'          => 'Admin',
                'username'      => 'admin',
                'email'         => 'admin@gmail.com',
                'password'      => Hash::make('password'),
                'created_by'    => 1,
                'updated_by'    => 1,
                'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'    => Carbon::now()->format('Y-m-d H:i:s'),
            ],
        ]);

        $this->command->info('Users berhasil disimpan');
    }
}
