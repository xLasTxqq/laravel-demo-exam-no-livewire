<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        Category::create([
            'name'=>str()->random(16)
        ]);
        Role::create([
            'name'=>'user'
        ]);
        $id_admin=Role::create([
            'name'=>'admin'
        ]);
        User::create([
            'fullname'=>'admin',
            'login'=>'admin',
            'email'=>'admin',
            'password'=>bcrypt('adminWSR'),
            'role_id'=>$id_admin->id
        ]);
    }
}
