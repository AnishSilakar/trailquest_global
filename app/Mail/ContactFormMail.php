<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactFormMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $data;
    public function __construct($data)
    {
        $this->data = $data;
    }

    public function build()
    {
        try {
            return $this->view('emails.contact_form')
                ->with(['contactData' => $this->data])
                ->subject('New Lead from Quiz Submission');
        } catch (\Throwable $th) {
            dd($th->getMessage());
        }
    }
}
