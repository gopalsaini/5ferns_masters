<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Ranium\SeedOnce\Traits\SeedOnce;

class User extends Seeder
{
    use SeedOnce;
    
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
		
        $user = [
            ['name' => 'admin','email' => 'admin@gmail.com','password'=>\Hash::make('admin')]
		];
		 
		\App\Models\User::insert($user);
    }
}
