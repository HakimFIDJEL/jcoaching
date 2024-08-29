<?php

namespace App\Mail\admin;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

use App\Models\User;

class StoreMember extends Mailable
{
    use Queueable, SerializesModels;

    public User $user;
    public String $temporary_password;

    /**
     * Create a new message instance.
     */
    public function __construct(User $user, String $temporary_password)
    {
        $this->user = $user;
        $this->temporary_password = $temporary_password;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: env('APP_NAME') . ' - Bienvenue sur ' . env('APP_NAME') . ' !',
            to: $this->user->email,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.admin.storemember',
            with: [
                'user' => $this->user,
                'temporary_password' => $this->temporary_password,
            ],
        );
    }

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
