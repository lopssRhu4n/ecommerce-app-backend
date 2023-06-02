<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ClientAddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\ClientAddress::factory(10)->create();
    }
}
