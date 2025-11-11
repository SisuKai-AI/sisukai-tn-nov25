<?php

namespace App\Console\Commands;

use App\Models\LearnerSubscription;
use App\Mail\TrialEndingMail;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendTrialEndingEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:trial-ending';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send emails to users whose trial ends in 2 days';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $twoDaysFromNow = now()->addDays(2)->startOfDay();
        $threeDaysFromNow = now()->addDays(2)->endOfDay();
        
        $subscriptions = LearnerSubscription::where('status', 'trialing')
            ->whereBetween('trial_ends_at', [$twoDaysFromNow, $threeDaysFromNow])
            ->with(['learner', 'plan'])
            ->get();

        $count = 0;
        foreach ($subscriptions as $subscription) {
            try {
                Mail::to($subscription->learner->email)->send(
                    new TrialEndingMail($subscription->learner, $subscription)
                );
                
                $this->info("✓ Sent trial ending email to {$subscription->learner->email}");
                $count++;
            } catch (\Exception $e) {
                $this->error("✗ Failed to send email to {$subscription->learner->email}: {$e->getMessage()}");
            }
        }

        $this->info("\nTotal emails sent: {$count}");
        
        return Command::SUCCESS;
    }
}
