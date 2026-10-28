<?php

namespace Tests\Feature\Golden;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;

class CrudTest extends GoldenTestCase
{
    private $timestamps = ['created_at', 'updated_at'];

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('spaces');
        $this->actingAs($this->admin(), 'web');
    }

    public function test_clippings(): void
    {
        $base = [
            'client_id' => 1, 'title' => 'Nova matéria de teste', 'subject_matter_id' => 1, 'middle_id' => 1,
            'vehicle_id' => 1, 'editorial_id' => 1, 'classification_id' => 1, 'exhibition_id' => 1,
            'source_id' => 1, 'date' => '10/03/2026', 'review' => 'Resenha nova', 'is_favorite' => 0,
        ];

        $results = [
            'store_invalid' => $this->outcome($this->post('/clippings', ['title' => ''])),
            'store' => $this->outcome($this->post('/clippings', $base)),
            'store_same_title' => $this->outcome($this->post('/clippings', $base)),
            'update_create_action' => $this->outcome($this->put('/clippings/9', ['action' => 'create', 'review' => 'Revisada'])),
            'update' => $this->outcome($this->put('/clippings/2', ['title' => 'Título alterado', 'date' => '03/03/2026'])),
            'update_invalid' => $this->outcome($this->put('/clippings/2', ['date' => '2026-03-03'])),
        ];
        $results['table'] = $this->tableSnapshot('clippings', $this->timestamps);

        $this->assertGoldenJson('crud/clippings', $results);
    }

    public function test_clients(): void
    {
        $results = [
            'store_invalid' => $this->outcome($this->post('/clients', ['name' => 'Sem dados'])),
            'store' => $this->outcome($this->post('/clients', [
                'name' => 'Cliente Gama', 'cnpj' => '44.444.444/0001-44', 'contact' => 'Gil', 'email' => 'gama@golden.test',
                'password' => 'segredo123', 'state_id' => 1, 'city_id' => 2,
                'phones' => ['(41) 98888 7777', ''], 'emails' => ['extra@golden.test', 'invalido', ''],
                'logo' => UploadedFile::fake()->image('logo.png'),
            ])),
            'update' => $this->outcome($this->put('/clients/2', [
                'name' => 'Cliente Beta Alterado', 'phones' => ['(19) 3333 4444'], 'emails' => ['b2@golden.test'],
            ])),
        ];
        $results['clients'] = $this->tableSnapshot('clients', array_merge($this->timestamps, ['password']));
        $results['clients'] = array_map(function ($row) {
            $row['logo'] = $row['logo'] ? preg_replace('/avatar_\d+/', 'avatar_TIME', $row['logo']) : null;

            return $row;
        }, $results['clients']);
        $results['phones'] = $this->tableSnapshot('client_has_phones', $this->timestamps);
        $results['emails'] = $this->tableSnapshot('client_has_emails', $this->timestamps);
        $results['password_hashed'] = password_verify('segredo123', (string) \App\Models\Client::where('email', 'gama@golden.test')->value('password'));

        $this->assertGoldenJson('crud/clients', $results);
    }

    public function test_users(): void
    {
        $results = [
            'store_invalid' => $this->outcome($this->post('/users', ['email' => 'admin@golden.test'])),
            'store' => $this->outcome($this->post('/users', [
                'name' => 'Novo Usuário', 'email' => 'novo@golden.test', 'password' => 'segredo123',
            ])),
            'update' => $this->outcome($this->put('/users/2', ['name' => 'Monitor Renomeado'])),
            'update_duplicate_email' => $this->outcome($this->put('/users/2', ['email' => 'admin@golden.test'])),
        ];
        $results['users'] = $this->tableSnapshot('users', array_merge($this->timestamps, ['password', 'remember_token']));

        $this->assertGoldenJson('crud/users', $results);
    }

    public function test_vehicles_editorials_subjects(): void
    {
        $results = [
            'vehicle_store' => $this->outcome($this->post('/vehicles', ['state_id' => 1, 'city_id' => 1, 'middle_id' => 3, 'name' => 'Rádio Curitiba', 'description' => 'AM'])),
            'vehicle_store_invalid' => $this->outcome($this->post('/vehicles', ['name' => 'X'])),
            'vehicle_update' => $this->outcome($this->put('/vehicles/2', ['name' => 'TV Campinas HD'])),
            'editorial_store' => $this->outcome($this->post('/editorials', ['vehicle_id' => 1, 'title' => 'Esportes', 'hour' => '12:15'])),
            'editorial_store_invalid' => $this->outcome($this->post('/editorials', ['vehicle_id' => 1, 'title' => 'Esportes', 'hour' => '12h'])),
            'editorial_update' => $this->outcome($this->put('/editorials/1', ['title' => 'Política Nacional'])),
            'subject_store' => $this->outcome($this->post('/subjects', ['client_id' => 2, 'title' => 'Segurança'])),
            'subject_store_duplicate' => $this->outcome($this->post('/subjects', ['client_id' => 1, 'title' => 'Saúde'])),
            'subject_update' => $this->outcome($this->put('/subjects/3', ['title' => 'Obras Públicas'])),
        ];
        $results['vehicles'] = $this->tableSnapshot('vehicles', $this->timestamps);
        $results['editorials'] = $this->tableSnapshot('editorials', $this->timestamps);
        $results['subjects'] = $this->tableSnapshot('subject_matters', $this->timestamps);

        $this->assertGoldenJson('crud/vehicles_editorials_subjects', $results);
    }

    public function test_summaries(): void
    {
        $dir = public_path('assets/files/summaries');
        $before = is_dir($dir) ? scandir($dir) : [];

        $results = [
            'store_invalid' => $this->outcome($this->post('/summaries', ['client_id' => 1, 'title' => 'Sem arquivo', 'date' => '01/03/2026'])),
            'store' => $this->outcome($this->post('/summaries', [
                'client_id' => 1, 'title' => 'Resumo Março', 'date' => '01/03/2026',
                'file' => UploadedFile::fake()->create('resumo.pdf', 5, 'application/pdf'),
            ])),
            'update' => $this->outcome($this->put('/summaries/1', ['title' => 'Resumo Fev Revisado', 'date' => '27/02/2026'])),
        ];
        $results['summaries'] = array_map(function ($row) {
            $row['file'] = preg_replace('/summaries\/[0-9a-f]{13}\.pdf$/', 'summaries/UNIQID.pdf', $row['file']);

            return $row;
        }, $this->tableSnapshot('summaries', $this->timestamps));

        foreach (array_diff(is_dir($dir) ? scandir($dir) : [], $before, ['.', '..']) as $created) {
            unlink($dir.'/'.$created);
        }

        $this->assertGoldenJson('crud/summaries', $results);
    }

    private function outcome($response): array
    {
        $session = app('session.store');
        $errors = $session ? $session->get('errors') : null;

        return [
            'status' => $response->getStatusCode(),
            'location' => $response->headers->get('Location'),
            'flash' => $session ? Arr::only($session->all(), ['success', 'title', 'message', 'icon']) : [],
            'errors' => $errors ? $errors->getBag('default')->toArray() : [],
        ];
    }
}
