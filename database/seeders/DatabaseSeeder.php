<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $prod = [
            TenantSeeder::class,
            UserSeeder::class,
        ];

        $dev = [
            ...$prod
        ];

        $this->call(app()->environment(['local', 'homolog']) ? $dev : $prod);
    }
}
