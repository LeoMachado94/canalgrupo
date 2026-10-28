<?php

namespace Database\Seeders;

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
        //$this->call(UserTableSeeder::class);
        $this->call(StateTableSeeder::class);
        $this->call(CityTableSeeder::class);
        $this->call(MiddleTableSeeder::class);
//        $this->call(ClientTableSeeder::class);
//        $this->call(SubjectMatterTableSeeder::class);
        $this->call(ClassificationTableSeeder::class);
        $this->call(ExhibitionTableSeeder::class);
        $this->call(SourceTableSeeder::class);
    }
}
