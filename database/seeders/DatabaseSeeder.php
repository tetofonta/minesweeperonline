<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Game;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(150)->create()->each(function ($e){
            Game::factory(32)->create(["user_id" => $e]);
        });

        User::factory(1)->admin()->create(['id' => 'admin@localhost.local', 'username' => 'admin', 'created_at' => now()]);

    }
}
