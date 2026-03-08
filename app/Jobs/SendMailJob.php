<?php

namespace App\Jobs;

use App\Mail\ApprovalMail;
use App\Mail\LowStockMail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendMailJob implements ShouldQueue
{
    use Dispatchable, Queueable, SerializesModels;

    protected $plan;
    protected $header;
    protected $mode;

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
        Log::info("Job queue for plan-ID: {$this->plan->id} - {$this->header} - {$this->mode} is being processed on SendMailJob.");
        Mail::to($this->plan->defect->user->email ?? auth()->user()->email)
            ->queue(new ApprovalMail($this->plan, $this->header, $this->mode));
    }
}
