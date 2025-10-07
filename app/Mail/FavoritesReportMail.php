<?php

namespace App\Mail;

use App\Models\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class FavoritesReportMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $client;
    protected $favorites;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Client $client, $favorites)
    {
        $this->client = $client;
        $this->favorites = $favorites;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('notify.clippings.favorites', ['client' => $this->client, 'favorites' => $this->favorites])
        ->subject(date('d/m/Y').' - Clipping - '.$this->client->name);
    }
}
