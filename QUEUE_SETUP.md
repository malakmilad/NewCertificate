# Email Sending Configuration Guide

## Problem Solved
The 504 Gateway Timeout was happening because emails were being sent synchronously during the HTTP request, blocking it until all emails finished. 

## Solution
The system now automatically detects your queue configuration:
- **If `QUEUE_CONNECTION=sync`**: Emails send immediately (works for local development)
- **If `QUEUE_CONNECTION=database`**: Emails are queued (requires queue worker for server)

## Changes Made

1. **Smart Email Sending**:
   - Automatically uses `send()` when queue is "sync" (immediate sending)
   - Automatically uses `queue()` when queue is "database" (background processing)
   - No code changes needed - just configure your `.env` file

2. **StoreAttachmentListener**:
   - PDF generation happens synchronously (fast, no timeout risk)
   - Email sending is conditional based on queue configuration

## Server Setup - Choose Your Approach

### Option 1: Synchronous Sending (Simple, but may timeout with many students)

In your server's `.env` file:
```env
QUEUE_CONNECTION=sync
```

**Pros:**
- No queue worker needed
- Emails send immediately
- Simple setup

**Cons:**
- May timeout if sending to many students at once
- HTTP request waits for all emails to complete

### Option 2: Queued Sending (Recommended for production)

**Step 1:** Configure Queue Connection
In your server's `.env` file:
```env
QUEUE_CONNECTION=database
```

**Step 2:** Ensure Queue Tables Exist
Run migrations if not already done:
```bash
php artisan migrate
```

### Step 3: Start Queue Worker (CRITICAL!)
You **MUST** run a queue worker on your server for emails to be sent. Choose one method:

#### Option A: Using Supervisor (Recommended for Production)
Create `/etc/supervisor/conf.d/laravel-worker.conf`:
```ini
[program:laravel-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /path/to/your/project/artisan queue:work database --sleep=3 --tries=3 --max-time=3600
autostart=true
autorestart=true
stopasgroup=true
killasgroup=true
user=www-data
numprocs=2
redirect_stderr=true
stdout_logfile=/path/to/your/project/storage/logs/worker.log
stopwaitsecs=3600
```

Then:
```bash
sudo supervisorctl reread
sudo supervisorctl update
sudo supervisorctl start laravel-worker:*
```

#### Option B: Using Systemd (Alternative)
Create `/etc/systemd/system/laravel-worker.service`:
```ini
[Unit]
Description=Laravel Queue Worker
After=network.target

[Service]
User=www-data
Group=www-data
Restart=always
ExecStart=/usr/bin/php /path/to/your/project/artisan queue:work database --sleep=3 --tries=3

[Install]
WantedBy=multi-user.target
```

Then:
```bash
sudo systemctl daemon-reload
sudo systemctl enable laravel-worker
sudo systemctl start laravel-worker
```

#### Option C: Using Screen/Tmux (Quick Test)
```bash
screen -S queue
php artisan queue:work database --sleep=3 --tries=3
# Press Ctrl+A then D to detach
```

#### Option D: Using nohup (Simple Background)
```bash
nohup php artisan queue:work database --sleep=3 --tries=3 > storage/logs/queue.log 2>&1 &
```

### Step 4: Verify Queue Worker is Running
Check if jobs are being processed:
```bash
# Check queue status
php artisan queue:work --help

# Monitor queue in real-time
php artisan queue:listen database
```

### Step 5: Monitor Queue Jobs
Check the `jobs` table in your database:
```sql
SELECT * FROM jobs ORDER BY created_at DESC LIMIT 10;
```

Check failed jobs:
```sql
SELECT * FROM failed_jobs ORDER BY failed_at DESC LIMIT 10;
```

## Testing

1. Generate certificates as usual
2. The HTTP request should return immediately (no timeout)
3. Check `storage/logs/laravel.log` for "Email queued successfully" messages
4. Check `storage/logs/worker.log` (if using supervisor) for email sending status
5. Verify emails are actually sent to students

## Troubleshooting

### Emails not sending?
1. **Check queue worker is running:**
   ```bash
   ps aux | grep "queue:work"
   ```

2. **Check for failed jobs:**
   ```bash
   php artisan queue:failed
   ```

3. **Retry failed jobs:**
   ```bash
   php artisan queue:retry all
   ```

4. **Check logs:**
   ```bash
   tail -f storage/logs/laravel.log
   ```

### Queue worker keeps stopping?
- Use Supervisor or Systemd (Options A or B) for automatic restarts
- Check server resources (memory, CPU)
- Increase `--max-time` if jobs take longer

### Jobs stuck in queue?
- Restart queue worker: `sudo supervisorctl restart laravel-worker:*`
- Clear stuck jobs: `php artisan queue:flush` (use carefully!)

## Important Notes

- **Queue worker MUST be running** for emails to be sent
- If queue worker stops, emails will queue but not send until it's restarted
- Failed jobs are stored in `failed_jobs` table - check regularly
- Use Supervisor or Systemd for production to ensure worker always runs

