<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ExhibitionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Exhibition::create([
            'id' => 1,
            'name' => 'Comentário',
        ]);
        \App\Models\Exhibition::create([
            'id' => 2,
            'name' => 'Entrevista',
        ]);
        \App\Models\Exhibition::create([
            'id' => 3,
            'name' => 'Manchete',
        ]);
        \App\Models\Exhibition::create([
            'id' => 4,
            'name' => 'Matéria',
        ]);
        \App\Models\Exhibition::create([
            'id' => 5,
            'name' => 'Nota',
        ]);
        \App\Models\Exhibition::create([
            'id' => 6,
            'name' => 'Nota Coberta',
        ]);
        \App\Models\Exhibition::create([
            'id' => 7,
            'name' => 'Nota Seca',
        ]);
        \App\Models\Exhibition::create([
            'id' => 8,
            'name' => 'Informativa',
        ]);
        \App\Models\Exhibition::create([
            'id' => 9,
            'name' => 'Publicidade',
        ]);
        \App\Models\Exhibition::create([
            'id' => 10,
            'name' => 'Publicidade Legal',
        ]);
        \App\Models\Exhibition::create([
            'id' => 11,
            'name' => 'Stand Up',
        ]);
        \App\Models\Exhibition::create([
            'id' => 12,
            'name' => 'Testemunhal',
        ]);
        \App\Models\Exhibition::create([
            'id' => 13,
            'name' => 'Comunicado',
        ]);
        \App\Models\Exhibition::create([
            'id' => 14,
            'name' => 'Notas/Fotos/Legendas',
        ]);
        \App\Models\Exhibition::create([
            'id' => 15,
            'name' => 'Ouvinte',
        ]);
        \App\Models\Exhibition::create([
            'id' => 16,
            'name' => 'Propaganda/Publicidade Legal',
        ]);
    }
}
