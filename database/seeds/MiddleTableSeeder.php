<?php

use Illuminate\Database\Seeder;

class MiddleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Middle::create([
            'id' => 1,
            'name' => 'TV',
            'background_class' => 'bg-gradient-red',
            'icon' => 'fas fa-tv'
        ]);
        \App\Models\Middle::create([
            'id' => 2,
            'name' => 'Radio',
            'background_class' => 'bg-gradient-orange',
            'icon' => 'fas fa-broadcast-tower'
        ]);
        \App\Models\Middle::create([
            'id' => 3,
            'name' => 'Impresso',
            'background_class' => 'bg-gradient-green',
            'icon' => 'fas fa-print'
        ]);
        \App\Models\Middle::create([
            'id' => 4,
            'name' => 'Rede Social',
            'background_class' => 'bg-gradient-info',
            'icon' => 'ni ni-chart-bar-32'
        ]);
        \App\Models\Middle::create([
            'id' => 5,
            'name' => 'Site/Blog',
            'background_class' => 'bg-gradient-redes',
            'icon' => 'fas fa-network-wired'
        ]);
    }
}
