<?php

namespace Tests\Feature\Golden;

use App\Mail\ClippingReportMail;
use App\Mail\FavoritesReportMail;
use App\Models\Client;
use App\Models\Clipping;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class ReportsTest extends GoldenTestCase
{
    private const PNG = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mNkYAAAAAYAAjCB0C8AAAAASUVORK5CYII=';

    private $reportInput = [
        'client_id' => 1, 'middle_id' => 1, 'start_date' => '01/01/2025', 'end_date' => '31/12/2026',
        'input_chart_clippings' => self::PNG,
        'input_chart_classification' => self::PNG,
        'input_chart_source' => self::PNG,
    ];

    public function test_make_pdf(): void
    {
        Storage::fake('public');
        $this->actingAs($this->admin(), 'web');

        $wrappers = [app('dompdf.wrapper'), app('dompdf.wrapper')];
        $captured = [];
        \PDF::shouldReceive('loadView')->andReturnUsing(function ($view, $data) use (&$wrappers, &$captured) {
            // The PDF title carries the real current date (date()), not the frozen test clock.
            $captured[] = str_replace(date('Y-m-d'), 'TODAY', view($view, $data)->render());

            return array_shift($wrappers)->loadView($view, $data);
        });

        $plain = $this->postJson('/ajax/report/generate', $this->reportInput)->json();
        $filtered = $this->postJson('/ajax/report/generate', $this->reportInput + [
            'classification_id' => 3, 'exhibition_id' => 1, 'title' => 'golden',
        ])->json();

        $this->assertGoldenHtml('reports/pdf_plain', Arr::get($captured, 0));
        $this->assertGoldenHtml('reports/pdf_filtered', Arr::get($captured, 1));

        foreach ([$plain, $filtered] as $result) {
            $this->assertTrue(Arr::get($result, 'success'));
            $this->assertSame(1, preg_match('/^report_[0-9a-f]{13}_\d{2}-\d{2}-\d{4}\.pdf$/', Arr::get($result, 'fileName')));
            $pdf = Storage::disk('public')->get('reports/'.Arr::get($result, 'fileName'));
            $this->assertStringStartsWith('%PDF-', $pdf);
        }

        $this->assertGoldenJson('reports/generate_response', [
            Arr::except($plain, 'fileName'), Arr::except($filtered, 'fileName'),
        ]);

    }

    public function test_download_from_spaces(): void
    {
        Storage::fake('spaces');
        Storage::disk('spaces')->put('reports/report_abc.pdf', '%PDF-1.4 golden');
        $this->actingAs($this->admin(), 'web');

        // Passing the object URL as the storage path is how the current code behaves; only the status is pinned.
        $this->assertGoldenJson('reports/download', [
            'existing' => $this->get('/report/download/report_abc.pdf')->getStatusCode(),
        ]);
    }

    public function test_send_report_mail(): void
    {
        Mail::fake();
        $this->actingAs($this->admin(), 'web');

        $results = [
            'with_cc' => $this->postJson('/ajax/report/sendMail/1', ['report' => 'report_x.pdf', 'month' => 'Março'])->json(),
            'without_cc' => $this->postJson('/ajax/report/sendMail/2', ['report' => 'report_x.pdf'])->json(),
            'without_email' => $this->postJson('/ajax/report/sendMail/3', ['report' => 'report_x.pdf'])->json(),
            'missing_client' => $this->postJson('/ajax/report/sendMail/999', ['report' => 'report_x.pdf'])->json(),
        ];

        $sent = [];
        Mail::assertSent(ClippingReportMail::class, function ($mail) use (&$sent) {
            $sent[] = [
                'to' => array_column($mail->to, 'address'),
                'cc' => array_column($mail->cc, 'address'),
            ];

            return true;
        });
        $results['sent'] = $sent;

        $this->assertGoldenJson('mail/report_send', $results);
    }

    public function test_send_favorites_mail(): void
    {
        Mail::fake();
        $this->actingAs($this->admin(), 'web');

        $results = [
            'ok' => $this->postJson('/ajax/favorites/sendMail', [
                'client_id' => 1, 'clippings' => '1,3,8', 'start_date' => '01/01/2025', 'end_date' => '31/12/2026',
            ])->json(),
            'today' => $this->postJson('/ajax/favorites/sendMail', ['client_id' => 1, 'clippings' => '8'])->json(),
            'missing_client' => $this->postJson('/ajax/favorites/sendMail', ['client_id' => 999, 'clippings' => '1'])->json(),
            'statuses' => [
                $this->postJson('/ajax/favorites/sendMail', ['client_id' => 999, 'clippings' => '1'])->getStatusCode(),
                $this->postJson('/ajax/favorites/sendMail', ['client_id' => 3, 'clippings' => '1'])->getStatusCode(),
            ],
        ];

        $sent = [];
        Mail::assertSent(FavoritesReportMail::class, function ($mail) use (&$sent) {
            $sent[] = [
                'to' => array_column($mail->to, 'address'),
                'cc' => array_column($mail->cc, 'address'),
            ];

            return true;
        });
        $results['sent'] = $sent;

        $this->assertGoldenJson('mail/favorites_send', $results);
    }

    public function test_mail_rendering(): void
    {
        $client = Client::find(1);
        $favorites = Clipping::with(['client', 'exhibition', 'subject', 'middle', 'classification', 'user'])
            ->whereIn('id', [1, 3, 8])->orderBy('date', 'desc')->get();

        $favoritesMail = new FavoritesReportMail($client, $favorites);
        $this->assertGoldenHtml('mail/favorites_body', $favoritesMail->render());
        $this->assertSame(date('d/m/Y').' - Clipping - Cliente Alfa', $favoritesMail->subject);

        $reportMail = new ClippingReportMail($client, 'report_x.pdf', 'Março');
        $this->assertGoldenHtml('mail/report_body', $reportMail->render());
        $this->assertGoldenJson('mail/report_meta', [
            'subject' => $reportMail->subject,
            'attachments' => array_map(function ($attachment) {
                return [Arr::get($attachment, 'file'), Arr::get($attachment, 'options')];
            }, $reportMail->attachments),
        ]);
    }
}
