<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Llama a los seeders aquí
        $this->call(UserSeeders::class);
        $this->call(EspecialidadSeeders::class);
        $this->call(DepartamentoSeeders::class);
    }
}

