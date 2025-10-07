<?php

use Illuminate\Database\Seeder;

class SourceTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Source::create([
            'id' => 1,
            'name' => 'Espontânea',
        ]);
        \App\Models\Source::create([
            'id' => 2,
            'name' => 'Gerada',
        ]);
        \App\Models\Source::create([
            'id' => 3,
            'name' => 'Mista',
        ]);
    }
}
