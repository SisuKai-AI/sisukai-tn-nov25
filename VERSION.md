# SisuKai Version Information

## Current Version: 1.20251104.001

**Release Date**: November 04, 2025  
**Build Number**: 001  
**Major Version**: 1

---

## Release 1.20251104.001 - November 04, 2025

### Overview
This release introduces a comprehensive suite of performance visualization tools for the learner portal, including interactive charts for domain performance, score distribution, and progress trends over time. It also includes critical bug fixes for the exam answer submission system and learner exam history page, ensuring a stable and reliable user experience.

### New Features

#### Performance Visualization Suite
- **Domain Performance Radar Chart**: Visualizes learner performance across all certification domains in a single radar chart, comparing scores against the 75% passing threshold.
- **Score Distribution Doughnut Chart**: Provides a clear breakdown of correct, incorrect, and unanswered questions, with a central accuracy percentage display.
- **Progress Trend Line Chart**: Tracks performance improvement across multiple benchmark exam attempts, showing both overall score and domain-specific trends over time. (Conditionally displayed with 2+ attempts)

### Bug Fixes

- **Critical Exam Answer Submission Bug**: Fixed a series of issues preventing exam answers from being saved, including JavaScript loading problems, model fillable array mismatches, and missing database timestamps.
- **Exam History Page Error**: Resolved an `Undefined variable` error that caused the learner exam history page to fail.
- **Progress Trend Chart Bug**: Fixed a bug in the data preparation logic that prevented the progress trend chart from rendering.

### Enhancements

- **Benchmark Exam Flow**: The entire benchmark exam flow is now fully functional, from enrollment to results, with accurate scoring and domain performance analysis.
- **Documentation**: Added comprehensive implementation and testing documentation for all new features and bug fixes.

---

## Current Version: 1.20251029.002

**Release Date**: October 29, 2025  
**Build Number**: 002  
**Major Version**: 1

---

## Version Format

SisuKai follows a date-based versioning scheme:

```
MAJOR.YYYYMMDD.BUILD
```

- **MAJOR**: Major version number (incremented for breaking changes or major releases)
- **YYYYMMDD**: Date of release in year-month-day format
- **BUILD**: Build number for that day (starts at 001, increments for multiple releases on the same day)

### Examples
- `1.202526.001` = Version 1, released on January 26, 2025, first build of the day
- `1.202526.002` = Version 1, released on January 26, 2025, second build of the day
- `2.20250201.001` = Version 2, released on February 1, 2025, first build of the day

---

## Release 1.20251029.002 - October 29, 2025

### Overview
This release focuses on user experience improvements for the Exam Session Management module in the admin portal. The primary enhancement replaces JavaScript confirm dialogs with professional Bootstrap 5 modals for delete confirmations, providing better visual feedback and detailed session information before deletion.

### Features

#### Enhanced Delete Confirmations
- **Bootstrap 5 Modals**: Replaced simple JavaScript `confirm()` dialogs with professional Bootstrap 5 modals
- **Session Details Display**: Modal shows comprehensive session information including learner, certification, exam type, status, and creation date
- **Visual Warnings**: Added prominent warning alerts about irreversible actions
- **Consistent Experience**: Implemented modals on both exam sessions list and detail pages

#### UI Improvements
- **Action Button Spacing**: Added gap between View, Edit, and Delete buttons for better visual clarity and clickability
- **Color-Coded Badges**: Modal displays exam type and status with color-coded badges matching the application's design system
- **Responsive Design**: Modals are centered and fully responsive across all screen sizes

### Changed
- **Exam Sessions Index Page**: Delete button now triggers a modal instead of JavaScript confirm
- **Exam Session Details Page**: Delete button now triggers a modal with enhanced session information
- **Button Group Layout**: Added `gap-1` class to action button groups for improved spacing

### Technical Details
- Modal header styled with danger theme (red background, white text)
- Session details displayed in a light-colored card for better readability
- Warning alert uses Bootstrap's warning variant with icon
- Close button available in header and footer for better accessibility
- Form submission remains secure with CSRF protection and DELETE method

### User Experience
- Administrators now see complete session information before confirming deletion
- Reduced risk of accidental deletions with more prominent warnings
- Improved visual hierarchy guides users through the deletion confirmation process
- Consistent modal experience across different admin portal sections

---

## Release 1.20251029.001 - October 29, 2025

### Overview
This release introduces a comprehensive certification module for the learner portal, enabling learners to browse, enroll in, and track their progress on industry certifications. The certification module provides the foundation for future practice sessions and exam attempts.

### New Features

#### Certification Module
- **Browse Certifications** (`/learner/certifications`)
  - Grid layout displaying all 18 available certifications
  - Search functionality by certification name or description
  - Filter by provider dropdown (AWS, CompTIA, Cisco, etc.)
  - Certification cards showing provider, name, description, exam requirements, and pricing
  - "Learn More" button to view detailed information
  - Responsive design (3 columns desktop, 1 column mobile)

- **Certification Details** (`/learner/certifications/{certification}`)
  - Comprehensive certification information display
  - Exam requirements section (questions count, duration, passing score)
  - Certification domains list with topic counts
  - Enrollment status sidebar with progress tracking
  - One-click enrollment/unenrollment functionality
  - Statistics (questions, domains, enrolled learners count)
  - Back to certifications navigation

- **My Certifications** (`/learner/my-certifications`)
  - List view of all enrolled certifications
  - Progress bars showing completion percentage
  - Status badges (Enrolled, In Progress, Completed)
  - Practice sessions and exam attempts count per certification
  - Enrollment date display
  - "View Details" and "Continue Learning" action buttons
  - Empty state with call-to-action to browse certifications

#### Database Layer
- **learner_certification Pivot Table**
  - Tracks enrollment relationships between learners and certifications
  - Fields: status (enrolled, in_progress, completed, dropped)
  - Progress percentage tracking (decimal, 0-100)
  - Timestamps: enrolled_at, started_at, completed_at
  - Composite unique index on (learner_id, certification_id)

#### Model Enhancements
- **Learner Model**
  - `certifications()` - Many-to-many relationship with Certification
  - `enrolledCertifications()` - Returns only enrolled certifications
  - `inProgressCertifications()` - Returns in-progress certifications
  - `completedCertifications()` - Returns completed certifications
  - Pivot fields: status, progress_percentage, timestamps

- **Certification Model**
  - `learners()` - Many-to-many relationship with Learner
  - Pivot fields: status, progress_percentage, timestamps

#### Dashboard Integration
- **Updated Dashboard Statistics**
  - Certifications count now shows enrolled certifications
  - Real-time statistics update on enrollment
  - Status indicators ("Enrolled" vs "Get started")

- **My Certifications Section**
  - Displays up to 3 enrolled certifications on dashboard
  - Shows certification name, provider, status badge, and progress bar
  - "View" button links to certification details
  - "View All Certifications" link when certifications exist
  - "Browse Certifications" link in empty state

#### Navigation Updates
- **Learner Sidebar Menu**
  - "Browse Certifications" link added
  - "My Certifications" link added
  - Active state highlighting for certification pages

### Changes

#### Controller Updates
- **CertificationController** (Learner)
  - `index()` - Browse all certifications with search and filter
  - `show($certification)` - View certification details
  - `enroll($certification)` - Enroll in certification
  - `unenroll($certification)` - Unenroll from certification
  - `myCertifications()` - View learner's enrolled certifications

- **DashboardController** (Learner)
  - Updated to pass enrolled certifications to view
  - Calculates statistics including enrolled certifications count
  - Limits dashboard display to 3 most recent enrollments

#### UI Improvements
- Professional Bootstrap 5 certification cards
- Color-coded status badges (Enrolled, In Progress, Completed)
- Visual progress bars with percentage display
- Responsive grid layouts for all screen sizes
- Empty states with helpful messages and CTAs
- Success messages on enrollment/unenrollment
- Consistent styling with existing learner portal design

### Fixed
- Resolved pivot table naming issue (Laravel expects alphabetical order)
- Explicitly specified table name in model relationships

### Technical Details

**Files Created:**
- `app/Http/Controllers/Learner/CertificationController.php`
- `database/migrations/2025_10_28_111440_create_learner_certification_table.php`
- `resources/views/learner/certifications/index.blade.php`
- `resources/views/learner/certifications/show.blade.php`
- `resources/views/learner/certifications/my.blade.php`
- `docs/CERTIFICATION_MODULE_PROPOSAL.md`

**Files Modified:**
- `app/Models/Learner.php` (certification relationships)
- `app/Models/Certification.php` (learners relationship)
- `app/Http/Controllers/Learner/DashboardController.php` (certification data)
- `resources/views/learner/dashboard.blade.php` (certification display)
- `resources/views/layouts/learner.blade.php` (navigation links)
- `routes/web.php` (certification routes)

**Routes Added:**
```php
Route::get('/certifications', [CertificationController::class, 'index'])
Route::get('/certifications/{certification}', [CertificationController::class, 'show'])
Route::post('/certifications/{certification}/enroll', [CertificationController::class, 'enroll'])
Route::delete('/certifications/{certification}/unenroll', [CertificationController::class, 'unenroll'])
Route::get('/my-certifications', [CertificationController::class, 'myCertifications'])
```

### Testing Results

1. ✅ **Dashboard loads** with certification statistics
2. ✅ **Browse certifications** displays all 18 certifications
3. ✅ **Search and filter** functionality works correctly
4. ✅ **Certification details** page displays complete information
5. ✅ **Enrollment** creates record and updates UI immediately
6. ✅ **My certifications** page shows enrolled certifications with progress
7. ✅ **Dashboard updates** reflect enrollment status (0 → 1)
8. ✅ **Statistics update** correctly on enrollment
9. ✅ **Navigation links** work correctly throughout portal
10. ✅ **Test case**: Successfully enrolled in CompTIA A+ certification

### Git Commits

1. `ff5ea6d` - Implement certification module for learner portal

### Breaking Changes

None. This release is fully backward compatible.

### Known Issues

None reported.

### Future Enhancements

- Practice Sessions module (practice questions from enrolled certifications)
- Exam Attempts module (benchmark exams for enrolled certifications)
- Automatic progress calculation based on practice and exam performance
- Certificate awards upon successful exam completion
- Certification recommendations based on learner interests
- Study plans and learning paths
- Domain and topic progress tracking
- Gamification (badges, achievements, leaderboards)

---

## Release 1.20251027.001 - October 27, 2025

### Overview
This release introduces comprehensive profile management for the learner portal, providing learners with full control over their account information. The learner profile system mirrors the admin profile management functionality with a design tailored to the learner portal.

### New Features

#### Learner Profile Management
- **Profile View Page** (`/learner/profile`)
  - Full Name, Email Address display
  - Account Status with color-coded badge (Active/Disabled)
  - Member Since and Last Updated timestamps
  - Profile avatar with learner initials
  - Quick Stats: Account Age, Certifications, Practice Sessions

- **Profile Edit Functionality**
  - Update Full Name and Email Address
  - Change Password with current password verification
  - Password confirmation validation
  - Success message on update
  - Account details sidebar with status information

- **ProfileController** (Learner)
  - `show()` method: Display profile information
  - `edit()` method: Show edit form
  - `update()` method: Handle profile updates with validation

#### Navigation Integration
- Profile link in learner sidebar menu (ACCOUNT section)
- Profile link in learner top navigation dropdown menu
- Multiple access points for profile management

### Changes

#### Learner Portal Updates
- Complete profile management functionality for learners
- Profile accessible from both sidebar and dropdown menu
- Profile updates reflect immediately in dashboard and navigation
- User name updates propagate to all portal views

#### UI Improvements
- Professional learner profile interface matching learner portal design
- Color-coded badges and stats in learner profile
- Avatar with learner initials displayed correctly
- Change password section with helper text and validation
- Consistent styling with admin profile management

### Technical Details

**Files Created:**
- `app/Http/Controllers/Learner/ProfileController.php`
- `resources/views/learner/profile/show.blade.php`
- `resources/views/learner/profile/edit.blade.php`

**Files Modified:**
- `routes/web.php` (added learner profile routes)
- `resources/views/layouts/learner.blade.php` (profile links in sidebar and dropdown)
- `app/Http/Controllers/Learner/ProfileController.php` (uses learner guard)

**Database:**
- Uses `learners` table for authentication and data storage
- Leverages learner guard for authentication

### Testing Results

1. ✅ **Profile View**: Successfully displays all learner information
2. ✅ **Profile Edit**: Form loads with pre-filled data
3. ✅ **Update Profile**: Name change from "Test Learner" to "Test Learner Updated"
4. ✅ **Dashboard Update**: Welcome message reflects name change
5. ✅ **Navigation Update**: User dropdown shows updated name
6. ✅ **Sidebar Link**: Profile link in sidebar navigates correctly
7. ✅ **Dropdown Link**: Profile link in dropdown navigates correctly

### Git Commits

1. `cef12ca` - Implement learner profile management system
2. `9e01ac3` - Link Profile sidebar menu to learner profile page
3. `e46b6e5` - Link Profile dropdown menu item to learner profile page

### Breaking Changes

None. This release is fully backward compatible.

### Known Issues

None reported.

### Future Enhancements

- Avatar upload functionality
- Email verification for email changes
- Two-factor authentication
- Activity log in profile
- Privacy settings
- Notification preferences

---

## Release 1.20251026.003 - October 26, 2025

### Overview
This release focuses on admin user experience improvements with profile management, dashboard enhancements, and functional Quick Actions. The admin portal now provides comprehensive profile management and accurate statistics display.

### New Features

#### Admin Profile Management
- **Profile View Page** (`/admin/profile`)
  - Full Name, Email Address display
  - User Type and Roles badges
  - Account Status with color-coded badge
  - Member Since and Last Updated timestamps
  - Profile avatar with user initials
  - Quick Stats: Total Permissions, Account Age, Last Login

- **Profile Edit Functionality**
  - Update Full Name and Email Address
  - Change Password with current password verification
  - Password confirmation validation
  - Success message on update
  - Account details sidebar with role information

- **ProfileController**
  - `show()` method: Display profile information
  - `edit()` method: Show edit form
  - `update()` method: Handle profile updates with validation

#### Dashboard Improvements
- **Accurate Statistics**
  - Total Learners: Shows count from learners table (4)
  - Active Users: Shows active learners count (3)
  - Total Users: Shows admin users count (3)
  - Platform Statistics sidebar with correct counts

- **Functional Quick Actions**
  - Add New User button links to `/admin/users/create`
  - Add Learner button links to `/admin/learners/create`
  - Info alert updated to reflect implemented features

### Changes

#### Navigation Updates
- Profile link in top navigation dropdown now functional
- Links to `/admin/profile` route
- Role badge removed from dropdown for cleaner UI
- User name displayed without clutter

#### UI Improvements
- Badge visibility fixed in profile views
- Replaced custom `bg-label-*` classes with standard Bootstrap classes
- Color-coded badges: `bg-primary` (blue), `bg-info` (cyan), `bg-success` (green)
- Professional profile interface matching admin design
- Avatar with user initials properly styled

### Fixed
- Dashboard statistics now pull from correct database tables
- User Type, Roles, and Account Status badges now visible
- Profile avatar circle visibility issue resolved
- Badge styling consistency across admin portal

### Technical Details

**Files Created:**
- `app/Http/Controllers/Admin/ProfileController.php`
- `resources/views/admin/profile/show.blade.php`
- `resources/views/admin/profile/edit.blade.php`

**Files Modified:**
- `routes/web.php` (added profile routes)
- `resources/views/layouts/admin.blade.php` (profile link, badge removal)
- `app/Http/Controllers/Admin/DashboardController.php` (statistics)
- `resources/views/admin/dashboard.blade.php` (stats display, Quick Actions)
- `resources/views/admin/profile/*.blade.php` (badge classes)

### Testing Results
- ✅ Profile view displays all information correctly
- ✅ Profile edit updates name and email successfully
- ✅ Password change with validation works
- ✅ Dashboard statistics show accurate counts
- ✅ Quick Actions buttons navigate to correct pages
- ✅ All badges visible with proper colors
- ✅ Profile link in dropdown functional

### Git Commits
1. `336c3aa` - Implement admin profile management system
2. `976ecb6` - Fix badge visibility in profile views
3. `fc6bb31` - Link Profile menu item to admin profile page
4. `d2b970d` - Remove role badge from top navigation dropdown
5. `7f043ea` - Fix dashboard statistics to show correct learner and user counts
6. `f6e3c59` - Link Add New User button to user creation page
7. `d1570b4` - Link Add Learner button to learner creation page

### Breaking Changes
None. All changes are backward compatible.

### Known Issues
None reported.

### Future Enhancements
- Add Certification feature
- Add Question feature
- Profile photo upload
- Activity log in profile
- Two-factor authentication

---

## Release 1.20251026.002 - October 26, 2025

### Overview
This release introduces a major architectural improvement by separating learner accounts into a dedicated `learners` table, providing complete authentication independence between admin and learner users. This enhances security, performance, and code maintainability.

### New Features

#### Learners Table Separation
- **Dedicated Learners Table**
  - Created separate `learners` table with same schema as `users` table
  - Migrated existing learner data from `users` to `learners` table
  - Removed `user_type` column dependency (no longer needed)
  - Preserved all learner data including IDs, timestamps, and status

- **Learner Model**
  - Created Learner model extending Authenticatable
  - Added helper methods: `isActive()`, `isDisabled()`
  - Configured fillable fields and hidden attributes
  - Automatic password hashing via casts

- **Independent Authentication**
  - Added `learner` guard to auth configuration
  - Added `learner` provider using Learner model
  - Separate authentication sessions for learners and admins
  - Learners and admins can be logged in simultaneously

#### Seeder Improvements
- **LearnerSeeder**
  - Created dedicated seeder for learner accounts
  - Seeds 4 test learners: Test Learner, John Doe, Jane Smith, Mike Johnson
  - Mike Johnson created with disabled status for testing
  - Uses `updateOrCreate()` for idempotency

- **AdminUserSeeder**
  - Renamed from TestUserSeeder for clarity
  - Now only creates admin users (Super Admin, Content Manager, Support Staff)
  - Uses `updateOrCreate()` and `syncWithoutDetaching()` for idempotency
  - Can be run multiple times without errors

### Changes

#### Controller Updates
- **LearnerController**
  - Updated to use Learner model instead of User model
  - Removed `user_type` checks (no longer needed)
  - Updated email validation to use `learners` table
  - Simplified logic with dedicated model

- **AuthController (Learner)**
  - Updated to use `learner` guard
  - Updated to use Learner model
  - Independent authentication flow

#### View Updates
- **Learner Portal Views**
  - Dashboard updated to use `auth('learner')->user()`
  - Layout updated to use `auth('learner')->user()` for avatar and name
  - All learner views now use learner guard

#### Middleware Updates
- **LearnerMiddleware**
  - Updated to use `learner` guard
  - Removed `isLearner()` check (no longer needed)
  - Simplified authentication logic

- **Guest Middleware**
  - Learner routes now use `guest:learner`
  - Proper guest handling for learner authentication

### Security Enhancements

#### Complete Separation
- Admin and learner authentication completely independent
- No shared authentication state between user types
- Separate session management
- Prevents cross-contamination between user types

#### Performance Improvements
- No need to filter by `user_type` in queries
- Cleaner, more efficient database queries
- Better indexing opportunities
- Reduced query complexity

### Technical Details

#### Database Changes
- **Migration**: `2025_10_26_015649_create_learners_table.php`
  - Creates `learners` table with full user schema
  - Migrates existing learner data from `users` table
  - Removes migrated learners from `users` table
  - Preserves all data integrity

#### Files Modified
1. **Models**:
   - Created `app/Models/Learner.php`
   - Updated `app/Models/User.php` (hasPermission method)

2. **Controllers**:
   - `app/Http/Controllers/Admin/LearnerController.php`
   - `app/Http/Controllers/Learner/AuthController.php`

3. **Middleware**:
   - `app/Http/Middleware/LearnerMiddleware.php`

4. **Configuration**:
   - `config/auth.php` (added learner guard and provider)

5. **Routes**:
   - `routes/web.php` (updated guest middleware)

6. **Views**:
   - `resources/views/learner/dashboard.blade.php`
   - `resources/views/layouts/learner.blade.php`

7. **Seeders**:
   - Created `database/seeders/LearnerSeeder.php`
   - Renamed `database/seeders/TestUserSeeder.php` to `AdminUserSeeder.php`
   - Updated `database/seeders/DatabaseSeeder.php`

### Documentation

#### New Documentation
- `docs/learners-table-separation.md` - Comprehensive guide for learners table architecture

### Testing Results

✅ Admin can view learners list  
✅ Admin can view learner details  
✅ Learner data correctly migrated  
✅ Learner login successful  
✅ Learner dashboard displays correctly  
✅ All Quick Actions buttons working  
✅ Account Status displaying correctly  
✅ Statistics showing properly  
✅ Fresh migration with seeding successful

### Git Commits

1. **dbe7345** - Separate learners into dedicated table
2. **b143a36** - Add documentation for learners table separation
3. **b9dfdef** - Update learner portal to use learner guard and learners table
4. **1b98721** - Create separate LearnerSeeder and remove learner from TestUserSeeder
5. **85d4242** - Rename TestUserSeeder to AdminUserSeeder and make it idempotent

### Breaking Changes

⚠️ **Database Structure Change**
- Learner accounts moved from `users` table to `learners` table
- Existing code referencing `User::where('user_type', 'learner')` needs updating
- Authentication guard must be specified as `learner` for learner operations

### Upgrade Notes

**From version 1.202526.001:**

1. **Backup your database** before upgrading
2. Run migrations: `php artisan migrate`
3. Run seeders: `php artisan db:seed`
4. Clear caches:
   ```bash
   php artisan cache:clear
   php artisan config:clear
   php artisan route:clear
   php artisan view:clear
   ```
5. Test learner login functionality
6. Verify admin can manage learners

**Fresh Installation:**
```bash
php artisan migrate:fresh --seed
```

### Known Issues
None reported.

### Future Enhancements
- Add learner profile management
- Implement learner-specific settings
- Add learner activity tracking
- Create learner analytics dashboard
- Implement learner progress reports
- Add learner certification management

---

## Release 1.202526.001 - January 26, 2025

### Overview
This release focuses on enhancing learner account management with granular permission controls and improving the user interface with professional Bootstrap modals and visual fixes.

### New Features

#### Permission System Enhancements
- **Enable Learners Permission** (`learners.enable`)
  - Allows administrators to enable disabled learner accounts
  - Assigned to Super Admin role by default
  - Provides granular control over account activation

- **Disable Learners Permission** (`learners.disable`)
  - Allows administrators to disable active learner accounts
  - Assigned to Super Admin role by default
  - Provides granular control over account deactivation

- **Account Status Display**
  - Added dedicated Account Status field in learner details page
  - Color-coded badges: green for Active, red for Disabled
  - Bootstrap Icons for visual clarity (check-circle/x-circle)
  - Updates dynamically when account status changes

#### User Model Enhancement
- Added `hasPermission($permissionName)` method
- Checks permissions through user's assigned roles
- Returns boolean for easy permission validation
- Supports role-based permission inheritance

### User Interface Improvements

#### Bootstrap Modals
- **Delete Learner Modal**
  - Replaced JavaScript confirm dialog with professional Bootstrap modal
  - Clear warning message emphasizing permanent deletion
  - Consistent design with other modals in the application
  - Improved user experience with better visual feedback

#### Visual Fixes
- **Avatar Circle Visibility**
  - Fixed invisible avatar on learner details page
  - Replaced custom Bootstrap classes with inline styles
  - 80px rounded circle with purple background (#696cff)
  - Displays learner initials in white, centered text
  - Matches design pattern from sidebar user avatar

#### Button Styling
- **Edit Learner Button**
  - Changed from warning (yellow) to info (cyan) color
  - Better visual hierarchy in Quick Actions panel
  - Distinguishes non-destructive actions from warnings

### Security Enhancements

#### Backend Authorization
- Added permission checks in `LearnerController@toggleStatus` method
- Validates `learners.disable` permission when disabling accounts
- Validates `learners.enable` permission when enabling accounts
- Returns 403 Forbidden with clear error messages for unauthorized actions

#### Frontend Security
- Disable/Enable buttons conditionally displayed based on permissions
- Buttons completely hidden if user lacks required permission
- No disabled/grayed-out buttons that might confuse users
- Clean UI that only shows available actions

### Technical Details

#### Files Modified
1. **Migration**: `database/migrations/2025_10_25_234421_add_enable_disable_learner_permissions.php`
2. **Model**: `app/Models/User.php` (added hasPermission method)
3. **Controller**: `app/Http/Controllers/Admin/LearnerController.php` (added authorization)
4. **Seeder**: `database/seeders/RolePermissionSeeder.php` (updated permission count)
5. **Views**: 
   - `resources/views/admin/learners/show.blade.php` (account status, delete modal, avatar fix)
   - `resources/views/admin/learners/index.blade.php` (conditional toggle action)

#### Database Changes
- Added 2 new permissions to `permissions` table
- Total permissions increased from 24 to 26
- Super Admin role automatically receives all permissions

#### Permission Assignments
- **Super Admin**: 26 permissions (includes enable + disable)
- **Content Manager**: 9 permissions (no enable/disable access)
- **Support Staff**: 1 permission (view only, no enable/disable access)

### Documentation

#### New Documentation Files
- `docs/enable-disable-learner-permissions.md` - Comprehensive guide for permission system
- `docs/disable-enable-account-feature.md` - Feature documentation for account toggling

#### Updated Documentation
- README updated with new feature information
- API documentation updated with permission endpoints
- User guide updated with account management instructions

### Git Commits

1. **bc95557** - Add disable/enable account button to learner details page
2. **7027d95** - Add Account Status field to learner details
3. **c9c5df4** - Change Edit Learner button style from warning to info
4. **b9e1554** - Implement enable and disable learner permissions
5. **71e3f54** - Add documentation for enable/disable learner permissions feature
6. **39de507** - Replace delete learner JavaScript confirm with Bootstrap modal
7. **a664892** - Fix avatar circle visibility on learner details page
8. **85a9916** - Update application version to 1.202526.001
9. **8c40947** - Update VERSION and CHANGELOG.md for release 1.202526.001

### Breaking Changes
None. This release is fully backward compatible.

### Upgrade Notes
- No database migration required if upgrading from 1.20251025.001
- Run `php artisan migrate` to add new permissions
- Run `php artisan db:seed --class=RolePermissionSeeder` to assign permissions to roles
- Clear application cache: `php artisan cache:clear`
- Clear config cache: `php artisan config:clear`

### Known Issues
None reported.

### Future Enhancements
- Activity logging for account status changes
- Bulk enable/disable operations
- Email notifications when account status changes
- Audit trail for status change history
- Reason field when disabling accounts
- Scheduled auto-enable after certain period

---

## Previous Releases

### Release 1.20251025.001 - October 25, 2025

Initial release of SisuKai certification exam preparation platform with complete authentication system, role-based access control, admin portal, learner portal, and comprehensive documentation.

For detailed changelog, see [CHANGELOG.md](CHANGELOG.md).

---

## Version History

| Version | Release Date | Major Changes |
|---------|--------------|---------------|
| 1.20251027.001 | 2025-10-27 | Learner profile management, navigation integration, profile edit functionality |
| 1.20251026.003 | 2025-10-26 | Admin profile management, dashboard improvements, functional Quick Actions |
| 1.20251026.002 | 2025-10-26 | Learners table separation, independent authentication, seeder improvements |
| 1.202526.001 | 2025-01-26 | Permission enhancements, UI improvements, security fixes |
| 1.20251025.001 | 2025-10-25 | Initial release |

---

## Support

For questions, issues, or feature requests, please contact the SisuKai development team or submit an issue on GitHub.

**Repository**: https://github.com/tuxmason/sisukai.git

