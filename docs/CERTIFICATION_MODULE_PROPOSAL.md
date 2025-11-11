# Certification Module Proposal - Learner Portal

**Author:** Sisukai Developer  
**Date:** October 28, 2025  
**Status:** Awaiting Approval

---

## 1. Overview

This proposal outlines the implementation of a **Certification Module** for the SisuKai learner portal. The module will enable learners to browse available certifications, enroll in certification programs, and track their progress toward certification goals.

## 2. Current State Analysis

### Existing Infrastructure

The following components are already in place:

| Component | Status | Details |
|-----------|--------|---------|
| **Certification Model** | ✅ Complete | Full model with relationships to domains, questions, practice sessions, exam attempts |
| **Database Schema** | ✅ Complete | Tables: `certifications`, `practice_sessions`, `exam_attempts`, `certificates` |
| **Learner Model** | ✅ Complete | Relationships to practice sessions, exam attempts, certificates |
| **Admin Management** | ✅ Complete | Full CRUD for certifications with 18 certifications seeded |
| **Question Bank** | ✅ Complete | 698 high-quality questions across all certifications |

### Missing Components

- **Learner-Certification Enrollment System** (many-to-many relationship)
- **Certification Browse/Discovery Interface**
- **Certification Detail Pages**
- **Enrollment/Unenrollment Functionality**
- **Progress Tracking Dashboard**

## 3. Proposed Implementation

### 3.1. Database Changes

#### New Migration: `learner_certification` Pivot Table

```php
Schema::create('learner_certification', function (Blueprint $table) {
    $table->uuid('id')->primary();
    $table->foreignUuid('learner_id')->constrained()->onDelete('cascade');
    $table->foreignUuid('certification_id')->constrained()->onDelete('cascade');
    $table->enum('status', ['enrolled', 'in_progress', 'completed', 'dropped'])->default('enrolled');
    $table->integer('progress_percentage')->default(0);
    $table->timestamp('enrolled_at')->useCurrent();
    $table->timestamp('started_at')->nullable();
    $table->timestamp('completed_at')->nullable();
    $table->timestamps();
    
    $table->unique(['learner_id', 'certification_id']);
});
```

**Rationale:** This pivot table tracks the learner's enrollment status and progress for each certification, enabling personalized dashboards and progress tracking.

### 3.2. Model Updates

#### Update `Learner` Model

Add many-to-many relationship:

```php
/**
 * Get the certifications the learner is enrolled in.
 */
public function certifications()
{
    return $this->belongsToMany(Certification::class)
        ->withPivot('status', 'progress_percentage', 'enrolled_at', 'started_at', 'completed_at')
        ->withTimestamps();
}

/**
 * Get enrolled certifications.
 */
public function enrolledCertifications()
{
    return $this->certifications()->wherePivot('status', 'enrolled');
}

/**
 * Get in-progress certifications.
 */
public function inProgressCertifications()
{
    return $this->certifications()->wherePivot('status', 'in_progress');
}

/**
 * Get completed certifications.
 */
public function completedCertifications()
{
    return $this->certifications()->wherePivot('status', 'completed');
}
```

#### Update `Certification` Model

Add inverse relationship:

```php
/**
 * Get the learners enrolled in this certification.
 */
public function learners()
{
    return $this->belongsToMany(Learner::class)
        ->withPivot('status', 'progress_percentage', 'enrolled_at', 'started_at', 'completed_at')
        ->withTimestamps();
}
```

### 3.3. Routes

```php
// Learner Portal - Certification Routes
Route::middleware(['auth:learner'])->prefix('learner')->name('learner.')->group(function () {
    
    // Certification browsing and discovery
    Route::get('/certifications', [CertificationController::class, 'index'])
        ->name('certifications.index');
    
    Route::get('/certifications/{certification}', [CertificationController::class, 'show'])
        ->name('certifications.show');
    
    // Enrollment management
    Route::post('/certifications/{certification}/enroll', [CertificationController::class, 'enroll'])
        ->name('certifications.enroll');
    
    Route::delete('/certifications/{certification}/unenroll', [CertificationController::class, 'unenroll'])
        ->name('certifications.unenroll');
    
    // My certifications (enrolled)
    Route::get('/my-certifications', [CertificationController::class, 'myCertifications'])
        ->name('certifications.my');
});
```

### 3.4. Controller: `Learner\CertificationController`

```php
<?php

namespace App\Http\Controllers\Learner;

use App\Http\Controllers\Controller;
use App\Models\Certification;
use Illuminate\Http\Request;

class CertificationController extends Controller
{
    /**
     * Display all available certifications.
     */
    public function index(Request $request)
    {
        $query = Certification::where('is_active', true);
        
        // Search functionality
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }
        
        // Filter by provider
        if ($request->filled('provider')) {
            $query->where('provider', $request->provider);
        }
        
        $certifications = $query->paginate(12);
        $providers = Certification::where('is_active', true)
            ->distinct()
            ->pluck('provider');
        
        return view('learner.certifications.index', compact('certifications', 'providers'));
    }
    
    /**
     * Display certification details.
     */
    public function show(Certification $certification)
    {
        $learner = auth('learner')->user();
        $enrollment = $learner->certifications()
            ->where('certification_id', $certification->id)
            ->first();
        
        $certification->load(['domains' => function($query) {
            $query->orderBy('order');
        }]);
        
        $stats = [
            'total_questions' => $certification->questions()->count(),
            'total_domains' => $certification->domains()->count(),
            'enrolled_learners' => $certification->learners()->count(),
        ];
        
        return view('learner.certifications.show', compact('certification', 'enrollment', 'stats'));
    }
    
    /**
     * Enroll learner in certification.
     */
    public function enroll(Certification $certification)
    {
        $learner = auth('learner')->user();
        
        // Check if already enrolled
        if ($learner->certifications()->where('certification_id', $certification->id)->exists()) {
            return back()->with('error', 'You are already enrolled in this certification.');
        }
        
        $learner->certifications()->attach($certification->id, [
            'status' => 'enrolled',
            'enrolled_at' => now(),
        ]);
        
        return back()->with('success', 'Successfully enrolled in ' . $certification->name . '!');
    }
    
    /**
     * Unenroll learner from certification.
     */
    public function unenroll(Certification $certification)
    {
        $learner = auth('learner')->user();
        
        $learner->certifications()->detach($certification->id);
        
        return back()->with('success', 'Successfully unenrolled from ' . $certification->name . '.');
    }
    
    /**
     * Display learner's enrolled certifications.
     */
    public function myCertifications()
    {
        $learner = auth('learner')->user();
        
        $certifications = $learner->certifications()
            ->withCount(['practiceSessions', 'examAttempts'])
            ->get();
        
        return view('learner.certifications.my', compact('certifications'));
    }
}
```

### 3.5. Views

#### 3.5.1. Certifications Index (`resources/views/learner/certifications/index.blade.php`)

**Features:**
- Grid layout displaying certification cards
- Search bar for filtering by name/description
- Provider filter dropdown
- Pagination
- Enrollment status badges
- Quick enroll button

**Card Information:**
- Certification name and provider
- Short description
- Exam details (questions, duration, passing score)
- Price
- Enrollment status (if enrolled)
- "Enroll" or "View Details" button

#### 3.5.2. Certification Detail (`resources/views/learner/certifications/show.blade.php`)

**Features:**
- Full certification information
- Domain breakdown with weights
- Exam requirements
- Statistics (total questions, enrolled learners)
- Enrollment status and actions
- "Start Learning" button (if enrolled)
- "Enroll Now" button (if not enrolled)

#### 3.5.3. My Certifications (`resources/views/learner/certifications/my.blade.php`)

**Features:**
- List of enrolled certifications
- Progress bars for each certification
- Status badges (enrolled, in progress, completed)
- Quick actions (continue learning, take exam, unenroll)
- Statistics (practice sessions completed, exam attempts)

### 3.6. Dashboard Integration

Update `learner/dashboard.blade.php`:

```php
// Replace "My Certifications" empty state with:
@if($enrolledCertifications->count() > 0)
    // Display enrolled certifications with progress
@else
    // Show empty state with "Browse Certifications" button
@endif
```

Update `Learner\DashboardController`:

```php
public function index()
{
    $learner = auth('learner')->user();
    
    $enrolledCertifications = $learner->certifications()
        ->wherePivot('status', '!=', 'dropped')
        ->limit(3)
        ->get();
    
    $stats = [
        'enrolled_certifications' => $learner->certifications()->count(),
        'practice_sessions' => $learner->practiceSessions()->count(),
        'exam_attempts' => $learner->examAttempts()->count(),
        'certificates_earned' => $learner->validCertificates()->count(),
    ];
    
    return view('learner.dashboard', compact('enrolledCertifications', 'stats'));
}
```

### 3.7. Navigation Updates

Add to learner sidebar (`layouts/learner.blade.php`):

```html
<div class="menu-header">LEARNING</div>
<div class="menu-item">
    <a href="{{ route('learner.certifications.index') }}" class="menu-link">
        <i class="bi bi-award menu-icon"></i>
        <span>Browse Certifications</span>
    </a>
</div>
<div class="menu-item">
    <a href="{{ route('learner.certifications.my') }}" class="menu-link">
        <i class="bi bi-bookmarks menu-icon"></i>
        <span>My Certifications</span>
    </a>
</div>
```

## 4. Implementation Phases

### Phase 1: Database & Models (30 minutes)
- Create migration for `learner_certification` pivot table
- Update `Learner` and `Certification` models with relationships
- Run migration

### Phase 2: Routes & Controller (45 minutes)
- Create routes for certification module
- Implement `CertificationController` with all methods
- Add validation and error handling

### Phase 3: Views (90 minutes)
- Create certifications index view (browse/search)
- Create certification detail view
- Create my certifications view
- Update dashboard to show enrolled certifications

### Phase 4: Integration & Testing (45 minutes)
- Update sidebar navigation
- Update dashboard controller
- Test enrollment/unenrollment flow
- Test search and filtering
- Verify progress tracking

**Total Estimated Time:** 3.5 hours

## 5. Future Enhancements

The following features can be added in subsequent iterations:

- **Progress Calculation:** Auto-calculate progress based on practice sessions and exam attempts
- **Recommendations:** Suggest certifications based on learner's profile and history
- **Certification Paths:** Group related certifications into learning paths
- **Prerequisites:** Define prerequisite certifications
- **Wishlists:** Allow learners to save certifications for later
- **Reviews & Ratings:** Enable learners to review certifications

## 6. Benefits

1. **Learner Engagement:** Clear path to browse and enroll in certifications
2. **Progress Visibility:** Learners can track their certification journey
3. **Organized Learning:** Separation between enrolled and available certifications
4. **Foundation for Practice:** Sets up the structure for practice sessions (next module)
5. **Data Insights:** Enrollment data helps admins understand learner preferences

## 7. Approval Required

Please review this proposal and provide approval or feedback on:

1. Database schema for `learner_certification` pivot table
2. Controller methods and routing structure
3. View layouts and features
4. Implementation phases and timeline
5. Any additional requirements or modifications

---

**Next Steps After Approval:**
1. Create database migration
2. Update models
3. Implement controller and routes
4. Build views
5. Test and commit changes

