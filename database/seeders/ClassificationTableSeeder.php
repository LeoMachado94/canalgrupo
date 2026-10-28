<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ClassificationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Classification::create([
            'id' => 1,
            'name' => 'Positiva',
        ]);
        \App\Models\Classification::create([
            'id' => 2,
            'name' => 'Favoravel',
        ]);
        \App\Models\Classification::create([
            'id' => 3,
            'name' => 'Negativa',
        ]);
        \App\Models\Classification::create([
            'id' => 4,
            'name' => 'Neutra',
        ]);
        \App\Models\Classification::create([
            'id' => 5,
            'name' => 'Informativa',
        ]);
        \App\Models\Classification::create([
            'id' => 6,
            'name' => 'Publicidade',
        ]);
        \App\Models\Classification::create([
            'id' => 7,
            'name' => 'Publicidade Legal',
        ]);
        \App\Models\Classification::create([
            'id' => 8,
            'name' => 'Comunicado',
        ]);
        \App\Models\Classification::create([
            'id' => 9,
            'name' => 'Testemunhal',
        ]);
        \App\Models\Classification::create([
            'id' => 10,
            'name' => 'Institucional',
        ]);
    }
}
