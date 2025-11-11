@extends('emails.layout')

@section('title', 'Your Trial Ends Soon')

@section('content')
    <h1>⏰ Your Trial Ends in 2 Days, {{ $learnerName }}</h1>
    
    <p>We hope you've been enjoying SisuKai! Your 7-day free trial will end on <strong>{{ $trialEndsAt }}</strong>.</p>

    <div class="info-box">
        <strong>Your Progress So Far:</strong><br>
        Questions Answered: <strong>{{ $questionsAnswered ?? 'N/A' }}</strong><br>
        Practice Sessions: <strong>{{ $practiceSessions ?? 'N/A' }}</strong><br>
        Current Plan: <strong>{{ $planName }}</strong>
    </div>

    <p><strong>Continue your certification journey!</strong></p>
    <p>To keep your access to all SisuKai features, no action is needed. Your subscription will automatically continue at <strong>${{ $planPrice }}/{{ $billingCycle }}</strong>.</p>

    <a href="{{ $dashboardUrl }}" class="button">Continue Studying</a>

    <p><strong>Want to change your plan?</strong></p>
    <p>You can upgrade, downgrade, or cancel your subscription anytime from your <a href="{{ $manageSubscriptionUrl }}">subscription settings</a>.</p>

    <p><strong>Not ready to continue?</strong></p>
    <p>No problem! You can <a href="{{ $manageSubscriptionUrl }}">cancel your subscription</a> before {{ $trialEndsAt }} and you won't be charged.</p>

    <p>Questions? We're here to help! Reply to this email or visit our <a href="{{ route('landing.help.index') }}">Help Center</a>.</p>

    <p>Best regards,<br>
    <strong>The SisuKai Team</strong></p>
@endsection
