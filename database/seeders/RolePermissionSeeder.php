<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('role_has_permissions')->insert([
            // [
            //     'role_id'       => 2,
            //     'permission_id' => 1,
            //     'created_by'    => 1,
            //     'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
            // ],
            // [
            //     'role_id'       => 2,
            //     'permission_id' => 2,
            //     'created_by'    => 1,
            //     'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
            // ],
            // [
            //     'role_id'       => 2,
            //     'permission_id' => 3,
            //     'created_by'    => 1,
            //     'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
            // ],
            // [
            //     'role_id'       => 2,
            //     'permission_id' => 4,
            //     'created_by'    => 1,
            //     'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
            // ],
            // [
            //     'role_id'       => 2,
            //     'permission_id' => 5,
            //     'created_by'    => 1,
            //     'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
            // ],
            // [
            //     'role_id'       => 2,
            //     'permission_id' => 6,
            //     'created_by'    => 1,
            //     'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
            // ],
            // [
            //     'role_id'       => 2,
            //     'permission_id' => 7,
            //     'created_by'    => 1,
            //     'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
            // ],
            // [
            //     'role_id'       => 2,
            //     'permission_id' => 8,
            //     'created_by'    => 1,
            //     'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
            // ],
            // [
            //     'role_id'       => 2,
            //     'permission_id' => 9,
            //     'created_by'    => 1,
            //     'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
            // ]
        ]);

        $this->command->info('Roles has permissions berhasil disimpan');
    }
}
