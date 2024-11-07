<?php

namespace App\Jobs;

use App\Mail\TaskNotification;
use App\Models\Task;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class SendTaskNotification implements ShouldQueue
{
    use Queueable;


    protected $task;
    /**
     * Create a new job instance.
     */
    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        \Mail::to("gustavopantoja.ap@gmail.com")->send(new TaskNotification($this->task));

    }
}
