# SisuKai Notification Module Specification

**Date:** November 9, 2025  
**Author:** Manus AI  
**Version:** 1.0

## 1. Introduction

This document outlines the specification for a comprehensive, platform-wide notification module for the SisuKai certification exam preparation platform. The primary goal of this module is to create an intelligent, multi-channel messaging engine that drives learner engagement, delivers timely information, and reinforces positive learning habits without causing notification fatigue.

The system is designed around three core principles: **Trigger**, **Personalize**, and **Deliver**.

| Principle | Description |
| :--- | :--- |
| **Trigger** | Notifications are not random; they are automatically sent in response to specific, meaningful events (or the lack thereof). |
| **Personalize** | Every notification is tailored to the individual user's context, making it relevant, valuable, and personal. |
| **Deliver** | The system delivers the message through the most appropriate channel and ensures every notification has a clear, actionable purpose. |

## 2. Recommended Email Notifications

This section details the specific email notifications to be implemented in the MVP of the notification module. Each notification is categorized and includes its trigger, target audience, priority, and a detailed content specification.

### 2.1. Transactional Notifications

These are essential emails triggered by specific user actions.

| Notification | Trigger | Audience | Priority | Content Specification |
| :--- | :--- | :--- | :--- | :--- |
| **Password Reset Request** | User clicks "Forgot Password" and submits their email. | Learner | High | **Subject:** `Reset Your SisuKai Password`<br>**Body:** Provides a secure, time-sensitive link to the password reset page. Includes a security notice for users who did not request the reset. |
| **Welcome & Email Verification** | A new learner completes the registration form. | Learner | High | **Subject:** `Welcome to SisuKai! Please Verify Your Email`<br>**Body:** Welcomes the new learner, explains the benefits of verifying, and provides a clear verification link/button. |
| **Subscription Confirmation** | A learner successfully subscribes to a new plan (e.g., after a trial). | Learner | High | **Subject:** `Your SisuKai Subscription is Confirmed`<br>**Body:** Confirms the subscription, includes receipt/invoice details, plan name, price, and next billing date. |

### 2.2. Engagement & Retention Notifications

These emails are designed to encourage consistent platform usage and build study habits.

| Notification | Trigger | Audience | Priority | Content Specification |
| :--- | :--- | :--- | :--- | :--- |
| **Study Streak Reminder** | User has an active study streak but has not completed a session by 7 PM local time. | Learner | Medium | **Subject:** `Keep Your {{streak_days}}-Day Streak Alive!`<br>**Body:** A friendly reminder to complete a session to maintain their streak. Includes a deep link to their dashboard or next recommended practice session. |
| **Comeback Reminder** | A learner has been inactive for 3 consecutive days. | Learner | Medium | **Subject:** `We Miss You, {{learner_name}}!`<br>**Body:** A gentle nudge to return to their studies. Could highlight a new feature or a certification they were studying. |
| **Practice Session Summary** | Sent weekly (e.g., Sunday evening). | Learner | Low | **Subject:** `Your Weekly Progress Report from SisuKai`<br>**Body:** A summary of the week's activity: sessions completed, time studied, average score, and areas of improvement. |

### 2.3. Educational & Progress Notifications

These emails are directly related to the learner's educational journey.

| Notification | Trigger | Audience | Priority | Content Specification |
| :--- | :--- | :--- | :--- | :--- |
| **Exam Completion** | A learner completes a benchmark exam or final simulation. | Learner | High | **Subject:** `Your SisuKai Exam Results for {{certification_name}}`<br>**Body:** Provides the final score, pass/fail status, a link to the detailed performance report, and a downloadable certificate of completion (if applicable). |
| **Achievement Unlocked** | A learner earns a new badge or reaches a significant milestone (e.g., 1000 questions answered). | Learner | Medium | **Subject:** `New Achievement Unlocked: {{achievement_name}}!`<br>**Body:** A celebratory email congratulating the learner on their achievement, showing the badge icon, and encouraging them to continue. |
| **New Certification Available** | An admin publishes a new certification course. | Learner | Low | **Subject:** `New Certification Available: {{certification_name}}`<br>**Body:** Announces the new certification, provides a brief description, and includes a link to the certification's landing page. (Should be opt-in). |

### 2.4. Subscription & Lifecycle Notifications

These emails are related to the user's subscription status.

| Notification | Trigger | Audience | Priority | Content Specification |
| :--- | :--- | :--- | :--- | :--- |
| **Trial Expiry Reminder** | 3 days before a free trial period ends. | Learner | High | **Subject:** `Your SisuKai Free Trial is Ending Soon`<br>**Body:** Reminds the learner that their trial is ending and encourages them to upgrade to a paid plan. Includes a clear CTA to the pricing page. |
| **Subscription Renewal Reminder** | 7 days before a subscription is due to renew. | Learner | Medium | **Subject:** `Your SisuKai Subscription Will Renew Soon`<br>**Body:** Informs the learner about the upcoming automatic renewal, including the date and amount. Provides a link to manage their subscription. |

## 3. Learner Portal Changes

To support the notification module, the following changes are required in the learner portal.

### 3.1. Notification Settings Page

A new page at `/learner/settings/notifications` must be created. This page will allow learners to have granular control over the notifications they receive.

- **Structure:** The settings should be grouped by category (e.g., "Engagement & Reminders", "Educational Updates", "Promotions").
- **Controls:** Each non-essential notification type should have a simple toggle switch (On/Off).
- **Channels:** Initially, this will control email notifications. In the future, it can be expanded to include Push and In-App channels.
- **Mandatory Notifications:** Transactional emails (Password Reset, Subscription Confirmations) cannot be disabled.

### 3.2. In-App Notification Center (Future Enhancement)

- A bell icon should be added to the main navigation bar.
- A dropdown panel will display a list of recent, less-urgent notifications (e.g., "Achievement Unlocked").
- This requires using Laravel's `database` notification channel.

## 4. Admin Portal Changes

To give administrators full control over the notification system, the following modules must be added to the admin portal.

### 4.1. Notification Templates Management

- **Location:** `/admin/settings/notifications`
- **Functionality:** A new CRUD interface for managing email templates.
- **Features:**
    - **List View:** Table of all email templates, showing name, subject, and last updated date.
    - **Editor:** A WYSIWYG editor (e.g., TinyMCE) to edit the HTML content of emails.
    - **Placeholders:** A visible list of available personalization tokens (e.g., `{{learner_name}}`, `{{certification_name}}`) for each template.
    - **Send Test Email:** A button to send a test version of the email to the admin's address.

### 4.2. Notification Log

- **Location:** `/admin/notifications/log`
- **Functionality:** A searchable and filterable log of all notifications sent from the platform.
- **Columns:**
    - **Recipient:** Learner's name and email.
    - **Type:** Notification name (e.g., "Study Streak Reminder").
    - **Channel:** Email.
    - **Status:** Sent, Failed, (Future: Opened, Clicked).
    - **Timestamp:** Date and time the notification was sent.
    - **Error Message:** Displays any errors if the delivery failed.

### 4.3. Manual Notification Sender

- **Location:** `/admin/notifications/send`
- **Functionality:** A tool for admins to send one-off notifications.
- **Features:**
    - **Recipient Targeting:** Select learners by name, email, or by group (e.g., "All learners enrolled in PMP").
    - **Content Composer:** A simple form with Subject and Body fields (supports Markdown).
    - **Scheduling:** Option to send immediately or schedule for a future date/time.

## 5. Technical Implementation

### 5.1. Database Schema

**`learner_notification_preferences` Table:**
```sql
CREATE TABLE learner_notification_preferences (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    learner_id BIGINT UNSIGNED NOT NULL,
    notification_type VARCHAR(255) NOT NULL, -- e.g., 'study_streak_reminder'
    email_enabled BOOLEAN DEFAULT TRUE,
    push_enabled BOOLEAN DEFAULT TRUE, -- For future use
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (learner_id) REFERENCES learners(id) ON DELETE CASCADE
);
```

**`notification_templates` Table (Optional, for Admin Editing):**
```sql
CREATE TABLE notification_templates (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL, -- e.g., 'Welcome Email'
    subject VARCHAR(255) NOT NULL,
    html_template TEXT NOT NULL,
    plain_text_template TEXT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);
```

### 5.2. Laravel Implementation

- **Use Laravel Notifications:** The core of the module should be built using Laravel's native notification system (`php artisan make:notification`). This provides a robust, channel-agnostic foundation.
- **Mailable vs. Notification:** Use Notifications for all new emails, as they are more flexible than Mailables. Refactor existing Mailables (`MagicLinkMail`, `VerifyEmailMail`) into Notifications.
- **Queueing:** All notifications MUST be queued to ensure the application's response time is not affected by email sending delays. This is critical for production.
  ```php
  use Illuminate\Contracts\Queue\ShouldQueue;

  class StudyStreakReminder extends Notification implements ShouldQueue
  ```
- **Event Listeners:** Use Laravel's event/listener system to trigger notifications. For example, a `LearnerRegistered` event would trigger a `SendWelcomeEmail` listener.

---

This specification provides a comprehensive blueprint for building a powerful and scalable notification module that will significantly enhance learner engagement and platform value.
