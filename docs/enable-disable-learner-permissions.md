# Enable and Disable Learner Permissions

## Overview
Implemented granular permission control for enabling and disabling learner accounts. This feature adds two new permissions to the Learner Management category, allowing administrators to control who can enable or disable learner accounts.

## Implementation Date
October 25, 2025

## New Permissions

### 1. Enable Learners
- **Permission Name**: `learners.enable`
- **Display Name**: Enable Learners
- **Description**: Can enable learner accounts
- **Category**: Learner Management
- **Default Assignment**: Super Admin

### 2. Disable Learners
- **Permission Name**: `learners.disable`
- **Display Name**: Disable Learners
- **Description**: Can disable learner accounts
- **Category**: Learner Management
- **Default Assignment**: Super Admin

## Technical Implementation

### Database Migration
**File**: `database/migrations/2025_10_25_234421_add_enable_disable_learner_permissions.php`

Created a migration that inserts two new permissions into the `permissions` table:
- Uses correct column names (`name`, `display_name`, `description`, `category`)
- Includes rollback functionality to remove permissions
- Automatically timestamps creation

### User Model Enhancement
**File**: `app/Models/User.php`

Added `hasPermission()` method to check if a user has a specific permission through their assigned roles:

```php
public function hasPermission($permissionName)
{
    // Get all permissions through roles
    return $this->roles()
        ->whereHas('permissions', function($query) use ($permissionName) {
            $query->where('name', $permissionName);
        })
        ->exists();
}
```

This method:
- Queries through the user's roles
- Checks if any role has the specified permission
- Returns boolean result
- Supports role-based permission inheritance

### Controller Authorization
**File**: `app/Http/Controllers/Admin/LearnerController.php`

Updated `toggleStatus()` method with permission checks:

```php
$newStatus = $learner->status === 'active' ? 'disabled' : 'active';

// Check permission based on the action
$requiredPermission = $newStatus === 'disabled' ? 'learners.disable' : 'learners.enable';

if (!auth()->user()->hasPermission($requiredPermission)) {
    abort(403, 'You do not have permission to ' . ($newStatus === 'disabled' ? 'disable' : 'enable') . ' learner accounts.');
}
```

**Logic**:
- Determines the target status (active → disabled or disabled → active)
- Checks the appropriate permission based on the action
- Returns 403 Forbidden if user lacks permission
- Provides clear error message indicating missing permission

### View Updates

#### Learner Details Page (show.blade.php)
Added conditional rendering for the toggle status button:

```blade
@php
    $canDisable = auth()->user()->hasPermission('learners.disable');
    $canEnable = auth()->user()->hasPermission('learners.enable');
    $canToggle = ($learner->status === 'active' && $canDisable) || ($learner->status === 'disabled' && $canEnable);
@endphp
@if($canToggle)
    <button type="button" class="btn btn-{{ $learner->status === 'active' ? 'warning' : 'success' }} w-100" 
            data-bs-toggle="modal" data-bs-target="#toggleStatusModal">
        <i class="bi bi-{{ $learner->status === 'active' ? 'x-circle' : 'check-circle' }} me-2"></i>
        {{ $learner->status === 'active' ? 'Disable' : 'Enable' }} Account
    </button>
@endif
```

#### Learner Listing Page (index.blade.php)
Added same conditional logic to the dropdown menu toggle action:

```blade
@php
    $canDisable = auth()->user()->hasPermission('learners.disable');
    $canEnable = auth()->user()->hasPermission('learners.enable');
    $canToggle = ($learner->status === 'active' && $canDisable) || ($learner->status === 'disabled' && $canEnable);
@endphp
@if($canToggle)
    <li><hr class="dropdown-divider"></li>
    <li>
        <button type="button" class="dropdown-item text-warning" 
                data-bs-toggle="modal" data-bs-target="#toggleStatusModal" 
                data-learner-id="{{ $learner->id }}" 
                data-learner-name="{{ $learner->name }}"
                data-learner-status="{{ $learner->status }}">
            <i class="bi bi-{{ $learner->status === 'active' ? 'x-circle' : 'check-circle' }} me-2"></i>
            {{ $learner->status === 'active' ? 'Disable' : 'Enable' }} Account
        </button>
    </li>
@endif
```

### Permission Seeder Update
**File**: `database/seeders/RolePermissionSeeder.php`

- Updated comment to reflect 26 total permissions (was 24)
- Modified info message to dynamically count permissions
- Super Admin automatically receives all permissions including the new ones

## Permission Logic

### Enable Action
- **Required Permission**: `learners.enable`
- **When Shown**: Learner status is "disabled" AND user has enable permission
- **Action**: Changes status from disabled → active
- **Button Color**: Success/Green
- **Icon**: check-circle

### Disable Action
- **Required Permission**: `learners.disable`
- **When Shown**: Learner status is "active" AND user has disable permission
- **Action**: Changes status from active → disabled
- **Button Color**: Warning/Yellow
- **Icon**: x-circle

## Security Features

1. **Backend Authorization**: Controller checks permissions before executing action
2. **Frontend Hiding**: Buttons/actions hidden if user lacks permission
3. **Clear Error Messages**: 403 responses explain what permission is missing
4. **Granular Control**: Separate permissions for enable vs disable actions
5. **Role-Based**: Permissions assigned through roles, not directly to users

## User Experience

### For Users With Permissions
- Toggle button visible in Quick Actions panel
- Toggle action visible in dropdown menu
- Can successfully enable/disable accounts
- Receives success confirmation messages

### For Users Without Permissions
- Toggle button not displayed
- Toggle action not shown in dropdown
- Cannot access toggle route directly (403 error)
- UI remains clean without disabled/grayed-out buttons

## Role Assignments

### Super Admin
- ✅ learners.enable
- ✅ learners.disable
- Total: 26 permissions

### Content Manager
- ❌ learners.enable (not assigned)
- ❌ learners.disable (not assigned)
- Total: 9 permissions

### Support Staff
- ❌ learners.enable (not assigned)
- ❌ learners.disable (not assigned)
- Total: 1 permission (learners.view only)

## Testing Scenarios

### Test 1: Super Admin Can Toggle Status
1. Login as Super Admin
2. Navigate to learner details page
3. ✅ "Disable Account" button visible
4. Click button → modal opens
5. Confirm → account disabled successfully
6. ✅ "Enable Account" button now visible
7. Click button → modal opens
8. Confirm → account enabled successfully

### Test 2: Permission Check Works
1. User has `learners.disable` permission
2. Learner status is "active"
3. ✅ "Disable Account" button visible
4. Can successfully disable account

### Test 3: Missing Permission Hides Button
1. User lacks `learners.disable` permission
2. Learner status is "active"
3. ❌ "Disable Account" button NOT visible
4. Cannot access toggle route (403 if attempted)

### Test 4: Permissions Page Display
1. Navigate to /admin/permissions
2. Scroll to Learner Management section
3. ✅ "Enable Learners" permission visible (1 role assigned)
4. ✅ "Disable Learners" permission visible (1 role assigned)

## Database Schema

### Permissions Table
```
id | name             | display_name     | description                    | category            | created_at | updated_at
25 | learners.enable  | Enable Learners  | Can enable learner accounts    | Learner Management  | ...        | ...
26 | learners.disable | Disable Learners | Can disable learner accounts   | Learner Management  | ...        | ...
```

### Role-Permission Assignments
```
role_id | permission_id
1       | 25            (Super Admin → Enable Learners)
1       | 26            (Super Admin → Disable Learners)
```

## Files Modified

1. **Migration**: `database/migrations/2025_10_25_234421_add_enable_disable_learner_permissions.php`
2. **Model**: `app/Models/User.php` (added hasPermission method)
3. **Controller**: `app/Http/Controllers/Admin/LearnerController.php` (added authorization)
4. **Seeder**: `database/seeders/RolePermissionSeeder.php` (updated count)
5. **View**: `resources/views/admin/learners/show.blade.php` (conditional rendering)
6. **View**: `resources/views/admin/learners/index.blade.php` (conditional rendering)

## Git Commit
**Hash**: `b9e1554`  
**Message**: "Implement enable and disable learner permissions"  
**Repository**: https://github.com/tuxmason/sisukai.git

## Future Enhancements

1. **Activity Logging**: Log who enabled/disabled which accounts and when
2. **Bulk Actions**: Allow enabling/disabling multiple accounts at once
3. **Notification**: Email learners when their account status changes
4. **Audit Trail**: Track status change history for compliance
5. **Reason Field**: Require reason when disabling accounts
6. **Auto-Enable**: Scheduled task to auto-enable accounts after certain period
7. **Permission Groups**: Create permission groups for easier role management

## Conclusion

The enable and disable learner permissions feature provides granular access control for account status management. The implementation follows Laravel best practices with proper authorization checks, clean UI/UX, and comprehensive role-based permission system. The feature is production-ready and fully integrated with the existing RBAC system.

