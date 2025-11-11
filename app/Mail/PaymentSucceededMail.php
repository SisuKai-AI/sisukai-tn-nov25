<?php

namespace App\Mail;

use App\Models\Learner;
use App\Models\Payment;
use App\Models\LearnerSubscription;
use App\Models\SubscriptionPlan;
use App\Models\Certification;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PaymentSucceededMail extends Mailable
{
    use Queueable, SerializesModels;

    public $learner;
    public $plan;
    public $amount;
    public $certification;

    public function __construct(Learner $learner, SubscriptionPlan $plan = null, $amount = 0, Certification $certification = null)
    {
        $this->learner = $learner;
        $this->plan = $plan;
        $this->amount = $amount;
        $this->certification = $certification;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Payment Received - SisuKai',
        );
    }

    public function content(): Content
    {
        $planName = $this->plan ? $this->plan->name : ($this->certification ? $this->certification->name : 'Single Certification');
        $nextBillingDate = 'N/A';
        
        if ($this->plan) {
            // Calculate next billing date based on plan
            $nextBillingDate = $this->plan->billing_cycle === 'yearly' 
                ? now()->addYear()->format('F j, Y')
                : now()->addMonth()->format('F j, Y');
        }

        return new Content(
            view: 'emails.payment-succeeded',
            with: [
                'email' => $this->learner->email,
                'learnerName' => $this->learner->name,
                'amount' => $this->amount,
                'planName' => $planName,
                'nextBillingDate' => $nextBillingDate,
                'paymentMethod' => 'card',
                'dashboardUrl' => route('learner.dashboard'),
                'manageSubscriptionUrl' => route('learner.payment.manage-subscription'),
                'billingHistoryUrl' => route('learner.payment.billing-history'),
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
