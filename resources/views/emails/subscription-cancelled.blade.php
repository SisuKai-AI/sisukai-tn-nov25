@extends('emails.layout')

@section('title', 'Subscription Cancelled')

@section('content')
    <h1>👋 Subscription Cancelled, {{ $learnerName }}</h1>
    
    <p>We're sorry to see you go! Your SisuKai subscription has been cancelled.</p>

    <div class="info-box">
        <strong>Cancellation Details:</strong><br>
        Plan: <strong>{{ $planName }}</strong><br>
        Access Until: <strong>{{ $accessUntil }}</strong><br>
        Cancelled On: <strong>{{ $cancelledAt }}</strong>
    </div>

    <p><strong>What happens next?</strong></p>
    <p>You'll continue to have full access to SisuKai until <strong>{{ $accessUntil }}</strong>. After that, your account will be downgraded to a free account.</p>

    <p><strong>Changed your mind?</strong></p>
    <p>You can reactivate your subscription anytime before {{ $accessUntil }} and pick up right where you left off.</p>

    <a href="{{ $reactivateUrl }}" class="button">Reactivate Subscription</a>

    <p><strong>We'd love your feedback!</strong></p>
    <p>Could you take a moment to tell us why you cancelled? Your feedback helps us improve SisuKai for everyone.</p>
    <p><a href="{{ $feedbackUrl ?? route('landing.contact') }}">Share Your Feedback</a></p>

    <p><strong>What you'll keep:</strong></p>
    <ul>
        <li>✅ Your account and progress data</li>
        <li>✅ Access to free practice questions (limited)</li>
        <li>✅ Ability to reactivate anytime</li>
    </ul>

    <p>Thank you for being part of the SisuKai community. We hope to see you again soon!</p>

    <p>Best wishes,<br>
    <strong>The SisuKai Team</strong></p>
@endsection
