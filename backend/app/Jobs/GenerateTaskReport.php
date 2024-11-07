<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReportReadyNotification;
use Barryvdh\DomPDF\Facade\Pdf;

class GenerateTaskReport implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function handle()
    {
        $tasks = $this->user->tasks()->get(['title', 'status', 'deadline']);


        $pdf = Pdf::loadView('reports.task_report', compact('tasks'));
        $fileName = "task_report_{$this->user->id}_" . now()->timestamp . ".pdf";
        $filePath = "reports/{$fileName}";


        Storage::disk('private')->put($filePath, $pdf->output());


        $fileUrl = url("api/files/{$fileName}");

        
        Mail::to($this->user->email)->send(new ReportReadyNotification($fileUrl));
    }
}
