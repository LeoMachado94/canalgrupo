<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SubjectMatterTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\SubjectMatter::create([
            'client_id' => 1,
            'user_id' => 1,
            'title' => 'Assunto Um',
            'date' => '2020-01-01',
        ]);
        \App\Models\SubjectMatter::create([
            'client_id' => 1,
            'user_id' => 2,
            'title' => 'Assunto Dois',
            'date' => '2020-02-01',
        ]);
    }
}
