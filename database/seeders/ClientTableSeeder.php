<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ClientTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Client::create([
            'state_id' => 22,
            'city_id' => 3432,
            'name' => 'Maria Rosa',
            'logo' => 'logo.jpeg',
            'cnpj' => '1321382913',
            'contact' => 'Paulo Guedes',
            'email' => 'maria@maria.com',
            'password' => bcrypt('12345678'),
            'active' => true
        ]);
        \App\Models\Client::create([
            'state_id' => 22,
            'city_id' => 3112,
            'name' => 'Pedro Saraiva',
            'logo' => 'logo.jpeg',
            'cnpj' => '1321382913',
            'contact' => 'Paulo Guedes',
            'email' => 'pedro@pedro.com',
            'password' => bcrypt('12345678'),
            'active' => true
        ]);

    }
}
