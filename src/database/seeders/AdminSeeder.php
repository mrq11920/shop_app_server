<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->updateOrInsert([
            'id' => 1,
        ],[
            'email' => 'quangnm@gmail.com',
            'password' => bcrypt('quangnm'),
            'role' => config('user.roles.admin'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
