<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'SisuKai - Certification Exam Preparation')</title>
    <meta name="description" content="@yield('meta_description', 'Pass your certification exam with confidence. Adaptive practice engine, comprehensive question banks, and personalized learning paths.')">
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <!-- Custom Landing CSS -->
    <style>
        :root {
            --primary-color: #696cff;
            --primary-dark: #5f61e6;
            --secondary-color: #8592a3;
            --success-color: #71dd37;
            --info-color: #03c3ec;
            --warning-color: #ffab00;
            --danger-color: #ff3e1d;
            --dark-color: #233446;
            --light-color: #f5f5f9;
            --white: #fff;
            --gray-100: #f8f9fa;
            --gray-200: #e9ecef;
            --gray-300: #dee2e6;
            --gray-600: #6c757d;
            --gray-900: #212529;
        }
        
        body {
            font-family: 'Public Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Oxygen, Ubuntu, Cantarell, 'Fira Sans', 'Droid Sans', 'Helvetica Neue', sans-serif;
            color: var(--gray-900);
            background-color: var(--white);
        }
        
        /* Navbar Styles */
        .landing-navbar {
            background-color: var(--white);
            box-shadow: 0 2px 6px 0 rgba(67, 89, 113, 0.12);
            padding: 1rem 0;
        }
        
        .landing-navbar .navbar-brand {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary-color);
        }
        
        .landing-navbar .nav-link {
            color: var(--gray-900);
            font-weight: 500;
            padding: 0.5rem 1rem;
            transition: color 0.2s;
        }
        
        .landing-navbar .nav-link:hover {
            color: var(--primary-color);
        }
        
        .landing-navbar .btn-trial {
            background-color: var(--primary-color);
            color: var(--white);
            padding: 0.625rem 1.5rem;
            border-radius: 0.375rem;
            font-weight: 600;
            transition: background-color 0.2s;
        }
        
        .landing-navbar .btn-trial:hover {
            background-color: var(--primary-dark);
        }
        
        .landing-navbar .btn-login {
            color: var(--primary-color);
            border: 1px solid var(--primary-color);
            padding: 0.625rem 1.5rem;
            border-radius: 0.375rem;
            font-weight: 600;
            transition: all 0.2s;
        }
        
        .landing-navbar .btn-login:hover {
            background-color: var(--primary-color);
            color: var(--white);
        }
        
        /* Footer Styles */
        .landing-footer {
            background-color: var(--gray-100);
            padding: 4rem 0 2rem;
            margin-top: 0;
        }
        
        .landing-footer h5 {
            font-weight: 600;
            margin-bottom: 1.5rem;
            color: var(--gray-900);
        }
        
        .landing-footer ul {
            list-style: none;
            padding: 0;
        }
        
        .landing-footer ul li {
            margin-bottom: 0.75rem;
        }
        
        .landing-footer a {
            color: var(--gray-600);
            text-decoration: none;
            transition: color 0.2s;
        }
        
        .landing-footer a:hover {
            color: var(--primary-color);
        }
        
        .landing-footer .social-links a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: var(--white);
            color: var(--gray-600);
            margin-right: 0.5rem;
            transition: all 0.2s;
        }
        
        .landing-footer .social-links a:hover {
            background-color: var(--primary-color);
            color: var(--white);
        }
        
        .landing-footer .copyright {
            border-top: 1px solid var(--gray-300);
            padding-top: 2rem;
            margin-top: 3rem;
            text-align: center;
            color: var(--gray-600);
        }
        
        /* Section Styles */
        .landing-section {
            padding: 5rem 0;
        }
        
        .section-title {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
            color: var(--gray-900);
        }
        
        .section-subtitle {
            font-size: 1.125rem;
            color: var(--gray-600);
            margin-bottom: 3rem;
        }
        
        /* Button Styles */
        .btn-primary-custom {
            background-color: var(--primary-color);
            color: var(--white);
            padding: 0.875rem 2rem;
            border-radius: 0.375rem;
            font-weight: 600;
            border: none;
            transition: background-color 0.2s;
        }
        
        .btn-primary-custom:hover {
            background-color: var(--primary-dark);
            color: var(--white);
        }
        
        .btn-outline-custom {
            color: var(--primary-color);
            border: 2px solid var(--primary-color);
            padding: 0.875rem 2rem;
            border-radius: 0.375rem;
            font-weight: 600;
            background-color: transparent;
            transition: all 0.2s;
        }
        
        .btn-outline-custom:hover {
            background-color: var(--primary-color);
            color: var(--white);
        }
        
        /* Card Styles */
        .landing-card {
            border: 1px solid var(--gray-200);
            border-radius: 0.5rem;
            padding: 2rem;
            transition: all 0.3s;
        }
        
        .landing-card:hover {
            box-shadow: 0 0.5rem 1.5rem rgba(67, 89, 113, 0.15);
            transform: translateY(-5px);
        }
        
        .landing-card .icon {
            width: 60px;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 0.5rem;
            font-size: 1.75rem;
            margin-bottom: 1.5rem;
        }
        
        /* Utility Classes */
        .text-primary-custom {
            color: var(--primary-color) !important;
        }
        
        .bg-primary-custom {
            background-color: var(--primary-color) !important;
        }
        
        .bg-light-custom {
            background-color: var(--light-color) !important;
        }
    </style>
    
    @stack('styles')
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg landing-navbar fixed-top">
        <div class="container">
            <a class="navbar-brand" href="{{ route('landing.home') }}">
                <i class="bi bi-mortarboard-fill"></i> SisuKai
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('landing.home') ? 'active' : '' }}" href="{{ route('landing.home') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('landing.certifications.*') ? 'active' : '' }}" href="{{ route('landing.certifications.index') }}">Certifications</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('landing.pricing') ? 'active' : '' }}" href="{{ route('landing.pricing') }}">Pricing</a>
                    </li>
                </ul>
                
                <div class="d-flex gap-2">
                    @auth('learner')
                        <a href="{{ route('learner.dashboard') }}" class="btn btn-login">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-login">Login</a>
                        <a href="{{ route('register') }}" class="btn btn-trial">Start Your Free Trial Now</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>
    
    <!-- Main Content -->
    <main style="margin-top: 76px;">
        @yield('content')
    </main>
    
    <!-- Footer -->
    <footer class="landing-footer">
        <div class="container">
            <div class="row">
                <!-- Company Column -->
                <div class="col-lg-3 col-md-6 mb-4">
                    <h5>Company</h5>
                    <ul>
                        <li><a href="{{ route('landing.about') }}">About Us</a></li>
                        <li><a href="{{ route('landing.contact') }}">Contact</a></li>
                        <li><a href="{{ route('landing.blog.index') }}">Blog</a></li>
                        <li><a href="#" data-bs-toggle="modal" data-bs-target="#newsletterModal">Newsletter</a></li>
                    </ul>
                </div>
                
                <!-- Certifications Column -->
                <div class="col-lg-3 col-md-6 mb-4">
                    <h5>Certifications</h5>
                    <ul>
                        <li><a href="{{ route('landing.certifications.index') }}">All Certifications</a></li>
                        <li><a href="{{ route('landing.certifications.show', 'aws-certified-cloud-practitioner') }}">AWS Cloud Practitioner</a></li>
                        <li><a href="{{ route('landing.certifications.show', 'comptia-a-plus') }}">CompTIA A+</a></li>
                        <li><a href="{{ route('landing.certifications.show', 'pmp') }}">PMP</a></li>
                    </ul>
                </div>
                
                <!-- Legal Column -->
                <div class="col-lg-3 col-md-6 mb-4">
                    <h5>Legal</h5>
                    <ul>
                        <li><a href="{{ route('landing.legal.show', 'privacy-policy') }}">Privacy Policy</a></li>
                        <li><a href="{{ route('landing.legal.show', 'terms-of-service') }}">Terms of Service</a></li>
                        <li><a href="{{ route('landing.legal.show', 'cookie-policy') }}">Cookie Policy</a></li>
                        <li><a href="{{ route('landing.legal.show', 'acceptable-use-policy') }}">Acceptable Use Policy</a></li>
                    </ul>
                </div>
                
                <!-- Support Column -->
                <div class="col-lg-3 col-md-6 mb-4">
                    <h5>Support</h5>
                    <ul>
                        <li><a href="{{ route('landing.help.index') }}">Help Center</a></li>
                        <li><a href="{{ route('landing.contact') }}">Contact Support</a></li>
                        <li><a href="{{ route('landing.pricing') }}">Pricing</a></li>
                    </ul>
                    <div class="social-links mt-3">
                        <a href="#" aria-label="Facebook"><i class="bi bi-facebook"></i></a>
                        <a href="#" aria-label="Twitter"><i class="bi bi-twitter"></i></a>
                        <a href="#" aria-label="LinkedIn"><i class="bi bi-linkedin"></i></a>
                        <a href="#" aria-label="Instagram"><i class="bi bi-instagram"></i></a>
                    </div>
                </div>
            </div>
            
            <div class="copyright">
                <p class="mb-0">© 2025 SisuKai. All rights reserved.</p>
            </div>
        </div>
    </footer>
    
    <!-- Newsletter Modal -->
    <div class="modal fade" id="newsletterModal" tabindex="-1" aria-labelledby="newsletterModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <h5 class="modal-title" id="newsletterModalLabel">Subscribe to Our Newsletter</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p class="text-muted">Get the latest certification tips, study guides, and platform updates delivered to your inbox.</p>
                    <form id="newsletterForm">
                        @csrf
                        <div class="mb-3">
                            <label for="newsletter_email" class="form-label">Email Address</label>
                            <input type="email" class="form-control" id="newsletter_email" name="email" required>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary-custom">Subscribe</button>
                        </div>
                    </form>
                    <div id="newsletterMessage" class="mt-3" style="display: none;"></div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Newsletter Subscription Script -->
    <script>
        document.getElementById('newsletterForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const form = this;
            const email = document.getElementById('newsletter_email').value;
            const messageDiv = document.getElementById('newsletterMessage');
            const submitBtn = form.querySelector('button[type="submit"]');
            
            // Disable submit button
            submitBtn.disabled = true;
            submitBtn.textContent = 'Subscribing...';
            
            // AJAX request
            fetch('{{ route("landing.newsletter.subscribe") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ email: email })
            })
            .then(response => response.json())
            .then(data => {
                messageDiv.style.display = 'block';
                if (data.success) {
                    messageDiv.className = 'alert alert-success';
                    messageDiv.textContent = data.message;
                    form.reset();
                    setTimeout(() => {
                        bootstrap.Modal.getInstance(document.getElementById('newsletterModal')).hide();
                        messageDiv.style.display = 'none';
                    }, 2000);
                } else {
                    messageDiv.className = 'alert alert-danger';
                    messageDiv.textContent = data.message || 'An error occurred. Please try again.';
                }
            })
            .catch(error => {
                messageDiv.style.display = 'block';
                messageDiv.className = 'alert alert-danger';
                messageDiv.textContent = 'An error occurred. Please try again.';
            })
            .finally(() => {
                submitBtn.disabled = false;
                submitBtn.textContent = 'Subscribe';
            });
        });
    </script>
    
    <!-- Alpine.js for interactive components -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    @stack('scripts')
</body>
</html>
