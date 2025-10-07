<?php

namespace App\Mail;

use App\Models\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class ClippingReportMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $client;
    protected $report;
    protected $month;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Client $client, $report, $month)
    {
        $this->client = $client;
        $this->month = $month;
        $this->report = Storage::disk('spaces')->url("reports/{$report}");
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('notify.clippings.report', ['client' => $this->client, 'month' => $this->month])
        ->subject('Relatório de Clipping(s)')
        ->attach($this->report, [
            'as' => 'relatorio.pdf',
            'mime' => 'application/pdf',
        ]);
    }
}
