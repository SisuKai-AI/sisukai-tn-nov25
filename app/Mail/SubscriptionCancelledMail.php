<?php

namespace App\Mail;

use App\Models\Learner;
use App\Models\LearnerSubscription;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SubscriptionCancelledMail extends Mailable
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
            subject: 'Subscription Cancelled - SisuKai',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.subscription-cancelled',
            with: [
                'email' => $this->learner->email,
                'learnerName' => $this->learner->name,
                'planName' => $this->subscription->plan->name,
                'accessUntil' => $this->subscription->ends_at ? $this->subscription->ends_at->format('F j, Y') : 'immediately',
                'cancelledAt' => now()->format('F j, Y'),
                'reactivateUrl' => route('learner.payment.subscription.resume'),
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
