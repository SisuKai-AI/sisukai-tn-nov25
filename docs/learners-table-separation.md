# Learners Table Separation

## Overview

This document describes the separation of learner accounts from the `users` table into a dedicated `learners` table. This architectural change provides better data organization, improved security, and clearer separation of concerns between admin users and learner accounts.

## Motivation

Previously, both admin users and learners were stored in the same `users` table, differentiated only by a `user_type` column. While functional, this approach had several limitations:

1. **Mixed Concerns**: Admin and learner data were intermingled in the same table
2. **Complex Queries**: Required filtering by `user_type` in every query
3. **Security**: Increased risk of accidentally exposing admin data through learner endpoints
4. **Scalability**: As learner-specific features grow, the users table would become bloated
5. **Clarity**: Code readability suffered from constant type checking

## Solution

Separate learners into their own dedicated table with:
- Independent authentication guard
- Dedicated Eloquent model
- Clean separation of concerns
- Simplified queries and relationships

---

## Database Changes

### New Table: `learners`

**Schema** (identical to users table structure):

```sql
CREATE TABLE learners (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    email_verified_at TIMESTAMP NULL,
    password VARCHAR(255) NOT NULL,
    status ENUM('active', 'disabled') DEFAULT 'active',
    remember_token VARCHAR(100) NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);
```

**Key Differences from Users Table:**
- No `user_type` column (all records are learners)
- Retains `status` column for account management
- Same authentication fields (email, password, remember_token)

### Data Migration

The migration automatically:
1. Creates the `learners` table
2. Copies all records where `user_type = 'learner'` from `users` to `learners`
3. Deletes learner records from `users` table
4. Preserves all data including IDs, timestamps, and status

**Migration File**: `database/migrations/2025_10_26_015649_create_learners_table.php`

**Rollback Support**: The migration includes a `down()` method that reverses the process:
1. Copies all learner records back to `users` table
2. Sets `user_type = 'learner'` for migrated records
3. Drops the `learners` table

---

## Model Changes

### New Model: `Learner`

**File**: `app/Models/Learner.php`

**Key Features:**
- Extends `Illuminate\Foundation\Auth\User` (Authenticatable)
- Includes `HasFactory` and `Notifiable` traits
- Mass assignable: `name`, `email`, `password`, `status`
- Hidden fields: `password`, `remember_token`
- Automatic password hashing via cast
- Helper methods: `isActive()`, `isDisabled()`

**Example Usage:**

```php
// Create a new learner
$learner = Learner::create([
    'name' => 'John Doe',
    'email' => 'john@example.com',
    'password' => Hash::make('password123'),
]);

// Check status
if ($learner->isActive()) {
    // Allow access
}

// Toggle status
$learner->status = 'disabled';
$learner->save();
```

---

## Authentication Changes

### New Guard: `learner`

**Configuration**: `config/auth.php`

```php
'guards' => [
    'web' => [
        'driver' => 'session',
        'provider' => 'users',
    ],
    
    'learner' => [
        'driver' => 'session',
        'provider' => 'learners',
    ],
],

'providers' => [
    'users' => [
        'driver' => 'eloquent',
        'model' => App\Models\User::class,
    ],
    
    'learners' => [
        'driver' => 'eloquent',
        'model' => App\Models\Learner::class,
    ],
],
```

### Authentication Usage

**Login:**
```php
// Learner login
if (Auth::guard('learner')->attempt($credentials, $remember)) {
    // Success
}

// Admin login (unchanged)
if (Auth::attempt($credentials, $remember)) {
    // Success
}
```

**Check Authentication:**
```php
// Check if learner is authenticated
if (auth('learner')->check()) {
    $learner = auth('learner')->user();
}

// Check if admin is authenticated
if (auth()->check()) {
    $admin = auth()->user();
}
```

**Logout:**
```php
// Learner logout
Auth::guard('learner')->logout();

// Admin logout
Auth::logout();
```

---

## Controller Changes

### LearnerController (Admin)

**File**: `app/Http/Controllers/Admin/LearnerController.php`

**Changes:**
1. Import `Learner` model instead of `User`
2. Remove `where('user_type', 'learner')` filters
3. Remove `user_type` checks in methods
4. Update email validation to use `learners` table
5. Type-hint `Learner` instead of `User` in method signatures

**Before:**
```php
use App\Models\User;

public function index(Request $request)
{
    $query = User::where('user_type', 'learner');
    // ...
}

public function show(User $learner)
{
    if ($learner->user_type !== 'learner') {
        abort(404);
    }
    // ...
}
```

**After:**
```php
use App\Models\Learner;

public function index(Request $request)
{
    $query = Learner::query();
    // ...
}

public function show(Learner $learner)
{
    return view('admin.learners.show', compact('learner'));
}
```

### AuthController (Learner)

**File**: `app/Http/Controllers/Learner/AuthController.php`

**Changes:**
1. Import `Learner` model instead of `User`
2. Use `learner` guard for all auth operations
3. Remove `user_type` assignment
4. Update email validation to use `learners` table

**Before:**
```php
use App\Models\User;

public function register(Request $request)
{
    $user = User::create([
        'name' => $validated['name'],
        'email' => $validated['email'],
        'password' => Hash::make($validated['password']),
        'user_type' => 'learner',
    ]);
    
    Auth::login($user);
}

public function login(Request $request)
{
    $user = User::where('email', $credentials['email'])->first();
    
    if (!$user || $user->user_type !== 'learner') {
        return back()->withErrors([...]);
    }
    
    if (Auth::attempt($credentials, $remember)) {
        // ...
    }
}
```

**After:**
```php
use App\Models\Learner;

public function register(Request $request)
{
    $learner = Learner::create([
        'name' => $validated['name'],
        'email' => $validated['email'],
        'password' => Hash::make($validated['password']),
    ]);
    
    Auth::guard('learner')->login($learner);
}

public function login(Request $request)
{
    if (Auth::guard('learner')->attempt($credentials, $remember)) {
        // ...
    }
}
```

---

## Middleware Changes

### LearnerMiddleware

**File**: `app/Http/Middleware/LearnerMiddleware.php`

**Changes:**
- Use `auth('learner')` instead of `auth()`
- Remove `isLearner()` check (no longer needed)

**Before:**
```php
public function handle(Request $request, Closure $next): Response
{
    if (!auth()->check() || !auth()->user()->isLearner()) {
        return redirect('/learner/login')->with('error', '...');
    }
    
    return $next($request);
}
```

**After:**
```php
public function handle(Request $request, Closure $next): Response
{
    if (!auth('learner')->check()) {
        return redirect('/learner/login')->with('error', '...');
    }
    
    return $next($request);
}
```

---

## Benefits

### 1. **Improved Security**
- Learner and admin authentication are completely separate
- No risk of accidentally querying admin data through learner endpoints
- Each guard has its own session and authentication state

### 2. **Better Performance**
- No need to filter by `user_type` in every query
- Smaller table sizes for both users and learners
- More efficient indexes

### 3. **Cleaner Code**
- No type checking required
- More readable and maintainable
- Clear separation of concerns
- Type safety with Eloquent models

### 4. **Scalability**
- Easy to add learner-specific columns without affecting users table
- Can optimize each table independently
- Simpler to add learner-specific features

### 5. **Flexibility**
- Can have different authentication rules for learners
- Can implement different password policies
- Can add learner-specific fields easily

---

## Migration Guide

### For Existing Installations

1. **Backup Database**
   ```bash
   php artisan db:backup  # If available
   # Or manually backup database/database.sqlite
   ```

2. **Run Migration**
   ```bash
   php artisan migrate
   ```

3. **Verify Data**
   - Check admin learners page: `/admin/learners`
   - Verify learner count matches previous count
   - Test learner login functionality

4. **Clear Caches**
   ```bash
   php artisan cache:clear
   php artisan config:clear
   php artisan route:clear
   ```

### Rollback (If Needed)

```bash
php artisan migrate:rollback
```

This will:
- Copy all learners back to users table
- Set `user_type = 'learner'` for migrated records
- Drop the learners table

---

## Testing Checklist

- [ ] Admin can view learners list
- [ ] Admin can view learner details
- [ ] Admin can create new learner
- [ ] Admin can edit learner
- [ ] Admin can delete learner
- [ ] Admin can disable/enable learner account
- [ ] Learner can register new account
- [ ] Learner can login
- [ ] Learner can access dashboard
- [ ] Learner can logout
- [ ] Learner cannot access admin routes
- [ ] Admin cannot access learner routes
- [ ] Email uniqueness validation works
- [ ] Password reset works for learners
- [ ] Remember me functionality works

---

## Future Enhancements

### Potential Learner-Specific Fields

Now that learners have their own table, we can easily add learner-specific fields:

```php
Schema::table('learners', function (Blueprint $table) {
    $table->string('phone')->nullable();
    $table->date('date_of_birth')->nullable();
    $table->string('country')->nullable();
    $table->string('timezone')->default('UTC');
    $table->integer('study_streak')->default(0);
    $table->timestamp('last_activity_at')->nullable();
    $table->json('preferences')->nullable();
});
```

### Potential Relationships

```php
// In Learner model
public function certifications()
{
    return $this->hasMany(Certification::class);
}

public function practiceSessions()
{
    return $this->hasMany(PracticeSession::class);
}

public function examAttempts()
{
    return $this->hasMany(ExamAttempt::class);
}

public function certificates()
{
    return $this->hasMany(Certificate::class);
}
```

---

## Technical Details

**Files Modified:**
1. `app/Models/Learner.php` (created)
2. `database/migrations/2025_10_26_015649_create_learners_table.php` (created)
3. `app/Http/Controllers/Admin/LearnerController.php`
4. `app/Http/Controllers/Learner/AuthController.php`
5. `app/Http/Middleware/LearnerMiddleware.php`
6. `config/auth.php`

**Database Tables:**
- `learners` (created)
- `users` (learner records removed)

**Git Commit**: `dbe7345`  
**Commit Message**: "Separate learners into dedicated table"

---

## Support

For questions or issues related to this change, please contact the development team or submit an issue on GitHub.

**Repository**: https://github.com/tuxmason/sisukai.git

