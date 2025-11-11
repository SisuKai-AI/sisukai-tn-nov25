# Phase 1 Testing Guide: Benchmark Flow

**Version:** 1.0  
**Date:** October 29, 2025  
**Phase:** 1 - Benchmark Flow Implementation

---

## Prerequisites

### Server Running
```bash
cd /home/ubuntu/sisukai
php artisan serve --host=0.0.0.0 --port=9898
```

### Test Credentials

**Learner Account:**
- Email: `learner@sisukai.com`
- Password: `password123`
- Enrolled in: CompTIA A+ certification

**Admin Account (if needed):**
- Email: `admin@sisukai.com`
- Password: `password123`

---

## Test Scenario 1: First-Time Benchmark (State 1)

### Objective
Verify that a learner who has never taken a benchmark sees the "Take Benchmark Exam" button and can successfully start the diagnostic assessment.

### Steps

1. **Login as learner**
   - Navigate to: `http://localhost:9898/learner/login`
   - Enter credentials: `learner@sisukai.com` / `password123`
   - Click "Login"

2. **Navigate to enrolled certification**
   - Click "My Certifications" in navigation
   - Click on "CompTIA A+" certification card
   - OR directly navigate to: `http://localhost:9898/learner/certifications/{certification_id}`

3. **Verify button state**
   - Look for enrollment status card in right sidebar
   - Button should display: **"Take Benchmark Exam"** (primary blue)
   - Icon: Speedometer (bi-speedometer2)
   - Helper text: "Start with a diagnostic assessment to personalize your learning"

4. **Click "Take Benchmark Exam"**
   - Should redirect to: `/learner/benchmark/{certification_id}/explain`
   - Explanation page should load

5. **Review explanation page**
   - Verify sections present:
     - "What is a Benchmark Exam?" with speedometer icon
     - "Why Take a Benchmark?" with lightbulb icon
     - "What to Expect" with 4 info cards (Questions, Time Limit, Resume, Results)
     - "Important Notes" warning alert
     - "Tips for Success" card at bottom
   - Verify breadcrumb navigation
   - Verify action buttons: "Back to Certification" and "Start Benchmark Exam"

6. **Click "Start Benchmark Exam"**
   - Form submits via POST to: `/learner/benchmark/{certification_id}/create`
   - Should create ExamAttempt record with exam_type='benchmark'
   - Should redirect to: `/learner/benchmark/{certification_id}/start`
   - Should then redirect to: `/learner/exams/{exam_attempt_id}/take`

7. **Verify exam interface**
   - Timer should be running
   - Question 1 should be displayed
   - Navigation panel should show all questions
   - Flag button should be available
   - "Submit Exam" button should be visible

8. **Take the exam** (optional for full flow)
   - Answer a few questions
   - Flag a question
   - Navigate between questions
   - Submit exam when ready

9. **View results**
   - Should see overall score
   - Should see domain-level breakdown
   - Should see correct/incorrect counts

10. **Return to certification detail**
    - Click "Back to Certification" or navigate manually
    - Button should now show: **"Continue Learning"** (success green)
    - Helper text should show: "Benchmark completed: XX.X%"

### Expected Results

✅ "Take Benchmark Exam" button displays correctly  
✅ Explanation page loads with all sections  
✅ Benchmark exam is created successfully  
✅ Exam interface loads and functions properly  
✅ Button updates to "Continue Learning" after completion  

### Database Verification

```bash
# Check if benchmark was created
sqlite3 database/database.sqlite "SELECT id, exam_type, status, score_percentage FROM exam_attempts WHERE learner_id='019a28a3-6785-7180-a421-354e793186f1' AND exam_type='benchmark';"

# Check question distribution
sqlite3 database/database.sqlite "SELECT COUNT(*) FROM exam_attempt_questions WHERE exam_attempt_id='{exam_attempt_id}';"
```

---

## Test Scenario 2: Resume In-Progress Benchmark (State 2)

### Objective
Verify that a learner with an in-progress benchmark sees the "Resume Benchmark Exam" button and can continue from where they left off.

### Setup
Create an in-progress benchmark (either by starting one and not completing it, or via database):

```bash
# Option 1: Start a benchmark and close browser before completing
# Option 2: Update existing benchmark status
sqlite3 database/database.sqlite "UPDATE exam_attempts SET status='in_progress', completed_at=NULL WHERE id='{exam_attempt_id}';"
```

### Steps

1. **Login as learner**
   - Navigate to: `http://localhost:9898/learner/login`
   - Enter credentials

2. **Navigate to certification detail**
   - Go to CompTIA A+ certification page

3. **Verify button state**
   - Button should display: **"Resume Benchmark Exam"** (warning yellow/orange)
   - Icon: Arrow clockwise (bi-arrow-clockwise)
   - Helper text: "Complete your benchmark to unlock personalized practice"

4. **Click "Resume Benchmark Exam"**
   - Should redirect to: `/learner/benchmark/{certification_id}/start`
   - Should then redirect to: `/learner/exams/{exam_attempt_id}/take`
   - Should load at the last question or first unanswered question

5. **Verify exam state**
   - Previously answered questions should show answers
   - Flagged questions should still be flagged
   - Timer should continue from remaining time

6. **Complete the exam**
   - Answer remaining questions
   - Submit exam

7. **Return to certification**
   - Button should update to "Continue Learning"

### Expected Results

✅ "Resume Benchmark Exam" button displays correctly  
✅ Exam resumes from correct position  
✅ Previous answers are preserved  
✅ Button updates after completion  

---

## Test Scenario 3: Completed Benchmark (State 3)

### Objective
Verify that a learner with a completed benchmark sees the "Continue Learning" button with their score.

### Setup
Ensure learner has a completed benchmark (exam_type='benchmark', status='completed').

### Steps

1. **Login as learner**
   - Navigate to login page
   - Enter credentials

2. **Navigate to certification detail**
   - Go to CompTIA A+ certification page

3. **Verify button state**
   - Button should display: **"Continue Learning"** (success green)
   - Icon: Play circle (bi-play-circle)
   - Helper text: "Benchmark completed: XX.X%" (shows actual score)

4. **Click "Continue Learning"**
   - Currently links to "#" (placeholder)
   - Will be implemented in Phase 3 to show practice recommendations modal

### Expected Results

✅ "Continue Learning" button displays correctly  
✅ Score percentage is shown accurately  
✅ Button has success (green) styling  

---

## Test Scenario 4: Retake Benchmark

### Objective
Verify that a learner can retake a benchmark exam to update their baseline assessment.

### Steps

1. **Login as learner with completed benchmark**
   - Navigate to certification detail page

2. **Click "Continue Learning"** (or navigate to explanation page manually)
   - Go to: `/learner/benchmark/{certification_id}/explain`

3. **Verify retake messaging**
   - Should see success alert: "You've already completed a benchmark exam"
   - Should show previous score
   - Button should say: "Retake Benchmark Exam"

4. **Click "Retake Benchmark Exam"**
   - Should create new ExamAttempt with incremented attempt_number
   - Should redirect to exam interface

5. **Complete new benchmark**
   - Take the exam
   - Submit answers

6. **Verify new attempt**
   - Check that latest benchmark is used for button state
   - Verify attempt_number incremented

### Expected Results

✅ Retake option is available  
✅ New attempt is created with correct attempt_number  
✅ Latest attempt is used for button state  
✅ Previous attempts are preserved in history  

### Database Verification

```bash
# Check all benchmark attempts for learner
sqlite3 database/database.sqlite "SELECT id, attempt_number, status, score_percentage, created_at FROM exam_attempts WHERE learner_id='019a28a3-6785-7180-a421-354e793186f1' AND exam_type='benchmark' ORDER BY created_at DESC;"
```

---

## Test Scenario 5: Question Distribution

### Objective
Verify that benchmark questions are distributed evenly across all certification domains.

### Steps

1. **Create a benchmark exam**
   - Follow Test Scenario 1 steps 1-6

2. **Query question distribution**
   ```bash
   sqlite3 database/database.sqlite "
   SELECT 
       d.name as domain_name,
       COUNT(eaq.id) as question_count
   FROM exam_attempt_questions eaq
   JOIN questions q ON eaq.question_id = q.id
   JOIN domains d ON q.domain_id = d.id
   WHERE eaq.exam_attempt_id = '{exam_attempt_id}'
   GROUP BY d.id
   ORDER BY d.order;
   "
   ```

3. **Verify distribution**
   - Questions should be roughly evenly distributed
   - Formula: `ceil(total_questions / domain_count)`
   - Example: 45 questions / 5 domains = 9 questions per domain

### Expected Results

✅ Questions are distributed across all domains  
✅ Distribution is roughly even (±1 question variance acceptable)  
✅ No domain is excluded  
✅ Total question count matches certification config  

---

## Test Scenario 6: Enrollment Validation

### Objective
Verify that only enrolled learners can access benchmark exams.

### Steps

1. **Login as learner**
   - Use learner account

2. **Attempt to access benchmark for non-enrolled certification**
   - Get a certification ID you're NOT enrolled in
   - Navigate to: `/learner/benchmark/{other_certification_id}/explain`

3. **Verify error handling**
   - Should redirect to certifications index
   - Should show error message: "You must enroll in this certification first."

4. **Attempt to create benchmark for non-enrolled certification**
   - POST to: `/learner/benchmark/{other_certification_id}/create`
   - Should redirect with error

### Expected Results

✅ Non-enrolled learners cannot access benchmark  
✅ Appropriate error messages are shown  
✅ Redirects to safe location (certifications index)  

---

## Test Scenario 7: Duplicate Prevention

### Objective
Verify that learners cannot create duplicate in-progress benchmarks.

### Setup
Create an in-progress benchmark for the learner.

### Steps

1. **Login as learner with in-progress benchmark**

2. **Navigate to explanation page**
   - Go to: `/learner/benchmark/{certification_id}/explain`

3. **Click "Resume Benchmark Exam"**
   - Should redirect to existing exam

4. **Attempt to create new benchmark via direct POST**
   ```bash
   # Get CSRF token and session cookie first
   curl -X POST http://localhost:9898/learner/benchmark/{certification_id}/create \
        -H "Cookie: laravel_session=..." \
        -H "X-CSRF-TOKEN: ..."
   ```

5. **Verify duplicate prevention**
   - Should redirect to existing in-progress exam
   - Should show info message: "Resuming your in-progress benchmark exam."
   - Should NOT create a new exam_attempt record

### Expected Results

✅ Duplicate in-progress benchmarks are prevented  
✅ Learner is redirected to existing exam  
✅ Appropriate messaging is shown  

---

## Test Scenario 8: Configuration Respect

### Objective
Verify that benchmark exams respect certification-specific configuration.

### Steps

1. **Check certification configuration**
   ```bash
   sqlite3 database/database.sqlite "SELECT exam_questions, exam_duration, passing_score FROM certifications WHERE id='{certification_id}';"
   ```

2. **Create benchmark exam**
   - Follow Test Scenario 1 steps

3. **Verify exam configuration**
   ```bash
   sqlite3 database/database.sqlite "SELECT time_limit_minutes, passing_score FROM exam_attempts WHERE id='{exam_attempt_id}';"
   ```

4. **Verify question count**
   ```bash
   sqlite3 database/database.sqlite "SELECT COUNT(*) FROM exam_attempt_questions WHERE exam_attempt_id='{exam_attempt_id}';"
   ```

5. **Compare values**
   - time_limit_minutes should match exam_duration
   - passing_score should match certification passing_score
   - question count should match exam_questions (or default 45)

### Expected Results

✅ Time limit matches certification config  
✅ Passing score matches certification config  
✅ Question count matches certification config  
✅ Defaults are used when config is null  

---

## Test Scenario 9: UI/UX Verification

### Objective
Verify that all UI elements are properly styled and responsive.

### Steps

1. **Desktop view (1920x1080)**
   - Navigate through all benchmark pages
   - Verify layout is clean and professional
   - Check icon alignment and sizing
   - Verify button states and colors

2. **Tablet view (768x1024)**
   - Resize browser or use device emulation
   - Verify responsive behavior
   - Check that cards stack properly
   - Verify navigation remains accessible

3. **Mobile view (375x667)**
   - Test on mobile device or emulator
   - Verify touch targets are adequate
   - Check that text is readable
   - Verify buttons are full-width on mobile

4. **Accessibility**
   - Use screen reader to test navigation
   - Verify all interactive elements have labels
   - Check color contrast ratios
   - Test keyboard navigation

### Expected Results

✅ Layout is responsive across all screen sizes  
✅ Icons and buttons are properly styled  
✅ Text is readable at all sizes  
✅ Touch targets are adequate for mobile  
✅ Accessibility standards are met  

---

## Automated Testing (Future)

### Unit Tests
```php
// tests/Unit/BenchmarkControllerTest.php
test('benchmark creation distributes questions across domains')
test('duplicate in-progress benchmarks are prevented')
test('non-enrolled learners cannot create benchmarks')
test('benchmark configuration respects certification settings')
```

### Feature Tests
```php
// tests/Feature/BenchmarkFlowTest.php
test('learner can view benchmark explanation page')
test('learner can create and start benchmark exam')
test('learner can resume in-progress benchmark')
test('learner sees correct button state based on benchmark status')
```

### Browser Tests (Dusk)
```php
// tests/Browser/BenchmarkFlowTest.php
test('complete benchmark flow from explanation to results')
test('button states update correctly')
test('retake benchmark creates new attempt')
```

---

## Troubleshooting

### Issue: Button not updating after benchmark completion
**Solution:** Clear browser cache or hard refresh (Ctrl+Shift+R)

### Issue: Questions not distributed evenly
**Solution:** Check that all domains have approved questions

### Issue: Cannot access benchmark explanation page
**Solution:** Verify enrollment status in learner_certification table

### Issue: Duplicate benchmarks being created
**Solution:** Check for existing in-progress benchmarks before creation

### Issue: Exam interface not loading
**Solution:** Verify ExamAttempt and ExamAttemptQuestion records were created

---

## Success Criteria

Phase 1 is considered successfully tested when:

- ✅ All 3 button states display correctly
- ✅ Explanation page renders with all sections
- ✅ Benchmark exams are created successfully
- ✅ Questions are distributed across domains
- ✅ Enrollment validation works
- ✅ Duplicate prevention works
- ✅ Configuration is respected
- ✅ UI is responsive and accessible
- ✅ Integration with existing exam infrastructure works
- ✅ No errors in Laravel logs

---

## Next Phase Testing

Once Phase 1 testing is complete, proceed to Phase 2 testing which will focus on:

- Domain performance classification (weak/moderate/strong)
- Enhanced results visualization
- Personalized recommendations
- Retake benchmark functionality

---

**Document Version:** 1.0  
**Last Updated:** October 29, 2025  
**Tested By:** [To be filled during testing]  
**Test Results:** [To be documented]

