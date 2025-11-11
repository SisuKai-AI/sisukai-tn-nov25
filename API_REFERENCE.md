# SisuKai Authentication API Reference

## Overview

This document provides a technical reference for the authentication system implemented in SisuKai.

---

## Routes

### Admin Routes

#### GET `/admin/login`
Display the admin login form.

**Response**: HTML view
**View**: `resources/views/admin/auth/login.blade.php`
**Middleware**: None (public)

---

#### POST `/admin/login`
Process admin login credentials.

**Request Body**:
```php
[
    'email' => 'required|email',
    'password' => 'required',
    'remember' => 'optional|boolean'
]
```

**Success Response**: Redirect to `/admin/dashboard`
**Error Response**: Redirect back with validation errors
**Controller**: `App\Http\Controllers\Admin\AuthController@login`

---

#### POST `/admin/logout`
Logout the authenticated admin user.

**Request**: Authenticated admin session
**Response**: Redirect to `/admin/login`
**Middleware**: `auth`
**Controller**: `App\Http\Controllers\Admin\AuthController@logout`

---

#### GET `/admin/dashboard`
Display the admin dashboard.

**Response**: HTML view
**View**: `resources/views/admin/dashboard.blade.php`
**Middleware**: `auth`, `admin`
**Controller**: `App\Http\Controllers\Admin\DashboardController@index`

---

### Learner Routes

#### GET `/learner/login`
Display the learner login form.

**Response**: HTML view
**View**: `resources/views/learner/auth/login.blade.php`
**Middleware**: None (public)

---

#### POST `/learner/login`
Process learner login credentials.

**Request Body**:
```php
[
    'email' => 'required|email',
    'password' => 'required',
    'remember' => 'optional|boolean'
]
```

**Success Response**: Redirect to `/learner/dashboard`
**Error Response**: Redirect back with validation errors
**Controller**: `App\Http\Controllers\Learner\AuthController@login`

---

#### GET `/learner/register`
Display the learner registration form.

**Response**: HTML view
**View**: `resources/views/learner/auth/register.blade.php`
**Middleware**: None (public)

---

#### POST `/learner/register`
Process learner registration.

**Request Body**:
```php
[
    'name' => 'required|string|max:255',
    'email' => 'required|email|unique:users,email',
    'password' => 'required|min:8|confirmed'
]
```

**Success Response**: Redirect to `/learner/dashboard` with auto-login
**Error Response**: Redirect back with validation errors
**Controller**: `App\Http\Controllers\Learner\AuthController@register`

---

#### POST `/learner/logout`
Logout the authenticated learner user.

**Request**: Authenticated learner session
**Response**: Redirect to `/learner/login`
**Middleware**: `auth`
**Controller**: `App\Http\Controllers\Learner\AuthController@logout`

---

#### GET `/learner/dashboard`
Display the learner dashboard.

**Response**: HTML view
**View**: `resources/views/learner/dashboard.blade.php`
**Middleware**: `auth`, `learner`
**Controller**: `App\Http\Controllers\Learner\DashboardController@index`

---

## Middleware

### AdminMiddleware

**Class**: `App\Http\Middleware\AdminMiddleware`
**Purpose**: Restrict access to admin-only routes

**Logic**:
```php
public function handle(Request $request, Closure $next)
{
    if (!auth()->check()) {
        return redirect()->route('admin.login')
            ->with('error', 'Please login to access admin portal.');
    }
    
    if (auth()->user()->user_type !== 'admin') {
        return redirect()->route('admin.login')
            ->with('error', 'You must be logged in as an admin to access this page.');
    }
    
    return $next($request);
}
```

**Registration**:
```php
// bootstrap/app.php
->withMiddleware(function (Middleware $middleware) {
    $middleware->alias([
        'admin' => \App\Http\Middleware\AdminMiddleware::class,
    ]);
})
```

---

### LearnerMiddleware

**Class**: `App\Http\Middleware\LearnerMiddleware`
**Purpose**: Restrict access to learner-only routes

**Logic**:
```php
public function handle(Request $request, Closure $next)
{
    if (!auth()->check()) {
        return redirect()->route('learner.login')
            ->with('error', 'Please login to access your dashboard.');
    }
    
    if (auth()->user()->user_type !== 'learner') {
        return redirect()->route('learner.login')
            ->with('error', 'You must be logged in as a learner to access this page.');
    }
    
    return $next($request);
}
```

**Registration**:
```php
// bootstrap/app.php
->withMiddleware(function (Middleware $middleware) {
    $middleware->alias([
        'learner' => \App\Http\Middleware\LearnerMiddleware::class,
    ]);
})
```

---

## Models

### User Model

**Class**: `App\Models\User`
**Table**: `users`

**Fillable Attributes**:
```php
protected $fillable = [
    'name',
    'email',
    'password',
    'user_type',
];
```

**Hidden Attributes**:
```php
protected $hidden = [
    'password',
    'remember_token',
];
```

**Casts**:
```php
protected function casts(): array
{
    return [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
}
```

**Relationships**:
```php
// Many-to-many relationship with roles
public function roles()
{
    return $this->belongsToMany(Role::class, 'user_roles');
}
```

**Methods**:
```php
// Check if user has a specific role
public function hasRole($roleName)
{
    return $this->roles()->where('name', $roleName)->exists();
}
```

---

### Role Model

**Class**: `App\Models\Role`
**Table**: `roles`

**Fillable Attributes**:
```php
protected $fillable = [
    'name',
    'display_name',
    'description',
];
```

**Relationships**:
```php
// Many-to-many relationship with users
public function users()
{
    return $this->belongsToMany(User::class, 'user_roles');
}
```

---

## Controllers

### Admin\AuthController

**Class**: `App\Http\Controllers\Admin\AuthController`

#### Methods

##### `showLoginForm()`
```php
public function showLoginForm()
{
    return view('admin.auth.login');
}
```

##### `login(Request $request)`
```php
public function login(Request $request)
{
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);
    
    $remember = $request->has('remember');
    
    if (Auth::attempt($credentials, $remember)) {
        if (Auth::user()->user_type === 'admin') {
            $request->session()->regenerate();
            return redirect()->intended(route('admin.dashboard'));
        }
        
        Auth::logout();
        return back()->withErrors([
            'email' => 'You must be an admin to access this portal.',
        ])->onlyInput('email');
    }
    
    return back()->withErrors([
        'email' => 'The provided credentials do not match our records.',
    ])->onlyInput('email');
}
```

##### `logout(Request $request)`
```php
public function logout(Request $request)
{
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    
    return redirect()->route('admin.login');
}
```

---

### Admin\DashboardController

**Class**: `App\Http\Controllers\Admin\DashboardController`

#### Methods

##### `index()`
```php
public function index()
{
    return view('admin.dashboard');
}
```

---

### Learner\AuthController

**Class**: `App\Http\Controllers\Learner\AuthController`

#### Methods

##### `showLoginForm()`
```php
public function showLoginForm()
{
    return view('learner.auth.login');
}
```

##### `login(Request $request)`
```php
public function login(Request $request)
{
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);
    
    $remember = $request->has('remember');
    
    if (Auth::attempt($credentials, $remember)) {
        if (Auth::user()->user_type === 'learner') {
            $request->session()->regenerate();
            return redirect()->intended(route('learner.dashboard'));
        }
        
        Auth::logout();
        return back()->withErrors([
            'email' => 'You must be a learner to access this portal.',
        ])->onlyInput('email');
    }
    
    return back()->withErrors([
        'email' => 'The provided credentials do not match our records.',
    ])->onlyInput('email');
}
```

##### `showRegisterForm()`
```php
public function showRegisterForm()
{
    return view('learner.auth.register');
}
```

##### `register(Request $request)`
```php
public function register(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:8|confirmed',
    ]);
    
    $user = User::create([
        'name' => $validated['name'],
        'email' => $validated['email'],
        'password' => Hash::make($validated['password']),
        'user_type' => 'learner',
    ]);
    
    Auth::login($user);
    
    return redirect()->route('learner.dashboard');
}
```

##### `logout(Request $request)`
```php
public function logout(Request $request)
{
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    
    return redirect()->route('learner.login');
}
```

---

### Learner\DashboardController

**Class**: `App\Http\Controllers\Learner\DashboardController`

#### Methods

##### `index()`
```php
public function index()
{
    return view('learner.dashboard');
}
```

---

## Database Schema

### users Table

```sql
CREATE TABLE users (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    email_verified_at TIMESTAMP NULL,
    password VARCHAR(255) NOT NULL,
    user_type VARCHAR(255) NOT NULL DEFAULT 'learner',
    remember_token VARCHAR(100) NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);
```

---

### roles Table

```sql
CREATE TABLE roles (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name VARCHAR(255) NOT NULL UNIQUE,
    display_name VARCHAR(255) NOT NULL,
    description TEXT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);
```

---

### user_roles Table

```sql
CREATE TABLE user_roles (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    user_id INTEGER NOT NULL,
    role_id INTEGER NOT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (role_id) REFERENCES roles(id) ON DELETE CASCADE
);
```

---

## Validation Rules

### Admin Login
```php
[
    'email' => 'required|email',
    'password' => 'required',
]
```

### Learner Login
```php
[
    'email' => 'required|email',
    'password' => 'required',
]
```

### Learner Registration
```php
[
    'name' => 'required|string|max:255',
    'email' => 'required|string|email|max:255|unique:users',
    'password' => 'required|string|min:8|confirmed',
]
```

---

## Error Messages

### Authentication Errors
- `"Please login to access admin portal."` - Unauthenticated admin access attempt
- `"You must be logged in as an admin to access this page."` - Learner trying to access admin portal
- `"Please login to access your dashboard."` - Unauthenticated learner access attempt
- `"You must be logged in as a learner to access this page."` - Admin trying to access learner portal
- `"The provided credentials do not match our records."` - Invalid login credentials
- `"You must be an admin to access this portal."` - Non-admin user trying to login to admin portal
- `"You must be a learner to access this portal."` - Non-learner user trying to login to learner portal

### Validation Errors
- Email field: `"The email field is required."`, `"The email must be a valid email address."`
- Password field: `"The password field is required."`, `"The password must be at least 8 characters."`
- Name field: `"The name field is required."`
- Password confirmation: `"The password confirmation does not match."`

---

## Session Management

### Session Variables
- `_token` - CSRF token
- `_previous` - Previous URL for redirects
- `_flash` - Flash messages
- `login_web_*` - Authentication session data

### Session Methods
```php
// Regenerate session (after login)
$request->session()->regenerate();

// Invalidate session (after logout)
$request->session()->invalidate();

// Regenerate CSRF token (after logout)
$request->session()->regenerateToken();
```

---

## Helper Methods

### Check User Type
```php
// In controller or view
auth()->user()->user_type === 'admin'
auth()->user()->user_type === 'learner'
```

### Check User Role
```php
// In controller or view
auth()->user()->hasRole('super_admin')
auth()->user()->hasRole('content_manager')
auth()->user()->hasRole('support_staff')
```

### Check Authentication
```php
// In controller
auth()->check() // Returns true if authenticated

// In view
@auth
    // User is authenticated
@endauth

@guest
    // User is not authenticated
@endguest
```

---

## Blade Directives

### Authentication Checks
```blade
@auth
    <p>Welcome, {{ auth()->user()->name }}</p>
@endauth

@guest
    <a href="{{ route('learner.login') }}">Login</a>
@endguest
```

### CSRF Protection
```blade
<form method="POST" action="{{ route('admin.login') }}">
    @csrf
    <!-- Form fields -->
</form>
```

### Error Display
```blade
@error('email')
    <div class="invalid-feedback">{{ $message }}</div>
@enderror

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
```

### Flash Messages
```blade
@if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
```

---

## Testing Examples

### Manual cURL Testing

#### Admin Login
```bash
curl -X POST http://localhost:8000/admin/login \
  -H "Content-Type: application/x-www-form-urlencoded" \
  -d "email=admin@sisukai.com&password=password123&_token=YOUR_CSRF_TOKEN" \
  -c cookies.txt
```

#### Learner Registration
```bash
curl -X POST http://localhost:8000/learner/register \
  -H "Content-Type: application/x-www-form-urlencoded" \
  -d "name=John Doe&email=john@example.com&password=password123&password_confirmation=password123&_token=YOUR_CSRF_TOKEN" \
  -c cookies.txt
```

---

## Security Considerations

1. **Password Hashing**: All passwords are hashed using bcrypt
2. **CSRF Protection**: All POST requests require valid CSRF token
3. **Session Security**: Sessions are regenerated after login
4. **Input Validation**: All user inputs are validated
5. **SQL Injection Prevention**: Eloquent ORM prevents SQL injection
6. **XSS Prevention**: Blade templates auto-escape output
7. **Authentication Guards**: Middleware prevents unauthorized access

---

## Performance Considerations

1. **Database Queries**: Use eager loading for relationships
2. **Session Storage**: File-based sessions for development
3. **Password Hashing**: Bcrypt with appropriate cost factor
4. **Route Caching**: Use `php artisan route:cache` in production

---

## Future API Endpoints

### Planned Endpoints
- `/api/v1/auth/login` - API authentication
- `/api/v1/auth/register` - API registration
- `/api/v1/auth/logout` - API logout
- `/api/v1/user/profile` - User profile management
- `/api/v1/certifications` - Certification management
- `/api/v1/exams` - Exam management
- `/api/v1/questions` - Question bank management

---

## Version History

- **v1.0.0** (October 25, 2025) - Initial authentication system implementation

---

## References

- Laravel 12 Documentation: https://laravel.com/docs/12.x
- Laravel Authentication: https://laravel.com/docs/12.x/authentication
- Laravel Middleware: https://laravel.com/docs/12.x/middleware
- Laravel Validation: https://laravel.com/docs/12.x/validation

