@extends('layouts.landing')

@section('title', 'About Us - SisuKai')
@section('meta_description', 'Learn about SisuKai\'s mission to help professionals pass their certification exams with confidence through adaptive learning and comprehensive practice.')

@section('content')

<!-- Page Header -->
<section class="page-header bg-primary-custom text-white" style="padding: 4rem 0 3rem;">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto text-center">
                <h1 class="display-4 fw-bold mb-3">About SisuKai</h1>
                <p class="lead mb-0">
                    Empowering professionals to achieve certification success through adaptive learning
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Mission Section -->
<section class="landing-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-4 mb-lg-0">
                <h2 class="section-title mb-4">Our Mission</h2>
                <p class="lead text-muted mb-4">
                    At SisuKai, we believe that professional certifications should be accessible to everyone. 
                    Our mission is to provide the most effective, adaptive, and comprehensive exam preparation 
                    platform to help you pass your certification exam on the first try.
                </p>
                <p class="text-muted">
                    We combine cutting-edge adaptive learning technology with comprehensive question banks 
                    and expert-crafted content to create a personalized learning experience that adapts to 
                    your unique needs and learning style.
                </p>
            </div>
            <div class="col-lg-6">
                <img src="{{ asset('images/our-mission.webp') }}" 
                     alt="Our Mission" 
                     class="img-fluid rounded shadow">
            </div>
        </div>
    </div>
</section>

<!-- Values Section -->
<section class="landing-section bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title">Our Core Values</h2>
            <p class="section-subtitle">The principles that guide everything we do</p>
        </div>
        
        <div class="row g-4">
            <div class="col-lg-4 col-md-6">
                <div class="landing-card text-center h-100">
                    <div class="icon bg-primary-custom text-white mx-auto mb-3">
                        <i class="bi bi-bullseye"></i>
                    </div>
                    <h4 class="mb-3">Excellence</h4>
                    <p class="text-muted mb-0">
                        We strive for excellence in everything we do, from our question quality to our user experience.
                    </p>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6">
                <div class="landing-card text-center h-100">
                    <div class="icon bg-success text-white mx-auto mb-3">
                        <i class="bi bi-people"></i>
                    </div>
                    <h4 class="mb-3">Student-Centric</h4>
                    <p class="text-muted mb-0">
                        Your success is our success. We put learners first in every decision we make.
                    </p>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6">
                <div class="landing-card text-center h-100">
                    <div class="icon bg-info text-white mx-auto mb-3">
                        <i class="bi bi-lightbulb"></i>
                    </div>
                    <h4 class="mb-3">Innovation</h4>
                    <p class="text-muted mb-0">
                        We continuously innovate to provide the most effective learning experience possible.
                    </p>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6">
                <div class="landing-card text-center h-100">
                    <div class="icon bg-warning text-white mx-auto mb-3">
                        <i class="bi bi-shield-check"></i>
                    </div>
                    <h4 class="mb-3">Integrity</h4>
                    <p class="text-muted mb-0">
                        We maintain the highest standards of integrity and transparency in all our operations.
                    </p>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6">
                <div class="landing-card text-center h-100">
                    <div class="icon bg-danger text-white mx-auto mb-3">
                        <i class="bi bi-graph-up-arrow"></i>
                    </div>
                    <h4 class="mb-3">Results-Driven</h4>
                    <p class="text-muted mb-0">
                        We focus on measurable results and proven outcomes for our learners.
                    </p>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6">
                <div class="landing-card text-center h-100">
                    <div class="icon bg-secondary text-white mx-auto mb-3">
                        <i class="bi bi-heart"></i>
                    </div>
                    <h4 class="mb-3">Passion</h4>
                    <p class="text-muted mb-0">
                        We're passionate about education and helping professionals achieve their career goals.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Story Section -->
<section class="landing-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 order-lg-2 mb-4 mb-lg-0">
                <h2 class="section-title mb-4">Our Story</h2>
                <p class="text-muted mb-3">
                    SisuKai was founded by a team of certification experts and educators who experienced 
                    firsthand the challenges of traditional exam preparation methods. We saw countless 
                    professionals struggle with outdated study materials, ineffective practice questions, 
                    and one-size-fits-all approaches that didn't account for individual learning styles.
                </p>
                <p class="text-muted mb-3">
                    We knew there had to be a better way. By combining our expertise in education, 
                    technology, and certification exams, we created SisuKai—an adaptive learning platform 
                    that personalizes the preparation experience for each learner.
                </p>
                <p class="text-muted mb-0">
                    Today, thousands of professionals trust SisuKai to help them achieve their certification 
                    goals. We're proud to have helped so many people advance their careers, and we're just 
                    getting started.
                </p>
            </div>
            <div class="col-lg-6 order-lg-1">
                <img src="{{ asset('images/our-story.webp') }}" 
                     alt="Our Story" 
                     class="img-fluid rounded shadow">
            </div>
        </div>
    </div>
</section>

<!-- Stats Section -->
<section class="landing-section bg-primary-custom text-white">
    <div class="container">
        <div class="row g-4 text-center">
            <div class="col-lg-3 col-md-6">
                <div class="mb-2">
                    <span class="display-4 fw-bold">10K+</span>
                </div>
                <p class="mb-0 opacity-75">Active Learners</p>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="mb-2">
                    <span class="display-4 fw-bold">50K+</span>
                </div>
                <p class="mb-0 opacity-75">Practice Questions</p>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="mb-2">
                    <span class="display-4 fw-bold">95%</span>
                </div>
                <p class="mb-0 opacity-75">Pass Rate</p>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="mb-2">
                    <span class="display-4 fw-bold">20+</span>
                </div>
                <p class="mb-0 opacity-75">Certifications</p>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="cta-section bg-light" style="padding: 4rem 0;">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8 mb-4 mb-lg-0 text-center text-lg-start">
                <h2 class="fw-bold mb-3">Ready to Join Thousands of Successful Learners?</h2>
                <p class="text-muted mb-0">
                    Start your certification journey today with our 7-day free trial. No credit card required.
                </p>
            </div>
            <div class="col-lg-4 text-center text-lg-end">
                <a href="{{ route('register') }}" class="btn btn-primary-custom btn-lg">
                    <i class="bi bi-rocket-takeoff me-2"></i>Start Free Trial
                </a>
            </div>
        </div>
    </div>
</section>

@endsection
