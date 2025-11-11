# SisuKai Authentication System Documentation

## Project Overview

**SisuKai** is a full-stack Laravel 12 web application designed for certification exam preparation. The platform features separate authentication portals for administrators and learners, with role-based access control and a modern Bootstrap 5 interface.

---

## Technology Stack

- **Framework**: Laravel 12
- **PHP Version**: 8.3
- **Database**: SQLite
- **Frontend**: Bootstrap 5.3.2, Bootstrap Icons
- **Authentication**: Laravel's built-in authentication with custom middleware

---

## Database Schema

### Tables Created

#### 1. **users** (Extended Laravel default)
- `id` - Primary key
- `name` - User's full name
- `email` - Unique email address
- `password` - Hashed password
- `user_type` - ENUM('admin', 'learner') - Determines portal access
- `email_verified_at` - Timestamp
- `remember_token` - For "Remember Me" functionality
- `created_at` / `updated_at` - Timestamps

#### 2. **roles**
- `id` - Primary key
- `name` - Role identifier (super_admin, content_manager, support_staff)
- `display_name` - Human-readable role name
- `description` - Role description
- `created_at` / `updated_at` - Timestamps

#### 3. **user_roles** (Pivot Table)
- `id` - Primary key
- `user_id` - Foreign key to users table
- `role_id` - Foreign key to roles table
- `created_at` / `updated_at` - Timestamps

---

## Authentication Architecture

### Admin Portal
- **Login Route**: `/admin/login`
- **Dashboard Route**: `/admin/dashboard`
- **Middleware**: `AdminMiddleware` - Ensures only users with `user_type = 'admin'` can access
- **Features**:
  - Role-based access (Super Admin, Content Manager, Support Staff)
  - Sidebar navigation
  - Statistics dashboard
  - User management interface (placeholder)

### Learner Portal
- **Login Route**: `/learner/login`
- **Registration Route**: `/learner/register`
- **Dashboard Route**: `/learner/dashboard`
- **Middleware**: `LearnerMiddleware` - Ensures only users with `user_type = 'learner'` can access
- **Features**:
  - Self-registration capability
  - Certification tracking
  - Practice sessions
  - Progress monitoring
  - Gamification elements (streaks, XP)

---

## Roles and Permissions

### Admin Roles

#### 1. Super Admin
- **Name**: `super_admin`
- **Display Name**: Super Admin
- **Description**: Full system access with all administrative privileges
- **Capabilities**: Complete control over all platform features

#### 2. Content Manager
- **Name**: `content_manager`
- **Display Name**: Content Manager
- **Description**: Manages educational content and certifications
- **Capabilities**: Create/edit certifications, questions, and study materials

#### 3. Support Staff
- **Name**: `support_staff`
- **Display Name**: Support Staff
- **Description**: Provides learner support and assistance
- **Capabilities**: View learner data, respond to inquiries

---

## Test Accounts

### Admin Accounts

| Role | Email | Password | User Type |
|------|-------|----------|-----------|
| Super Admin | admin@sisukai.com | password123 | admin |
| Content Manager | content@sisukai.com | password123 | admin |
| Support Staff | support@sisukai.com | password123 | admin |

### Learner Account

| Name | Email | Password | User Type |
|------|-------|----------|-----------|
| Test Learner | learner@sisukai.com | password123 | learner |

---

## Routes Structure

### Public Routes
```php
Route::get('/', function () {
    return view('welcome');
});
```

### Admin Routes
```php
Route::prefix('admin')->group(function () {
    // Authentication routes
    Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [AdminAuthController::class, 'login']);
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');
    
    // Protected routes
    Route::middleware('admin')->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    });
});
```

### Learner Routes
```php
Route::prefix('learner')->group(function () {
    // Authentication routes
    Route::get('/login', [LearnerAuthController::class, 'showLoginForm'])->name('learner.login');
    Route::post('/login', [LearnerAuthController::class, 'login']);
    Route::get('/register', [LearnerAuthController::class, 'showRegisterForm'])->name('learner.register.form');
    Route::post('/register', [LearnerAuthController::class, 'register'])->name('learner.register');
    Route::post('/logout', [LearnerAuthController::class, 'logout'])->name('learner.logout');
    
    // Protected routes
    Route::middleware('learner')->group(function () {
        Route::get('/dashboard', [LearnerDashboardController::class, 'index'])->name('learner.dashboard');
    });
});
```

---

## Middleware Implementation

### AdminMiddleware
- Checks if user is authenticated
- Verifies `user_type === 'admin'`
- Redirects to admin login if unauthorized
- Located at: `app/Http/Middleware/AdminMiddleware.php`

### LearnerMiddleware
- Checks if user is authenticated
- Verifies `user_type === 'learner'`
- Redirects to learner login if unauthorized
- Located at: `app/Http/Middleware/LearnerMiddleware.php`

---

## Controllers

### Admin Controllers

#### AdminAuthController
- `showLoginForm()` - Display admin login page
- `login()` - Process admin authentication
- `logout()` - End admin session

#### AdminDashboardController
- `index()` - Display admin dashboard with statistics

### Learner Controllers

#### LearnerAuthController
- `showLoginForm()` - Display learner login page
- `login()` - Process learner authentication
- `showRegisterForm()` - Display registration form
- `register()` - Process new learner registration
- `logout()` - End learner session

#### LearnerDashboardController
- `index()` - Display learner dashboard with personalized content

---

## Models

### User Model
**Location**: `app/Models/User.php`

**Relationships**:
```php
public function roles()
{
    return $this->belongsToMany(Role::class, 'user_roles');
}
```

**Methods**:
```php
public function hasRole($roleName)
{
    return $this->roles()->where('name', $roleName)->exists();
}
```

**Fillable Fields**:
- name, email, password, user_type

### Role Model
**Location**: `app/Models/Role.php`

**Relationships**:
```php
public function users()
{
    return $this->belongsToMany(User::class, 'user_roles');
}
```

**Fillable Fields**:
- name, display_name, description

---

## Views Structure

### Layouts

#### Base Layout (`layouts/app.blade.php`)
- Used for authentication pages
- Clean, centered design
- Bootstrap 5 styling

#### Admin Layout (`layouts/admin.blade.php`)
- Sidebar navigation
- Top navbar with user dropdown
- Dark sidebar theme
- Responsive mobile menu

#### Learner Layout (`layouts/learner.blade.php`)
- Top navigation bar
- User-friendly interface
- Gamification elements
- Responsive design

### Admin Views

#### Login (`admin/auth/login.blade.php`)
- Email and password fields
- Remember me checkbox
- Professional admin styling

#### Dashboard (`admin/dashboard.blade.php`)
- Welcome message
- Statistics cards (Total Learners, Active Users, Certifications, Questions)
- Recent activity section
- Quick actions panel
- System information display

### Learner Views

#### Login (`learner/auth/login.blade.php`)
- Email and password fields
- Remember me checkbox
- Link to registration
- Friendly, welcoming design

#### Registration (`learner/auth/register.blade.php`)
- Full name, email, password fields
- Password confirmation
- Terms acceptance
- Link back to login

#### Dashboard (`learner/dashboard.blade.php`)
- Personalized welcome message
- Quick stats (Certifications, Practice Sessions, Average Score)
- Study streak tracker
- Today's study plan
- Upcoming exams
- Performance overview
- Quick action buttons

---

## Security Features

### Password Security
- All passwords are hashed using Laravel's `Hash` facade (bcrypt)
- Minimum 8 characters enforced in validation

### CSRF Protection
- All forms include `@csrf` token
- Laravel automatically validates CSRF tokens on POST requests

### Authentication Guards
- Separate middleware for admin and learner portals
- Session-based authentication
- "Remember Me" functionality available

### Access Control
- User type verification at middleware level
- Role-based permissions for admin users
- Redirect to appropriate login page if unauthorized

---

## Running the Application

### Start Development Server
```bash
cd /home/ubuntu/sisukai
php artisan serve --host=0.0.0.0 --port=8000
```

### Access the Application
- **Admin Login**: http://localhost:8000/admin/login
- **Learner Login**: http://localhost:8000/learner/login
- **Learner Registration**: http://localhost:8000/learner/register

### Database Commands
```bash
# Run migrations
php artisan migrate

# Seed roles
php artisan db:seed --class=RoleSeeder

# Seed test users
php artisan db:seed --class=TestUserSeeder

# Reset database (fresh start)
php artisan migrate:fresh --seed
```

---

## Project Structure

```
sisukai/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/
│   │   │   │   ├── AuthController.php
│   │   │   │   └── DashboardController.php
│   │   │   └── Learner/
│   │   │       ├── AuthController.php
│   │   │       └── DashboardController.php
│   │   └── Middleware/
│   │       ├── AdminMiddleware.php
│   │       └── LearnerMiddleware.php
│   └── Models/
│       ├── User.php
│       └── Role.php
├── database/
│   ├── migrations/
│   │   ├── 2025_10_25_013848_create_roles_table.php
│   │   ├── 2025_10_25_013853_create_user_roles_table.php
│   │   └── 2025_10_25_013856_add_user_type_to_users_table.php
│   └── seeders/
│       ├── RoleSeeder.php
│       └── TestUserSeeder.php
├── resources/
│   └── views/
│       ├── layouts/
│       │   ├── app.blade.php
│       │   ├── admin.blade.php
│       │   └── learner.blade.php
│       ├── admin/
│       │   ├── auth/
│       │   │   └── login.blade.php
│       │   └── dashboard.blade.php
│       └── learner/
│           ├── auth/
│           │   ├── login.blade.php
│           │   └── register.blade.php
│           └── dashboard.blade.php
├── routes/
│   └── web.php
└── bootstrap/
    └── app.php (middleware registration)
```

---

## Features Implemented

### ✅ Completed Features

1. **Database Schema**
   - User table with user_type field
   - Roles table with predefined admin roles
   - User-roles pivot table for many-to-many relationship

2. **Authentication System**
   - Separate login for admin and learner portals
   - Learner self-registration
   - Session-based authentication
   - Remember me functionality
   - Logout functionality

3. **Middleware Protection**
   - AdminMiddleware for admin routes
   - LearnerMiddleware for learner routes
   - Automatic redirection for unauthorized access

4. **Admin Portal**
   - Professional dashboard layout
   - Sidebar navigation
   - Statistics overview
   - Role display
   - User management placeholder

5. **Learner Portal**
   - User-friendly dashboard
   - Gamification elements (streaks, XP)
   - Certification tracking placeholder
   - Practice session placeholder
   - Progress monitoring placeholder

6. **Responsive Design**
   - Mobile-friendly layouts
   - Bootstrap 5 responsive grid
   - Collapsible mobile menus

7. **Test Data**
   - Seeded admin roles
   - Test users for all roles
   - Sample learner account

---

## Future Enhancements

### Phase 2: Content Management
- Certification CRUD operations
- Question bank management
- Topic and domain structure
- Media upload and management

### Phase 3: Learning Features
- Exam taking functionality
- Practice mode
- Spaced repetition algorithm
- Progress tracking
- Performance analytics

### Phase 4: Gamification
- XP and leveling system
- Achievement badges
- Leaderboards
- Study streaks
- Rewards system

### Phase 5: Advanced Features
- AI-powered content generation
- Adaptive learning paths
- Notification system
- Email integration
- Payment and subscription management
- Mobile app API

---

## Testing Instructions

### Manual Testing

#### Test Admin Login
1. Navigate to http://localhost:8000/admin/login
2. Enter email: `admin@sisukai.com`
3. Enter password: `password123`
4. Click "Login"
5. Verify redirect to admin dashboard
6. Check that sidebar shows "SisuKai Admin"
7. Verify role badge displays "Super Admin"

#### Test Learner Registration
1. Navigate to http://localhost:8000/learner/register
2. Fill in all fields with valid data
3. Click "Create Account"
4. Verify redirect to learner dashboard
5. Check welcome message shows correct name

#### Test Learner Login
1. Navigate to http://localhost:8000/learner/login
2. Enter email: `learner@sisukai.com`
3. Enter password: `password123`
4. Click "Login"
5. Verify redirect to learner dashboard
6. Check personalized welcome message

#### Test Access Control
1. While logged in as learner, try to access `/admin/dashboard`
2. Verify redirect to admin login page
3. While logged in as admin, try to access `/learner/dashboard`
4. Verify redirect to learner login page

#### Test Logout
1. Click on user dropdown in navbar
2. Click "Logout"
3. Verify redirect to login page
4. Try to access dashboard directly
5. Verify redirect back to login

---

## Configuration

### Environment Variables
The application uses SQLite database configured in `.env`:
```
DB_CONNECTION=sqlite
DB_DATABASE=/home/ubuntu/sisukai/database/database.sqlite
```

### Session Configuration
- Driver: file
- Lifetime: 120 minutes
- Secure: false (for development)

---

## Troubleshooting

### Common Issues

**Issue**: "SQLSTATE[HY000]: General error: 1 no such table"
**Solution**: Run `php artisan migrate`

**Issue**: "Class 'Role' not found"
**Solution**: Run `composer dump-autoload`

**Issue**: "The page has expired" on form submission
**Solution**: Clear browser cache or use incognito mode

**Issue**: Can't access dashboard after login
**Solution**: Check that user_type matches the portal (admin/learner)

---

## Credits

**Developed by**: Manus AI Agent
**Framework**: Laravel 12
**Date**: October 25, 2025
**Version**: 1.0.0 - Authentication Module

---

## License

This project is proprietary software developed for SisuKai certification exam preparation platform.

---

## Support

For issues or questions regarding the authentication system, please refer to the Laravel documentation or contact the development team.

**Laravel Documentation**: https://laravel.com/docs/12.x
**Bootstrap Documentation**: https://getbootstrap.com/docs/5.3

