<?php

namespace App\Mail;

use App\Helpers\RaportBuilder;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RaportBackup extends Mailable
{
    use Queueable, SerializesModels;

    private string $xml;

    /**
     * Create a new message instance.
     */
    public function __construct(public User $user)
    {
        $this->getXmlData();
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Raport Backup',
            from: new Address('contact@prodeveloper.pl', 'Damian Hajdukiewicz')
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.raportBackup'
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [
            Attachment::fromData(fn () => $this->xml, 'wydatki-wszystkie-lata.xml')
                ->withMime('text/xml')
        ];
    }

    private function getXmlData(): void
    {
        $data = $this->user->expenses()
            ->with('category:id,name')
            ->orderBy('spent_at')
            ->get();
        $builder = new RaportBuilder($data);

        $this->xml = $builder->getXml();
    }
}
