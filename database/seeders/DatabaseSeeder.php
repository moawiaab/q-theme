<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\AssetType;
use App\Models\User;
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
        $this->call([
            AccountSeeder::class,
            PermissionSeeder::class,
            PermissionRoleTableSeeder::class,
        ]);
        User::factory(100)->create([
            'account_id' => 1,
            'role_id' => 2,
        ]);
    }
}
