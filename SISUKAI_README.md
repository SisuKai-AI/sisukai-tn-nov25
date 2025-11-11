# SisuKai - Certification Exam Preparation Platform

![Laravel](https://img.shields.io/badge/Laravel-12-red)
![PHP](https://img.shields.io/badge/PHP-8.3-blue)
![Bootstrap](https://img.shields.io/badge/Bootstrap-5.3-purple)
![License](https://img.shields.io/badge/License-Proprietary-yellow)

## Overview

**SisuKai** is a comprehensive certification exam preparation platform built with Laravel 12. The application provides separate portals for administrators and learners, featuring role-based access control, modern UI design, and a scalable architecture for future enhancements.

## Current Status

**Phase 1: Authentication System** ✅ **COMPLETED**

The authentication module has been fully implemented and tested, providing a solid foundation for future development.

## Quick Start

```bash
# Start the server
php artisan serve

# Access the application
# Admin: http://localhost:8000/admin/login
# Learner: http://localhost:8000/learner/login
```

**Test Credentials:**
- Admin: `admin@sisukai.com` / `password123`
- Learner: `learner@sisukai.com` / `password123`

## Features Implemented ✅

- **Dual Portal System** - Separate admin and learner interfaces
- **Authentication & Authorization** - Secure login/logout with session management
- **Role Management** - Super Admin, Content Manager, Support Staff roles
- **Responsive UI** - Bootstrap 5 design, mobile-optimized
- **Database Architecture** - SQLite with proper relationships

## Documentation

- **[SISUKAI_AUTHENTICATION_DOCUMENTATION.md](SISUKAI_AUTHENTICATION_DOCUMENTATION.md)** - Complete technical documentation
- **[QUICK_START_GUIDE.md](QUICK_START_GUIDE.md)** - Get started in 5 minutes
- **[API_REFERENCE.md](API_REFERENCE.md)** - API and code reference

## Technology Stack

- Laravel 12
- PHP 8.3
- SQLite
- Bootstrap 5.3.2
- Bootstrap Icons

## Project Structure

```
sisukai/
├── app/Http/Controllers/
│   ├── Admin/          # Admin controllers
│   └── Learner/        # Learner controllers
├── app/Http/Middleware/
│   ├── AdminMiddleware.php
│   └── LearnerMiddleware.php
├── resources/views/
│   ├── admin/          # Admin views
│   ├── learner/        # Learner views
│   └── layouts/        # Layout templates
└── database/
    ├── migrations/     # Database schema
    └── seeders/        # Test data
```

## Key Commands

```bash
# Start server
php artisan serve

# Reset database
php artisan migrate:fresh --seed

# Clear cache
php artisan cache:clear
```

## Next Steps (Future Phases)

- **Phase 2**: Content Management (Certifications, Questions)
- **Phase 3**: Learning Features (Exams, Practice, Analytics)
- **Phase 4**: Gamification (XP, Badges, Leaderboards)
- **Phase 5**: Advanced Features (AI, Adaptive Learning, API)

## Version

**1.0.0** - Authentication Module (October 25, 2025)

---

**SisuKai** - Empowering learners to achieve certification success.

