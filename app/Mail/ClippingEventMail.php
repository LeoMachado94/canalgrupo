<?php

namespace App\Mail;

use App\Models\Clipping;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ClippingEventMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $report;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($report)
    {
        $this->report = $report;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if ($this->event === 'created') {
            return $this->view('notify.clippings.created', ['clipping' => $this->clipping]);
        }
        return $this->view('notify.clippings.report', ['clipping' => $this->clipping]);
    }
}
