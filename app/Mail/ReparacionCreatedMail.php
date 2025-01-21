<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Cliente;
use App\Models\Reparacion;


class ReparacionCreatedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $cliente;
    public $reparacion;
    /**
     * Create a new message instance.
     */
    public function __construct(Cliente $cliente, Reparacion $reparacion)
    {
        $this->cliente = $cliente;
        $this->reparacion = $reparacion;


    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Hemos comenzado con su reparacion',
        );
    }
    public function build()
    {
        return $this->view('email.reparacion_created')
        ->with([
            'cliente' => $this->cliente,
            'reparacion' => $this->reparacion,
        ]);
    }

    /**
     * Get the message content definition.
     */


    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
