<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Log;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Contracts\Queue\ShouldQueue;

class ApprovalMail extends Mailable
{
    use Queueable, SerializesModels;

    public $plan;
    public $type;
    public $mode;

     /**
     * Create a new message instance.
     *
     * @param $plan
     * @param string $type
     */
    public function __construct($plan, string $type, string $mode)
    {
        $this->plan = $plan;
        $this->type = $type;
        $this->mode = $mode;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        // Dynamically build subject
        if ($this->mode === 'reminder') {
            $subject = __('layouts.reminder') . ' ' . $this->type; 
        } else {
            $subject = $this->type . ' ' . __('layouts.approved');
        }

        try {
            Log::info('comes to mail blade now');
            Log::info('Building ApprovalMail for type: ' . $this->type . ' mode: ' . $this->mode);
            // $subject = $this->type;
            return $this->subject($subject)
            ->markdown('emails.approval');

            
        } catch (\Exception $e) {
            Log::error('Error logging ApprovalMail build: ' . $e->getMessage());
        }

        // Log::info('Building ApprovalMail for type: ' . $this->type . ' mode: ' . $this->mode);

        
    }
}
