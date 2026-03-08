<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Jobs\SendMailJob;
use App\Mail\ApprovalMail;
use App\Jobs\SendReminderMail;
use Illuminate\Console\Command;
use App\Jobs\SendReminderMailJob;
use Illuminate\Support\Facades\Log;
use App\Models\ProposedSolutionPlan;
use Illuminate\Support\Facades\Mail;
use App\Models\RecurrencePreventionPlan;

class SendPlanReminderMails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    // protected $signature = 'app:send-plan-reminder-mails';
    // protected $description = 'Command description';
    protected $signature = 'mail:send-plan-reminders';
    protected $description = 'Send reminder emails before and on the plan start dates for approved plans';


    /**
     * The console command description.
     *
     * @var string
     */
    

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $today = Carbon::today();
        $oneWeekBefore = $today->copy()->addDays(7);
        $threeDaysBefore = $today->copy()->addDays(3);

        // Send for ProposedSolutionPlan
        $this->sendReminders(
            ProposedSolutionPlan::class,
            'proposed_solution_plan_start_date',
            'proposed_solution_status'
        );

        // Send for RecurrencePreventionPlan
        $this->sendReminders(
            RecurrencePreventionPlan::class,
            'recurrence_prevention_plan_start_date',
            'recurrence_prevention_status'
        );
        Log::info("Reminder mails checked successfully.");
        $this->info('Reminder mails checked and sent successfully.');
    }

    private function sendReminders($model, $dateColumn, $statusColumn)
    {
        $today = Carbon::today();
        $oneWeekBefore = $today->copy()->addDays(7);
        $threeDaysBefore = $today->copy()->addDays(3);

        $plans = $model::where($statusColumn, 'approved')
            ->whereDate($dateColumn, '<=', $oneWeekBefore)
            ->whereDate($dateColumn, '>=', $today)
            ->get();

        foreach ($plans as $plan) {
            $startDate = Carbon::parse($plan->$dateColumn);
            // $startDate = $startDate->setTime(0, 0, 0);
            //  $startDate = Carbon::now()->addMinutes(2);

            // Calculate difference in days
            $daysLeft = $today->diffInDays($startDate, false);

            $when = null;
            if ($daysLeft == 7) $when = '1 week before';
            if ($daysLeft == 3) $when = '3 days before';
            if ($daysLeft == 0) $when = 'today';

            if ($when) {
                $header = '';
                if ($model === ProposedSolutionPlan::class) {
                    $header = __('layouts.proposed_solution_plan');
                } elseif ($model === RecurrencePreventionPlan::class) {
                    $header = __('layouts.recurrence_prevention_plan');
                }

                if ($plan->defect && $plan->defect->user && $plan->defect->user->email) {
                    try {
                        // Dispatch
                        SendMailJob::dispatch($plan, $header, 'reminder');
                        Log::info("Job dispatched for plan ID {$plan->id}");
                        $this->info("{$model} mail sent ({$when}) for ID: {$plan->id}");
                    } catch (\Exception $e) {
                        Log::info("Failed to dispatch job for plan ID {$plan->id}: " . $e->getMessage());
                    }
                }
                // Mail::to($plan->defect->user->email ?? auth()->user()->email)
                //     ->queue(new ApprovalMail($plan, $header, 'reminder'));
            }
        }
    }


}
