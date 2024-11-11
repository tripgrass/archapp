<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $adminRole = Role::create(['name' => 'admin']);
        $authorRole = Role::create(['name' => 'author']);
        $viewerRole = Role::create(['name' => 'viewer']);


//        $userAdmin->assignRole($adminRole);
  //      $userAuthor->assignRole($authorRole);
    //    $userViewer->assignRole($viewerRole);
    }
}
