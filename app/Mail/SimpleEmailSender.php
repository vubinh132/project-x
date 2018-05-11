<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SimpleEmailSender extends Mailable
{
    use Queueable, SerializesModels;

    protected $template;
    protected $attachFiles;
    public $params;

    /**
     * Create a new message instance.
     *
     * @param $subject
     * @param $template
     * @param $params
     * @param $attachFiles
     */
    public function __construct($subject, $template, $params, $attachFiles)
    {
        $this->subject =$subject;
        $this->template = $template;
        $this->params = $params;
        $this->attachFiles = $attachFiles;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $email = $this->view($this->template);

        if ($this->attachFiles) {
            foreach ($this->attachFiles as $filePath) {
                $email->attach($filePath);
            }
        }

        return $email;
    }
}
