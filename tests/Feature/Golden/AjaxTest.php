<?php

namespace Tests\Feature\Golden;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AjaxTest extends GoldenTestCase
{
    private $dataTablesQuery = 'draw=1&start=0&length=10';

    public function test_admin_get_endpoints(): void
    {
        $this->actingAs($this->admin(), 'web');

        $endpoints = [
            'clippings' => '/ajax/clippings?client_id=1',
            'clippings_all' => '/ajax/clippings',
            'clippings_filtered' => '/ajax/clippings?middle_id=1&classification_id=1&start_date=01/03/2026&end_date=15/03/2026&title=golden',
            'clippings_dt' => '/ajax/clippings?'.$this->dataTablesQuery,
            'favorites' => '/ajax/favorites',
            'favorites_range' => '/ajax/favorites?start_date=01/01/2025&end_date=31/12/2026',
            'clients' => '/ajax/clients',
            'clients_lists' => '/ajax/lists/clients',
            'users' => '/ajax/users',
            'users_lists' => '/ajax/lists/users',
            'editorials' => '/ajax/editorials',
            'editorials_lists' => '/ajax/lists/editorials',
            'subjects_lists' => '/ajax/lists/subjects?client_id=1&search=Sa',
            'summaries' => '/ajax/summaries',
            'vehicles' => '/ajax/vehicles',
            'vehicles_lists' => '/ajax/lists/vehicles',
            'states' => '/ajax/lists/states',
            'cities' => '/ajax/lists/cities',
            'cities_state' => '/ajax/lists/cities/1',
            'middles' => '/ajax/lists/middles',
            'classifications' => '/ajax/lists/classifications',
            'exhibitions' => '/ajax/lists/exhibitions',
            'sources' => '/ajax/lists/sources',
        ];

        foreach ($endpoints as $name => $uri) {
            $response = $this->get($uri, ['X-Requested-With' => 'XMLHttpRequest']);
            $this->assertSame(200, $response->getStatusCode(), "GET {$uri}");
            $this->assertGoldenJson("ajax/admin_{$name}", $response->getContent());
        }
    }

    public function test_client_get_endpoints(): void
    {
        $this->actingAs($this->client(), 'client');

        foreach ([
            'clippings' => '/ajax/clippings?'.$this->dataTablesQuery,
            'favorites' => '/ajax/favorites?start_date=01/01/2025&end_date=31/12/2026&'.$this->dataTablesQuery,
        ] as $name => $uri) {
            $response = $this->get($uri, ['X-Requested-With' => 'XMLHttpRequest']);
            $this->assertSame(200, $response->getStatusCode(), "GET {$uri}");
            $this->assertGoldenJson("ajax/client_{$name}", $response->getContent());
        }
    }

    public function test_cors_headers(): void
    {
        $this->actingAs($this->admin(), 'web');

        $response = $this->get('/ajax/lists/middles');
        $ajax = Arr::only($response->headers->all(), [
            'access-control-allow-origin', 'access-control-allow-methods', 'access-control-allow-headers',
        ]);
        ksort($ajax);

        $page = Arr::only($this->get('/clients')->headers->all(), [
            'access-control-allow-origin', 'access-control-allow-methods', 'access-control-allow-headers',
        ]);

        $this->assertGoldenJson('ajax/cors_headers', ['ajax' => $ajax, 'page' => $page]);
    }

    public function test_graphs_data(): void
    {
        $this->actingAs($this->admin(), 'web');

        $results = [
            'missing' => $this->postJson('/ajax/report/graphsData', ['client_id' => 1])->json(),
            'full' => $this->postJson('/ajax/report/graphsData', [
                'client_id' => 1, 'middle_id' => 1, 'start_date' => '01/01/2025', 'end_date' => '31/12/2026',
            ])->json(),
            'filtered' => $this->postJson('/ajax/report/graphsData', [
                'client_id' => 1, 'middle_id' => 1, 'start_date' => '01/01/2025', 'end_date' => '31/12/2026',
                'classification_id' => 1, 'title' => 'Saúde',
            ])->json(),
        ];

        $this->assertGoldenJson('ajax/graphs_data', $results);
    }

    public function test_subject_store_and_deletes(): void
    {
        $this->actingAs($this->admin(), 'web');

        $results = [
            'subject_store' => $this->postJson('/ajax/subjects/create', ['client_id' => 2, 'title' => 'Turismo'])->json(),
            'subject_store_invalid' => $this->postJson('/ajax/subjects/create', ['title' => ''])->json(),
            'clipping_destroy' => $this->deleteJson('/ajax/clippings/7')->json(),
            'clipping_destroy_missing' => $this->deleteJson('/ajax/clippings/999')->json(),
            'summary_destroy' => $this->deleteJson('/ajax/summaries/1')->json(),
            'vehicle_destroy_missing' => $this->deleteJson('/ajax/vehicles/999')->json(),
            'editorial_destroy' => $this->deleteJson('/ajax/editorials/2')->json(),
            'user_destroy_missing' => $this->deleteJson('/ajax/users/999')->json(),
            'client_destroy_missing' => $this->deleteJson('/ajax/clients/999')->json(),
            'subject_destroy_missing' => $this->deleteJson('/ajax/subjects/999')->json(),
        ];

        $results['subjects_table'] = $this->tableSnapshot('subject_matters', ['created_at', 'updated_at']);
        $results['clipping_ids'] = DB::table('clippings')->orderBy('id')->pluck('id')->all();

        $this->assertGoldenJson('ajax/mutations', $results);
    }

    public function test_uploads(): void
    {
        Storage::fake('spaces');
        Storage::fake('public');
        $this->actingAs($this->admin(), 'web');

        $store = $this->postJson('/ajax/clippings/upload', [
            'clipping_id' => 2,
            'file' => UploadedFile::fake()->create('materia.pdf', 10),
        ]);
        $stored = $store->json();
        $path = Arr::get($stored, 'file.path');
        Storage::disk('spaces')->assertExists($path);

        $normalize = function ($value) use (&$normalize) {
            if (is_array($value)) {
                return array_map($normalize, $value);
            }

            return is_string($value) ? preg_replace('/_\d{10}\./', '_TIME.', $value) : $value;
        };
        Arr::forget($stored, ['file.created_at', 'file.updated_at']);
        $stored = $normalize($stored);

        $results = [
            'store' => $stored,
            'store_invalid' => $this->postJson('/ajax/clippings/upload', ['clipping_id' => 999])->getStatusCode(),
            'destroy' => $this->deleteJson('/ajax/clippings/upload/remove/5')->json(),
            'destroy_missing' => $this->deleteJson('/ajax/clippings/upload/remove/999')->json(),
            'files' => $normalize($this->tableSnapshot('clipping_has_files', ['created_at', 'updated_at'])),
        ];

        $this->assertGoldenJson('ajax/uploads', $results);
    }
}
