<?php

use App\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::find(1000);
        if (!$user) {
            User::create([
                'id' => 1000,
                'name' => 'Admin',
                'email' => 'admin@gmail.com',
                'password' => bcrypt('admin')
            ]);
        }
    }
}
