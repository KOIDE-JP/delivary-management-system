<?php

namespace App\Jobs;

use App\Mail\ApprovalMail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendReminderMailJob implements ShouldQueue
{
use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $plan;
    public $header;
    public $mode;

    /**
     * Create a new job instance.
     */
    public function __construct($plan, string $header, string $mode)
    {
        $this->plan = $plan;
        $this->header = $header;
        $this->mode = $mode;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        Log::info("Job queue for plan-ID :: {$this->plan->id} :: {$this->header} is being processed on ReminderMailJob.");
        Mail::to($this->plan->defect->user->email ?? auth()->user()->email)
            ->queue(new ApprovalMail($this->plan, $this->header, $this->mode));
    }
}
