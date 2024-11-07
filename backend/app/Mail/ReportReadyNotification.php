<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReportReadyNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $downloadUrl;

    public function __construct($fileName)
    {

        $this->downloadUrl = url("{$fileName}");
    }

    public function build()
    {


        return $this->subject('Seu relatório de tarefas está pronto')
            ->view('emails.report_ready')
            ->with(['downloadUrl' => $this->downloadUrl]);
    }
}
