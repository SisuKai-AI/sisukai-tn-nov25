<?php

namespace App\Mail;

use App\Models\Learner;
use App\Models\LearnerSubscription;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TrialEndingMail extends Mailable
{
    use Queueable, SerializesModels;

    public $learner;
    public $subscription;

    public function __construct(Learner $learner, LearnerSubscription $subscription)
    {
        $this->learner = $learner;
        $this->subscription = $subscription;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Your SisuKai Trial Ends in 2 Days',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.trial-ending',
            with: [
                'email' => $this->learner->email,
                'learnerName' => $this->learner->name,
                'planName' => $this->subscription->plan->name,
                'planPrice' => $this->subscription->plan->price,
                'billingCycle' => $this->subscription->plan->billing_cycle,
                'trialEndsAt' => $this->subscription->trial_ends_at->format('F j, Y'),
                'dashboardUrl' => route('learner.dashboard'),
                'manageSubscriptionUrl' => route('learner.payment.manage-subscription'),
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
