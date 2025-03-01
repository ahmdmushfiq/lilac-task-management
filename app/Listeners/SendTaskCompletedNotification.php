<?php

namespace App\Listeners;

use App\Events\TaskCompleted;
use App\Jobs\SendTaskCompletedEmail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendTaskCompletedNotification
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(TaskCompleted $event): void
    {
        SendTaskCompletedEmail::dispatch($event->task);
    }
}
