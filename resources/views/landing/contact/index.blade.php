@extends('layouts.landing')

@section('title', 'Contact Us - SisuKai')
@section('meta_description', 'Get in touch with the SisuKai team. We\'re here to help with any questions about our certification exam preparation platform.')

@section('content')

<!-- Page Header -->
<section class="page-header bg-primary-custom text-white" style="padding: 4rem 0 3rem;">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto text-center">
                <h1 class="display-4 fw-bold mb-3">Contact Us</h1>
                <p class="lead mb-0">
                    Have a question? We're here to help. Send us a message and we'll respond within 24 hours.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Contact Section -->
<section class="landing-section">
    <div class="container">
        <div class="row g-4">
            <!-- Contact Form -->
            <div class="col-lg-8">
                <div class="landing-card">
                    <h3 class="mb-4">Send Us a Message</h3>
                    
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="bi bi-check-circle me-2"></i>
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif
                    
                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="bi bi-exclamation-triangle me-2"></i>
                            <strong>Please fix the following errors:</strong>
                            <ul class="mb-0 mt-2">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif
                    
                    <form action="{{ route('landing.contact.submit') }}" method="POST">
                        @csrf
                        
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="name" class="form-label">Full Name <span class="text-danger">*</span></label>
                                <input type="text" 
                                       class="form-control @error('name') is-invalid @enderror" 
                                       id="name" 
                                       name="name" 
                                       value="{{ old('name') }}" 
                                       required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6">
                                <label for="email" class="form-label">Email Address <span class="text-danger">*</span></label>
                                <input type="email" 
                                       class="form-control @error('email') is-invalid @enderror" 
                                       id="email" 
                                       name="email" 
                                       value="{{ old('email') }}" 
                                       required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-12">
                                <label for="subject" class="form-label">Subject <span class="text-danger">*</span></label>
                                <input type="text" 
                                       class="form-control @error('subject') is-invalid @enderror" 
                                       id="subject" 
                                       name="subject" 
                                       value="{{ old('subject') }}" 
                                       required>
                                @error('subject')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-12">
                                <label for="message" class="form-label">Message <span class="text-danger">*</span></label>
                                <textarea class="form-control @error('message') is-invalid @enderror" 
                                          id="message" 
                                          name="message" 
                                          rows="6" 
                                          required>{{ old('message') }}</textarea>
                                @error('message')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-12">
                                <div class="form-check">
                                    <input class="form-check-input" 
                                           type="checkbox" 
                                           id="newsletter" 
                                           name="newsletter" 
                                           value="1"
                                           {{ old('newsletter') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="newsletter">
                                        Subscribe to our newsletter for updates and tips
                                    </label>
                                </div>
                            </div>
                            
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary-custom btn-lg">
                                    <i class="bi bi-send me-2"></i>Send Message
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            
            <!-- Contact Info -->
            <div class="col-lg-4">
                <!-- Email -->
                <div class="landing-card mb-4">
                    <div class="d-flex align-items-start">
                        <div class="icon bg-primary-custom text-white me-3">
                            <i class="bi bi-envelope"></i>
                        </div>
                        <div>
                            <h5 class="mb-2">Email Us</h5>
                            <p class="text-muted mb-2">Our team typically responds within 24 hours</p>
                            <a href="mailto:support@sisukai.com" class="text-decoration-none">
                                support@sisukai.com
                            </a>
                        </div>
                    </div>
                </div>
                
                <!-- Support Hours -->
                <div class="landing-card mb-4">
                    <div class="d-flex align-items-start">
                        <div class="icon bg-success text-white me-3">
                            <i class="bi bi-clock"></i>
                        </div>
                        <div>
                            <h5 class="mb-2">Support Hours</h5>
                            <p class="text-muted mb-1">Monday - Friday</p>
                            <p class="text-muted mb-1">9:00 AM - 6:00 PM EST</p>
                            <p class="text-muted mb-0">
                                <small>We're closed on weekends and major holidays</small>
                            </p>
                        </div>
                    </div>
                </div>
                
                <!-- FAQ -->
                <div class="landing-card">
                    <div class="d-flex align-items-start">
                        <div class="icon bg-info text-white me-3">
                            <i class="bi bi-question-circle"></i>
                        </div>
                        <div>
                            <h5 class="mb-2">Quick Answers</h5>
                            <p class="text-muted mb-3">Looking for instant answers? Check out our help center.</p>
                            <a href="{{ route('landing.help.index') }}" class="btn btn-outline-custom btn-sm">
                                Visit Help Center <i class="bi bi-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FAQ Section -->
<section class="landing-section bg-light">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div class="text-center mb-5">
                    <h2 class="section-title">Common Questions</h2>
                    <p class="section-subtitle">Find answers to frequently asked questions</p>
                </div>
                
                <div class="accordion" id="contactFAQ">
                    <!-- FAQ 1 -->
                    <div class="accordion-item mb-3 border-0 shadow-sm">
                        <h2 class="accordion-header">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                                How quickly will I receive a response?
                            </button>
                        </h2>
                        <div id="faq1" class="accordion-collapse collapse show" data-bs-parent="#contactFAQ">
                            <div class="accordion-body">
                                We aim to respond to all inquiries within 24 hours during business days. 
                                For urgent matters, please mark your message as "Urgent" in the subject line.
                            </div>
                        </div>
                    </div>
                    
                    <!-- FAQ 2 -->
                    <div class="accordion-item mb-3 border-0 shadow-sm">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                                Can I schedule a demo or consultation?
                            </button>
                        </h2>
                        <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#contactFAQ">
                            <div class="accordion-body">
                                Yes! We offer personalized demos for teams and organizations. 
                                Please mention "Demo Request" in your subject line and we'll schedule a time that works for you.
                            </div>
                        </div>
                    </div>
                    
                    <!-- FAQ 3 -->
                    <div class="accordion-item mb-3 border-0 shadow-sm">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                                Do you offer phone support?
                            </button>
                        </h2>
                        <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#contactFAQ">
                            <div class="accordion-body">
                                Currently, we provide support primarily through email to ensure we can thoroughly 
                                document and resolve your issues. For premium subscribers, we offer scheduled phone consultations.
                            </div>
                        </div>
                    </div>
                    
                    <!-- FAQ 4 -->
                    <div class="accordion-item border-0 shadow-sm">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq4">
                                How do I report a technical issue?
                            </button>
                        </h2>
                        <div id="faq4" class="accordion-collapse collapse" data-bs-parent="#contactFAQ">
                            <div class="accordion-body">
                                Please use the contact form above and include "Technical Issue" in the subject line. 
                                Provide as much detail as possible, including screenshots if applicable, to help us resolve the issue quickly.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
