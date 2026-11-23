<?php // PHP opening tag

namespace App\Mail; // Mailables namespace declaration

use App\Models\Cliente; // Import Cliente model
use App\Models\Reparacion; // Import Reparacion model
use Illuminate\Bus\Queueable; // Import Queueable trait
use Illuminate\Mail\Mailable; // Import Mailable base class
use Illuminate\Mail\Mailables\Content; // Import Content configuration
use Illuminate\Mail\Mailables\Envelope; // Import Envelope configuration
use Illuminate\Queue\SerializesModels; // Import SerializesModels trait

class ReparacionUpdatedMail extends Mailable { // Mailable for status update notifications
    use Queueable, SerializesModels; // Traits for queueability and model serialization

    public $cliente; // Public client property for view
    public $reparacion; // Public repair property for view

    public function __construct(Cliente $cliente, Reparacion $reparacion) { // Constructor accepting models
        $this->cliente = $cliente; // Assign client model instance
        $this->reparacion = $reparacion; // Assign repair model instance
    } // End of constructor

    public function envelope(): Envelope { // Build email envelope with subject
        return new Envelope( // Return envelope instance
            subject: 'Actualización de tu tabla: ' . ($this->reparacion->Estado ?? 'En proceso'), // Dynamic descriptive subject
        ); // Close envelope instance
    } // End of envelope method

    public function content(): Content { // Build email view content definition
        return new Content( // Return content instance
            view: 'email.reparacion_updated', // Point to dedicated email view template
        ); // Close content instance
    } // End of content method

    public function attachments(): array { // Define attachments array
        return []; // Return empty array since no files are attached
    } // End of attachments method
} // End of ReparacionUpdatedMail class
