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
            'email'  => 'master2-admin@yhs.com',
	        'name'  => 'master-admin',
            'password'  => bcrypt('YHSsby007'),
		]);
    }
}
