# Production Email Setup - Complete Solution

## Problem
- `QUEUE_CONNECTION=sync` → Causes timeout in production
- `QUEUE_CONNECTION=database` → Emails don't send (no queue worker running)

## Solution
The listener is now **queued**, so everything runs in the background. You just need to run a queue worker.

---

## Quick Setup (3 Steps)

### Step 1: Set Queue Connection in `.env`
```env
QUEUE_CONNECTION=database
```

### Step 2: Run Migrations (if not done)
```bash
php artisan migrate
```

### Step 3: Start Queue Worker

**Option A: Using the provided script (Easiest)**
```bash
chmod +x start-queue-worker.sh
./start-queue-worker.sh
```

**Option B: Manual command**
```bash
nohup php artisan queue:work database --sleep=3 --tries=3 --max-time=3600 > storage/logs/queue-worker.log 2>&1 &
```

**Option C: Using Supervisor (Best for production - auto-restarts)**
See detailed instructions below.

---

## How It Works Now

```
1. Admin generates certificates
   ↓
2. HTTP request returns IMMEDIATELY (no timeout!)
   ↓
3. Certificate generation + email queuing happens in BACKGROUND
   ↓
4. Queue worker processes emails one by one
   ↓
5. Students receive emails
```

---

## Verify It's Working

### Check Queue Worker is Running
```bash
ps aux | grep "queue:work"
```

You should see a process like:
```
www-data  12345  ... php artisan queue:work database
```

### Check Queue Logs
```bash
tail -f storage/logs/queue-worker.log
```

### Check Application Logs
```bash
tail -f storage/logs/laravel.log | grep "Email queued"
```

### Check Jobs in Database
```sql
SELECT COUNT(*) FROM jobs;
```

If this number keeps decreasing, the queue worker is processing jobs!

---

## Supervisor Setup (Recommended for Production)

Supervisor automatically restarts the queue worker if it crashes.

### Step 1: Install Supervisor (if not installed)
```bash
sudo apt-get update
sudo apt-get install supervisor
```

### Step 2: Create Supervisor Config
Create file: `/etc/supervisor/conf.d/laravel-worker.conf`

```ini
[program:laravel-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /path/to/your/project/artisan queue:work database --sleep=3 --tries=3 --max-time=3600
autostart=true
autorestart=true
stopasgroup=true
killasgroup=true
user=www-data
numprocs=1
redirect_stderr=true
stdout_logfile=/path/to/your/project/storage/logs/worker.log
stopwaitsecs=3600
```

**Important:** Replace `/path/to/your/project` with your actual project path!

### Step 3: Update Supervisor
```bash
sudo supervisorctl reread
sudo supervisorctl update
sudo supervisorctl start laravel-worker:*
```

### Step 4: Check Status
```bash
sudo supervisorctl status laravel-worker:*
```

Should show: `laravel-worker:laravel-worker_00   RUNNING`

---

## Cron Job Alternative (Simple but Less Reliable)

If you can't use Supervisor, you can use a cron job that runs every minute:

```bash
crontab -e
```

Add this line:
```cron
* * * * * cd /path/to/your/project && php artisan queue:work database --stop-when-empty >> /dev/null 2>&1
```

This processes any pending jobs every minute. Less efficient than a persistent worker, but works.

---

## Troubleshooting

### Emails Not Sending?

1. **Check queue worker is running:**
   ```bash
   ps aux | grep queue:work
   ```

2. **Check for failed jobs:**
   ```bash
   php artisan queue:failed
   ```

3. **Retry failed jobs:**
   ```bash
   php artisan queue:retry all
   ```

4. **Check queue logs:**
   ```bash
   tail -f storage/logs/queue-worker.log
   ```

5. **Check application logs:**
   ```bash
   tail -f storage/logs/laravel.log
   ```

### Queue Worker Keeps Stopping?

- Use Supervisor (it auto-restarts)
- Check server resources (memory, CPU)
- Check logs for errors

### Jobs Stuck in Queue?

1. **Restart queue worker:**
   ```bash
   pkill -f "queue:work"
   ./start-queue-worker.sh
   ```

2. **Or with Supervisor:**
   ```bash
   sudo supervisorctl restart laravel-worker:*
   ```

### Clear Stuck Jobs (Use Carefully!)

```bash
php artisan queue:flush
```

**Warning:** This deletes ALL queued jobs!

---

## Testing

1. Set `QUEUE_CONNECTION=database` in `.env`
2. Start queue worker: `./start-queue-worker.sh`
3. Generate certificates in admin panel
4. Page should load immediately (no timeout)
5. Check logs: `tail -f storage/logs/queue-worker.log`
6. Verify emails are sent to students

---

## Important Notes

- **Queue worker MUST be running** for emails to send
- If worker stops, emails will queue but not send until restarted
- Use Supervisor for production to ensure worker always runs
- Check logs regularly to monitor email sending

---

## Quick Commands Reference

```bash
# Start queue worker
./start-queue-worker.sh

# Check if running
ps aux | grep queue:work

# Stop queue worker
pkill -f "queue:work"

# View queue logs
tail -f storage/logs/queue-worker.log

# Check failed jobs
php artisan queue:failed

# Retry failed jobs
php artisan queue:retry all

# Process queue manually (one time)
php artisan queue:work database --stop-when-empty
```

