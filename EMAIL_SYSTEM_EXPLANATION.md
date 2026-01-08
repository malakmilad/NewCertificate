# How Arabic and English Student Emails Work

## Overview
The system automatically detects the language of the **course name** and sends the appropriate email template (Arabic or English) to each student.

---

## Complete Flow

### Step 1: Certificate Generation Trigger
When an admin generates certificates for a group:
```
User clicks "Generate Certificates"
    ↓
GroupTemplateController::store() is called
    ↓
AttachmentEvent is fired with (group_id, template_id)
```

### Step 2: Event Processing
```
AttachmentEvent
    ↓
AttachmentListener handles the event
    ↓
Gets all students enrolled in the group
    ↓
Fires StoreAttachmentEvent with students, template, group
```

### Step 3: Certificate Generation & Email Sending
```
StoreAttachmentEvent
    ↓
StoreAttachmentListener handles the event
    ↓
For EACH student:
    1. Generate PDF certificate
    2. Save PDF to public/attachment/
    3. Detect course language
    4. Send appropriate email
```

---

## Language Detection (The Key Part)

### How It Works

**Location:** `app/Listeners/StoreAttachmentListener.php` (Lines 70-71)

```php
$detector = new LanguageDetector();
$language = $detector->evaluate($course->name)->getLanguage();
```

**What it does:**
- Analyzes the **course name** (e.g., "إدارة المشروعات" or "Project Management")
- Uses the `landrok/language-detector` package
- Returns language code: `'ar'` for Arabic, `'en'` for English, etc.

**Examples:**
- Course: "إدارة المشروعات" → Language: `'ar'` → **Arabic email**
- Course: "Project Management" → Language: `'en'` → **English email**
- Course: "Digital Marketing" → Language: `'en'` → **English email**

### Decision Logic (Lines 78-114)

```php
if ($language == 'ar') {
    // Send Arabic email
    $mail = new ArabicStudentMail($student, $filePath, $course);
    Mail::to($student->email)->send($mail); // or queue()
} else {
    // Send English email (default for any non-Arabic language)
    $mail = new EnglishStudentMail($student, $filePath, $course);
    Mail::to($student->email)->send($mail); // or queue()
}
```

**Important:** If language is NOT `'ar'`, it defaults to English email.

---

## Email Classes

### ArabicStudentMail
**File:** `app/Mail/ArabicStudentMail.php`

**Properties:**
- `$student` - Student object
- `$path` - Path to PDF certificate file
- `$course` - Course object

**Email Details:**
- **From:** noreply@eeic.gov.eg (EEIC)
- **Subject:** "شهادة إتمام البرنامج التدريبي" (Certificate of Completion of Training Program)
- **View:** `resources/views/admin/mail/arabic.blade.php`
- **Attachment:** PDF certificate
- **Direction:** RTL (Right-to-Left)

**Email Content (Arabic):**
```
الأستاذ/ة [Student Name]
تحية طيبة وبعد

يسر مركز مصر لريادة الأعمال والابتكار إرفاق شهادة إتمام برنامج [Course Name] بنجاح.

[Links to educational platform and Facebook page]

تحياتنا،
```

### EnglishStudentMail
**File:** `app/Mail/EnglishStudentMail.php`

**Properties:**
- `$student` - Student object
- `$path` - Path to PDF certificate file
- `$course` - Course object

**Email Details:**
- **From:** noreply@eeic.gov.eg (EEIC)
- **Subject:** "Certificate of Completion of the Training Program"
- **View:** `resources/views/admin/mail/english.blade.php`
- **Attachment:** PDF certificate
- **Direction:** LTR (Left-to-Right)

**Email Content (English):**
```
Dear [Student Name],

Egypt Entrepreneurship & Innovation Center is pleased to attach your Certificate of Completion for the [Course Name]

[Links to educational platform and Facebook page]

Best regards,
```

---

## When Emails Are Sent

### Synchronous Mode (QUEUE_CONNECTION=sync)
- Emails send **immediately** during the HTTP request
- Request waits until all emails are sent
- Good for: Local development, small groups
- Risk: Timeout with many students

### Queued Mode (QUEUE_CONNECTION=database)
- Emails are **queued** in the database
- HTTP request returns immediately
- Queue worker processes emails in background
- Good for: Production, large groups
- Requires: Queue worker running

---

## Visual Flow Diagram

```
┌─────────────────────────────────────────────────────────┐
│  Admin Generates Certificates for Group                │
└──────────────────┬──────────────────────────────────────┘
                   │
                   ▼
┌─────────────────────────────────────────────────────────┐
│  StoreAttachmentListener::handle()                      │
│  For each student:                                      │
└──────────────────┬──────────────────────────────────────┘
                   │
        ┌──────────┴──────────┐
        │                     │
        ▼                     ▼
┌──────────────┐    ┌──────────────────────┐
│ Generate PDF │    │ Detect Course        │
│ Certificate  │    │ Language             │
└──────┬───────┘    └──────┬───────────────┘
       │                    │
       │                    ▼
       │            ┌───────────────┐
       │            │ Language ==  │
       │            │    'ar'?     │
       │            └───┬──────┬───┘
       │                │      │
       │         YES    │      │    NO
       │                │      │
       ▼                ▼      ▼
┌──────────────┐  ┌──────────────┐
│ Save PDF     │  │ Arabic Email │  │ English Email │
│ to Database  │  │ or           │  │ or            │
└──────────────┘  │ English Email│  │ Arabic Email  │
                  └──────────────┘  └──────────────┘
```

---

## Code Locations

### Main Logic
- **File:** `app/Listeners/StoreAttachmentListener.php`
- **Lines 70-114:** Language detection and email sending

### Email Classes
- **Arabic:** `app/Mail/ArabicStudentMail.php`
- **English:** `app/Mail/EnglishStudentMail.php`

### Email Templates
- **Arabic:** `resources/views/admin/mail/arabic.blade.php`
- **English:** `resources/views/admin/mail/english.blade.php`

### Language Detection Package
- **Package:** `landrok/language-detector` (v1.4)
- **Usage:** `LanguageDetector::evaluate($text)->getLanguage()`

---

## Examples

### Example 1: Arabic Course
```
Course Name: "إدارة المشروعات"
    ↓
Language Detection: 'ar'
    ↓
Email Sent: ArabicStudentMail
    ↓
Subject: "شهادة إتمام البرنامج التدريبي"
Content: Arabic text, RTL direction
```

### Example 2: English Course
```
Course Name: "Project Management"
    ↓
Language Detection: 'en'
    ↓
Email Sent: EnglishStudentMail
    ↓
Subject: "Certificate of Completion of the Training Program"
Content: English text, LTR direction
```

### Example 3: Mixed Language Course
```
Course Name: "Digital Marketing - التسويق الرقمي"
    ↓
Language Detection: (depends on which language dominates)
    ↓
Email Sent: Based on detected language
```

---

## Important Notes

1. **Language is detected from COURSE NAME, not student name or email**
2. **If language is not 'ar', it defaults to English email**
3. **Both emails include the PDF certificate as attachment**
4. **Email sending can be synchronous or queued based on QUEUE_CONNECTION**
5. **All email activity is logged in `storage/logs/laravel.log`**

---

## Troubleshooting

### Check which email was sent:
```bash
tail -f storage/logs/laravel.log | grep "Email sent"
```

### Check language detection:
Look for logs showing:
- `'Email sent successfully (Arabic)'` or
- `'Email sent successfully (English)'`

### If wrong language email is sent:
- Check the course name in database
- Verify language detection is working: `$detector->evaluate($course->name)->getLanguage()`

