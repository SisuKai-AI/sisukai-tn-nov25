# SisuKai Quick Start Guide

## Getting Started in 5 Minutes

### 1. Start the Development Server

```bash
cd /home/ubuntu/sisukai
php artisan serve
```

The application will be available at: **http://localhost:8000**

---

## 2. Test Credentials

### Admin Portal
**URL**: http://localhost:8000/admin/login

| Role | Email | Password |
|------|-------|----------|
| Super Admin | admin@sisukai.com | password123 |
| Content Manager | content@sisukai.com | password123 |
| Support Staff | support@sisukai.com | password123 |

### Learner Portal
**URL**: http://localhost:8000/learner/login

| Name | Email | Password |
|------|-------|----------|
| Test Learner | learner@sisukai.com | password123 |

**Registration URL**: http://localhost:8000/learner/register

---

## 3. Key Features to Test

### Admin Dashboard
✅ Login with admin credentials
✅ View statistics dashboard
✅ Check role-based access
✅ Navigate sidebar menu
✅ Test logout functionality

### Learner Dashboard
✅ Login with learner credentials
✅ View personalized dashboard
✅ Check gamification elements
✅ Test registration flow
✅ Test logout functionality

---

## 4. Database Management

### Reset Database (Fresh Start)
```bash
php artisan migrate:fresh
php artisan db:seed --class=RoleSeeder
php artisan db:seed --class=TestUserSeeder
```

### View Database
```bash
sqlite3 database/database.sqlite
.tables
SELECT * FROM users;
.quit
```

---

## 5. Project Structure Overview

```
sisukai/
├── app/Http/Controllers/
│   ├── Admin/          # Admin controllers
│   └── Learner/        # Learner controllers
├── app/Http/Middleware/
│   ├── AdminMiddleware.php
│   └── LearnerMiddleware.php
├── app/Models/
│   ├── User.php
│   └── Role.php
├── resources/views/
│   ├── admin/          # Admin views
│   ├── learner/        # Learner views
│   └── layouts/        # Layout templates
├── routes/web.php      # Application routes
└── database/
    ├── migrations/     # Database schema
    └── seeders/        # Test data
```

---

## 6. Common Commands

```bash
# Start server
php artisan serve

# Run migrations
php artisan migrate

# Seed database
php artisan db:seed

# Clear cache
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Create new controller
php artisan make:controller ControllerName

# Create new model
php artisan make:model ModelName

# Create new migration
php artisan make:migration migration_name
```

---

## 7. Next Steps

After testing the authentication system, you can proceed with:

1. **User Management** - CRUD operations for admin users
2. **Certification Management** - Create and manage certifications
3. **Question Bank** - Build question database
4. **Exam Engine** - Implement exam taking functionality
5. **Progress Tracking** - Analytics and reporting
6. **Gamification** - XP, badges, and leaderboards

---

## 8. Troubleshooting

**Server won't start?**
```bash
# Check if port 8000 is already in use
netstat -tuln | grep 8000
# Kill existing process if needed
pkill -f "php artisan serve"
```

**Database errors?**
```bash
# Reset database
php artisan migrate:fresh --seed
```

**Can't login?**
```bash
# Verify test users exist
php artisan db:seed --class=TestUserSeeder
```

---

## Support

For detailed documentation, see **SISUKAI_AUTHENTICATION_DOCUMENTATION.md**

