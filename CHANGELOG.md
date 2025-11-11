# Changelog

All notable changes to the SisuKai project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [1.20251104.001] - 2025-11-04

### Added
- Domain Performance Radar Chart to visualize strengths and weaknesses across domains.
- Score Distribution Doughnut Chart for a clear breakdown of correct, incorrect, and unanswered questions.
- Progress Trend Line Chart to track performance improvement across multiple benchmark attempts.
- Comprehensive implementation and testing documentation for all new features.

### Fixed
- **Critical Exam Answer Submission Bug**: A series of issues preventing exam answers from being saved, including JavaScript loading problems, model fillable array mismatches, and missing database timestamps.
- **Exam History Page Error**: An `Undefined variable` error that caused the learner exam history page to fail.
- **Progress Trend Chart Bug**: A bug in the data preparation logic that prevented the progress trend chart from rendering.

### Changed
- The benchmark exam flow is now fully functional, from enrollment to results, with accurate scoring and domain performance analysis.

---

## [1.20251029.002] - 2025-10-29

### Added
- Bootstrap 5 modal for delete confirmation on exam sessions list page
- Bootstrap 5 modal for delete confirmation on exam session details page
- Comprehensive session information display in delete modals (learner, certification, exam type, status, created date)
- Visual warning alerts in delete modals about irreversible actions
- Color-coded badges in modals for exam type and status

### Changed
- Replaced JavaScript `confirm()` dialog with Bootstrap 5 modal for exam session deletion
- Enhanced delete confirmation UX with detailed session information
- Added `gap-1` class to action button groups for improved spacing between View, Edit, and Delete buttons

### UI Improvements
- Professional modal design with danger-themed header (red background, white text)
- Session details displayed in light-colored card for better readability
- Warning alert with icon for better visual emphasis
- Close buttons in both header and footer for improved accessibility
- Responsive modal design that works across all screen sizes
- Better visual separation between action buttons with gap spacing

### Technical
- Modal implementation uses Bootstrap 5 modal component
- Unique modal IDs for each session in the list view
- CSRF protection and DELETE method maintained in modal forms
- Consistent modal structure across index and show pages

---

## [1.20251029.001] - 2025-10-29

### Added
- Certification module for learner portal with browse, enroll, and tracking features
- Browse Certifications page (`/learner/certifications`) with search and filter functionality
- Certification details page showing exam requirements, domains, and enrollment options
- My Certifications page (`/learner/my-certifications`) displaying enrolled certifications with progress
- `learner_certification` pivot table for tracking enrollment status and progress
- CertificationController with index, show, enroll, unenroll, and myCertifications methods
- Many-to-many relationships between Learner and Certification models
- Certification navigation links in learner sidebar (Browse Certifications, My Certifications)
- Dashboard integration showing enrolled certifications and updated statistics
- Certification module proposal documentation (`docs/CERTIFICATION_MODULE_PROPOSAL.md`)

### Changed
- Dashboard now displays enrolled certifications with progress bars and status badges
- Dashboard statistics updated to show enrolled certifications count
- Learner model enhanced with certification relationship methods
- Certification model enhanced with learners relationship method
- Dashboard controller updated to pass certification data to views

### UI Improvements
- Professional Bootstrap 5 certification cards with responsive grid layout
- Color-coded status badges (Enrolled, In Progress, Completed, Dropped)
- Visual progress bars showing completion percentage
- Empty states with helpful messages and call-to-action buttons
- Success messages on enrollment and unenrollment actions

### Fixed
- Resolved pivot table naming convention issue (explicitly specified table name in relationships)

---

## [1.20251027.001] - 2025-10-27

### Added
- Learner profile management system accessible via `/learner/profile`
- Profile view page showing learner information and account details
- Profile edit functionality for updating name, email, and password
- Learner ProfileController with show, edit, and update methods
- Profile link in learner sidebar menu (ACCOUNT section)
- Profile link in learner top navigation dropdown menu
- Quick Stats card in learner profile (Account Age, Certifications, Practice Sessions)

### Changed
- Learner portal now has complete profile management functionality
- Profile accessible from both sidebar and dropdown menu
- Profile updates reflect immediately in dashboard and navigation

### UI Improvements
- Professional learner profile interface matching learner portal design
- Color-coded badges and stats in learner profile
- Avatar with learner initials displayed correctly
- Change password section with helper text and validation

---

## [1.20251026.003] - 2025-10-26

### Added
- Admin profile management system accessible via `/admin/profile`
- Profile view page showing admin information, roles, and account details
- Profile edit functionality for updating name, email, and password
- ProfileController with show, edit, and update methods
- Profile link in top navigation dropdown menu
- Quick Actions buttons linked to creation pages (Add New User, Add Learner)

### Changed
- Dashboard statistics now display correct counts from learners and users tables
- Total Learners stat shows count from learners table (4)
- Active Users stat shows active learners count (3)
- Total Users stat shows admin users count (3)
- "Add New User" button in Quick Actions now links to user creation page
- "Add Learner" button in Quick Actions now links to learner creation page
- Info alert updated to reflect implemented features
- Role badge removed from top navigation dropdown for cleaner UI

### Fixed
- Badge visibility in profile views (replaced custom classes with standard Bootstrap)
- Dashboard statistics pulling from correct database tables
- User Type, Roles, and Account Status badges now properly visible

### UI Improvements
- Profile avatar with user initials displayed correctly
- Color-coded badges using standard Bootstrap classes (bg-primary, bg-info, bg-success)
- Professional profile management interface matching admin design
- Quick Actions section with functional navigation buttons

---

## [1.20251026.002] - 2025-10-26

### Added
- Separate `learners` table for learner accounts (migrated from `users` table)
- Learner model extending Authenticatable with helper methods (`isActive()`, `isDisabled()`)
- Learner authentication guard and provider for independent authentication
- LearnerSeeder with 4 test learner accounts (Test Learner, John Doe, Jane Smith, Mike Johnson)
- AdminUserSeeder (renamed from TestUserSeeder) for admin user seeding
- Documentation for learners table separation (`docs/learners-table-separation.md`)

### Changed
- Learner accounts moved from `users` table to dedicated `learners` table
- LearnerController updated to use Learner model instead of User model
- Learner authentication now uses `learner` guard instead of default `web` guard
- Learner portal views updated to use `auth('learner')->user()`
- Guest middleware for learner routes updated to `guest:learner`
- TestUserSeeder renamed to AdminUserSeeder for clarity
- AdminUserSeeder and LearnerSeeder made idempotent with `updateOrCreate()` and `syncWithoutDetaching()`
- DatabaseSeeder updated to call AdminUserSeeder and LearnerSeeder

### Security
- Complete separation between admin and learner authentication systems
- Independent sessions for admin and learner users
- Learner-specific authentication guard prevents cross-contamination

### Technical Details
- Migration created to copy users table schema to learners table
- Data migration moved existing learner records from users to learners
- Auth configuration updated with learner guard and provider
- LearnerMiddleware updated to use learner guard
- Email validation updated to check learners table

---

## [1.202526.001] - 2025-01-26

### Added
- Account Status field in learner details page showing Active/Disabled status with color-coded badges
- Enable Learners permission (`learners.enable`) for granular access control
- Disable Learners permission (`learners.disable`) for granular access control
- `hasPermission()` method in User model for role-based permission checking
- Bootstrap confirmation modal for delete learner action
- Comprehensive documentation for enable/disable learner permissions feature

### Changed
- Edit Learner button color changed from warning (yellow) to info (cyan) for better visual hierarchy
- Delete learner confirmation replaced JavaScript confirm dialog with professional Bootstrap modal
- Total permissions increased from 24 to 26 with new enable/disable permissions
- Disable/Enable Account buttons now conditionally displayed based on user permissions

### Fixed
- Avatar circle visibility on learner details page (replaced custom Bootstrap classes with inline styles)
- Avatar now displays as 80px rounded circle with purple background and learner initials

### Security
- Added backend authorization checks in `LearnerController@toggleStatus` method
- Frontend buttons hidden when user lacks required permissions
- 403 Forbidden responses with clear error messages for unauthorized actions

---

## [1.20251025.001] - 2025-10-25

### Added
- Initial release of SisuKai certification exam preparation platform
- Laravel 12 project structure with SQLite database
- Complete authentication system for admin and learner portals
- Role-based access control (Super Admin, Content Manager, Support Staff)
- Sneat Bootstrap template design for both portals
- Modern UI/UX with purple color scheme (#696cff)
- Admin portal with dashboard and management features
- Learner portal with dashboard and gamification elements
- Database migrations for users, roles, and user_roles tables
- Seeders for roles and test users
- Comprehensive documentation in `/docs` directory
- API reference and quick start guide
- Project README and completion reports

### Features
- **Admin Portal**
  - Light sidebar with Sneat-inspired design
  - User management interface
  - Learner management interface
  - Role and permission management
  - Statistics dashboard with colorful icon badges
  - System information panel
  - Quick actions for future features

- **Learner Portal**
  - Light sidebar with Sneat-inspired design
  - Personal dashboard with statistics
  - Study streak tracking
  - Certification management interface
  - Practice session tracking
  - Progress monitoring
  - Gamification elements

### Technical Details
- PHP 8.3+
- Laravel 12
- Bootstrap 5.3.2
- Bootstrap Icons 1.11.1
- SQLite database
- Role-based middleware
- Secure authentication with "Remember Me" functionality

### Documentation
- Complete technical documentation
- API reference
- Quick start guide
- Installation instructions
- Database schema documentation
- User management guide

---

## Version Format

Versions follow the format: `MAJOR.YYYYMMDD.BUILD`

- **MAJOR**: Major version number (incremented for breaking changes)
- **YYYYMMDD**: Date of release (year, month, day)
- **BUILD**: Build number for that day (starts at 001)

Example: `1.20251025.001` = Version 1, released on October 25, 2025, first build of the day.

