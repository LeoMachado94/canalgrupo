<?php

namespace Tests\Feature\Golden;

use Illuminate\Support\Facades\DB;

class PagesTest extends GoldenTestCase
{
    public function test_guest_pages(): void
    {
        $this->assertGoldenJson('pages/guest_redirects', $this->statusMap(['/', '/home', '/clients', '/ajax/clippings', '/reports']));

        foreach ([
            'login' => '/login',
            'password_request' => '/password/reset',
            'password_reset_form' => '/password/reset/tok123?email=admin@golden.test',
            'client_password_request' => '/client/password/reset',
            'client_password_reset_form' => '/client/password/reset/tok123?email=alfa@golden.test',
        ] as $name => $uri) {
            $response = $this->get($uri);
            $response->assertStatus(200);
            $this->assertGoldenHtml("pages/guest_{$name}", $response->getContent());
        }
    }

    public function test_external_clipping_page(): void
    {
        $response = $this->get('/public/clippings/materia-golden-1');
        $response->assertStatus(200);
        $this->assertGoldenHtml('pages/external_clipping', $response->getContent());

        $this->assertSame(
            date('Y-m-d'),
            substr(DB::table('clippings')->where('id', 1)->value('last_read'), 0, 10)
        );

        $this->get('/public/clippings/nao-existe')->assertStatus(404);
    }

    public function test_admin_pages(): void
    {
        $this->actingAs($this->admin(), 'web');

        $pages = [
            'home' => '/home',
            'clippings_index' => '/clippings?client_id=1',
            'clippings_create' => '/clippings/create',
            'clippings_show' => '/clippings/1',
            'clippings_edit' => '/clippings/1/edit',
            'favorites_index' => '/favorites',
            'favorites_create' => '/favorites/create',
            'clients_index' => '/clients',
            'clients_create' => '/clients/create',
            'clients_show' => '/clients/1',
            'clients_edit' => '/clients/1/edit',
            'vehicles_index' => '/vehicles',
            'vehicles_create' => '/vehicles/create',
            'vehicles_show' => '/vehicles/1',
            'vehicles_edit' => '/vehicles/1/edit',
            'editorials_index' => '/editorials',
            'editorials_create' => '/editorials/create',
            'editorials_show' => '/editorials/1',
            'editorials_edit' => '/editorials/1/edit',
            'subjects_index' => '/subjects',
            'subjects_create' => '/subjects/create',
            'subjects_show' => '/subjects/1',
            'subjects_edit' => '/subjects/1/edit',
            'summaries_index' => '/summaries',
            'summaries_create' => '/summaries/create',
            'summaries_show' => '/summaries/1',
            'summaries_edit' => '/summaries/1/edit',
            'users_index' => '/users',
            'users_create' => '/users/create',
            'users_show' => '/users/2',
            'users_edit' => '/users/2/edit',
            'reports_index' => '/reports',
            'reports_preview' => '/report/preview/report_abc.pdf',
        ];

        foreach ($pages as $name => $uri) {
            $response = $this->get($uri);
            $this->assertSame(200, $response->getStatusCode(), "GET {$uri}");
            $this->assertGoldenHtml("pages/admin_{$name}", $response->getContent());
        }
    }

    public function test_client_pages(): void
    {
        $this->actingAs($this->client(), 'client');

        foreach ([
            'home' => '/home',
            'clippings_index' => '/clippings',
            'clippings_show' => '/clippings/1',
        ] as $name => $uri) {
            $response = $this->get($uri);
            $this->assertSame(200, $response->getStatusCode(), "GET {$uri}");
            $this->assertGoldenHtml("pages/client_{$name}", $response->getContent());
        }

        $this->assertGoldenJson('pages/client_forbidden', $this->statusMap(['/clients', '/users', '/reports', '/favorites', '/login']));
    }

    private function statusMap(array $uris): array
    {
        $map = [];
        foreach ($uris as $uri) {
            $response = $this->get($uri);
            $map[$uri] = [
                'status' => $response->getStatusCode(),
                'location' => $response->headers->get('Location'),
            ];
        }

        return $map;
    }
}
