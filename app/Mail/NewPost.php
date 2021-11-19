<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewPost extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;
    private $title;
    private $description;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($title, $description)
    {
        $this->title = $title;
        $this->description = $description;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
        ->from('oteaz.the.affiliate@gmail.com')
        ->subject('New Post')
        ->view('email.new_post', ['description' => $this->description, 'title' => $this->title]);
    }
}
