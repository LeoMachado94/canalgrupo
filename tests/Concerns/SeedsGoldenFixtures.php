<?php

namespace Tests\Concerns;

use App\Models\Client;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

trait SeedsGoldenFixtures
{
    protected $now = '2026-03-15 10:00:00';

    protected function seedGoldenFixtures(): void
    {
        Carbon::setTestNow(Carbon::parse($this->now));

        $ts = ['created_at' => '2026-01-10 08:30:00', 'updated_at' => '2026-01-11 09:45:00'];
        // Password hash for "password", fixed so it is identical across versions.
        $password = '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi';

        DB::table('states')->insert([
            ['id' => 1, 'title' => 'Paraná', 'letter' => 'PR', 'iso' => 41, 'slug' => 'parana', 'population' => 11000000],
            ['id' => 2, 'title' => 'São Paulo', 'letter' => 'SP', 'iso' => 35, 'slug' => 'sao-paulo', 'population' => 46000000],
        ]);
        DB::table('cities')->insert([
            ['id' => 1, 'state_id' => 1, 'title' => 'Curitiba', 'iso' => 4106902, 'iso_ddd' => 41, 'status' => 1, 'slug' => 'curitiba', 'population' => 1900000, 'lat' => -25.42, 'long' => -49.27, 'income_per_capita' => 1500.50],
            ['id' => 2, 'state_id' => 1, 'title' => 'Londrina', 'iso' => 4113700, 'iso_ddd' => 43, 'status' => 1, 'slug' => 'londrina', 'population' => 575000, 'lat' => -23.31, 'long' => -51.16, 'income_per_capita' => 1300.10],
            ['id' => 3, 'state_id' => 2, 'title' => 'Campinas', 'iso' => 3509502, 'iso_ddd' => 19, 'status' => 1, 'slug' => 'campinas', 'population' => 1200000, 'lat' => -22.90, 'long' => -47.06, 'income_per_capita' => 1700.00],
        ]);

        DB::table('users')->insert([
            ['id' => 1, 'name' => 'Admin Golden', 'email' => 'admin@golden.test', 'password' => $password, 'active' => 1, 'avatar' => null, 'access_level' => 1, 'remember_token' => null] + $ts,
            ['id' => 2, 'name' => 'Monitor Golden', 'email' => 'monitor@golden.test', 'password' => $password, 'active' => 1, 'avatar' => 'users/avatars/avatar_1.png', 'access_level' => 3, 'remember_token' => null] + $ts,
        ]);

        DB::table('clients')->insert([
            ['id' => 1, 'state_id' => 1, 'city_id' => 1, 'user_id' => 1, 'name' => 'Cliente Alfa', 'logo' => 'clients/avatars/avatar_1.png', 'cnpj' => '11.111.111/0001-11', 'contact' => 'Ana', 'email' => 'alfa@golden.test', 'password' => $password, 'active' => 1, 'remember_token' => null] + $ts,
            ['id' => 2, 'state_id' => 2, 'city_id' => 3, 'user_id' => 1, 'name' => 'Cliente Beta', 'logo' => null, 'cnpj' => '22.222.222/0001-22', 'contact' => 'Bruno', 'email' => 'beta@golden.test', 'password' => $password, 'active' => 1, 'remember_token' => null] + $ts,
            ['id' => 3, 'state_id' => null, 'city_id' => null, 'user_id' => null, 'name' => 'Cliente Inativo', 'logo' => null, 'cnpj' => '33.333.333/0001-33', 'contact' => null, 'email' => null, 'password' => null, 'active' => 0, 'remember_token' => null] + $ts,
        ]);
        DB::table('client_has_phones')->insert([
            ['id' => 1, 'client_id' => 1, 'phone_number' => '41999990000'] + $ts,
            ['id' => 2, 'client_id' => 1, 'phone_number' => '4133330000'] + $ts,
        ]);
        DB::table('client_has_emails')->insert([
            ['id' => 1, 'client_id' => 1, 'email' => 'copia@golden.test'] + $ts,
        ]);

        DB::table('middles')->insert([
            ['id' => 1, 'name' => 'Impresso', 'icon' => 'fa-newspaper', 'background_class' => 'bg-blue'] + $ts,
            ['id' => 2, 'name' => 'TV', 'icon' => 'fa-tv', 'background_class' => 'bg-green'] + $ts,
            ['id' => 3, 'name' => 'Rádio', 'icon' => 'fa-radio', 'background_class' => 'bg-yellow'] + $ts,
        ]);
        DB::table('classifications')->insert([
            ['id' => 1, 'name' => 'Positiva', 'active' => 1] + $ts,
            ['id' => 2, 'name' => 'Indefinida', 'active' => 1] + $ts,
            ['id' => 3, 'name' => 'Negativa', 'active' => 1] + $ts,
            ['id' => 4, 'name' => 'Neutra', 'active' => 1] + $ts,
        ]);
        DB::table('exhibitions')->insert([
            ['id' => 1, 'name' => 'Capa', 'active' => 1] + $ts,
            ['id' => 2, 'name' => 'Interna', 'active' => 1] + $ts,
        ]);
        DB::table('sources')->insert([
            ['id' => 1, 'name' => 'Espontânea', 'active' => 1] + $ts,
            ['id' => 2, 'name' => 'Release', 'active' => 1] + $ts,
        ]);

        DB::table('vehicles')->insert([
            ['id' => 1, 'state_id' => 1, 'city_id' => 1, 'middle_id' => 1, 'name' => 'Gazeta', 'description' => 'Jornal diário', 'active' => 1] + $ts,
            ['id' => 2, 'state_id' => 2, 'city_id' => 3, 'middle_id' => 2, 'name' => 'TV Campinas', 'description' => null, 'active' => 1] + $ts,
        ]);
        DB::table('editorials')->insert([
            ['id' => 1, 'vehicle_id' => 1, 'title' => 'Política', 'hour' => '07:30:00', 'responsible' => 'Carla', 'description' => 'Caderno A', 'active' => 1] + $ts,
            ['id' => 2, 'vehicle_id' => 2, 'title' => 'Jornal da Noite', 'hour' => null, 'responsible' => null, 'description' => null, 'active' => 1] + $ts,
        ]);
        DB::table('subject_matters')->insert([
            ['id' => 1, 'client_id' => 1, 'user_id' => 1, 'title' => 'Saúde', 'active' => 1] + $ts,
            ['id' => 2, 'client_id' => 1, 'user_id' => 1, 'title' => 'Educação', 'active' => 1] + $ts,
            ['id' => 3, 'client_id' => 2, 'user_id' => 2, 'title' => 'Obras', 'active' => 1] + $ts,
        ]);
        DB::table('summaries')->insert([
            ['id' => 1, 'client_id' => 1, 'title' => 'Resumo Fevereiro', 'date' => '2026-02-28', 'file' => 'assets/files/summaries/resumo.pdf', 'active' => 1] + $ts,
        ]);

        $clippings = [
            // id, client, middle, subject, vehicle, editorial, user, classification, exhibition, source, date, favorite, last_read
            [1, 1, 1, 1, 1, 1, 1, 1, 1, 1, '2026-03-14', 1, null],
            [2, 1, 1, 2, 1, 1, 1, 3, 2, 2, '2026-03-02', 0, '2026-03-05 14:20:00'],
            [3, 1, 2, 1, 2, 2, 2, 4, 1, null, '2026-02-20', 1, null],
            [4, 2, 2, 3, 2, 2, 2, 1, 2, 1, '2026-02-10', 0, null],
            [5, 1, 3, 2, 1, 1, 1, 2, 1, 2, '2026-01-05', 0, null],
            [6, 2, 1, 3, 1, 1, 1, 4, 2, 1, '2025-11-18', 1, null],
            [7, 1, 1, 1, 1, 1, 2, 1, 1, 1, '2025-10-01', 0, null],
            [8, 1, 1, 1, 1, 1, 1, 3, 1, 1, '2026-03-15', 1, null],
        ];
        foreach ($clippings as $i => $c) {
            DB::table('clippings')->insert([
                'id' => $c[0], 'client_id' => $c[1], 'middle_id' => $c[2], 'subject_matter_id' => $c[3],
                'vehicle_id' => $c[4], 'editorial_id' => $c[5], 'user_id' => $c[6], 'classification_id' => $c[7],
                'exhibition_id' => $c[8], 'source_id' => $c[9], 'title' => "Matéria golden {$c[0]}",
                'slug' => "materia-golden-{$c[0]}", 'date' => $c[10], 'last_read' => $c[12],
                'review' => "<p>Resenha da matéria {$c[0]} com acentuação: ção, ã, é.</p>", 'active' => 1,
                'is_favorite' => $c[11],
                'created_at' => sprintf('2026-01-%02d 10:%02d:00', 10 + $i, $i), 'updated_at' => '2026-01-20 12:00:00',
            ]);
        }

        DB::table('clipping_has_files')->insert([
            ['id' => 1, 'clipping_id' => 1, 'name' => 'foto_1.jpg', 'path' => 'clippings/1/foto_1.jpg', 'file_type' => null, 'extension' => 'jpg', 'size' => null] + $ts,
            ['id' => 2, 'clipping_id' => 1, 'name' => 'video_1.mp4', 'path' => 'clippings/1/video_1.mp4', 'file_type' => null, 'extension' => 'mp4', 'size' => null] + $ts,
            ['id' => 3, 'clipping_id' => 1, 'name' => 'audio_1.mp3', 'path' => 'clippings/1/audio_1.mp3', 'file_type' => null, 'extension' => 'mp3', 'size' => null] + $ts,
            ['id' => 4, 'clipping_id' => 1, 'name' => 'doc_1.pdf', 'path' => 'clippings/1/doc_1.pdf', 'file_type' => null, 'extension' => 'pdf', 'size' => null] + $ts,
            ['id' => 5, 'clipping_id' => 2, 'name' => 'arquivo.zip', 'path' => 'clippings/2/arquivo.zip', 'file_type' => null, 'extension' => 'zip', 'size' => null] + $ts,
        ]);
    }

    protected function admin(): User
    {
        return User::find(1);
    }

    protected function client(): Client
    {
        return Client::find(1);
    }

    protected function tableSnapshot(string $table, array $except = []): array
    {
        return DB::table($table)->orderBy('id')->get()->map(function ($row) use ($except) {
            return array_diff_key((array) $row, array_flip($except));
        })->all();
    }
}
