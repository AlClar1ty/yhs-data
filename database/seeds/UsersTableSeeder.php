<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'email'  => 'master-admin@yhs.com',
	        'name'  => 'master-admin',
            'password'  => bcrypt('admin-yhs-surabaya-2024'),
		]);
    }
}
