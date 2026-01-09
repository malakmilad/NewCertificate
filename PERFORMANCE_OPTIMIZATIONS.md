# Performance Optimizations - Faster Email Processing

## What Was Optimized

### 1. **Parallel Processing** ⚡
- **Before:** Students processed one by one sequentially
- **After:** Each student gets their own job, processed in parallel
- **Speed Gain:** 3-5x faster with multiple workers

### 2. **Font Caching** 🚀
- **Before:** Fonts loaded from database on every student iteration
- **After:** Fonts loaded once and passed to all jobs
- **Speed Gain:** Eliminates N database queries (N = number of students)

### 3. **Multiple Queue Workers** 🔥
- **Before:** Single worker processing jobs one at a time
- **After:** Multiple workers (default: 3) processing jobs simultaneously
- **Speed Gain:** Linear speedup (3 workers = ~3x faster)

### 4. **Reduced Sleep Time** ⏱️
- **Before:** 3 seconds wait between jobs when queue is empty
- **After:** 1 second wait
- **Speed Gain:** Faster job pickup when new jobs arrive

---

## How It Works Now

```
1. Admin generates certificates
   ↓
2. StoreAttachmentListener dispatches individual jobs for EACH student
   ↓
3. Multiple queue workers process jobs in PARALLEL
   ↓
4. Each job:
   - Generates PDF
   - Saves attachment
   - Sends email
   ↓
5. All students processed much faster! 🎉
```

---

## How to Use

### Step 1: Stop Old Workers (if running)
```bash
./stop-queue-workers.sh
```

### Step 2: Start Optimized Workers
```bash
# Default: 3 workers (recommended)
./start-queue-worker.sh

# Or specify number of workers (more = faster, but uses more resources)
./start-queue-worker.sh 5
```

### Step 3: Verify Workers Are Running
```bash
ps aux | grep queue:work
```

You should see multiple processes:
```
www-data  12345  ... php artisan queue:work database
www-data  12346  ... php artisan queue:work database
www-data  12347  ... php artisan queue:work database
```

---

## Performance Comparison

### Before (Sequential Processing)
- 100 students = ~100 seconds (1 student/second)
- Single worker
- Fonts loaded 100 times

### After (Parallel Processing)
- 100 students = ~35 seconds (with 3 workers)
- 3 workers processing simultaneously
- Fonts loaded once

**Result: ~3x faster!** 🚀

---

## Configuration

### Number of Workers

**Recommended:**
- Small server (1-2 CPU cores): 2-3 workers
- Medium server (4 CPU cores): 3-5 workers
- Large server (8+ CPU cores): 5-10 workers

**How to adjust:**
```bash
# Start with 5 workers
./start-queue-worker.sh 5
```

### Monitor Resource Usage

```bash
# Check CPU usage
top

# Check memory usage
free -h

# Check queue worker processes
ps aux | grep queue:work
```

If your server is overloaded, reduce the number of workers.

---

## Troubleshooting

### Workers Not Processing Fast Enough?

1. **Increase number of workers:**
   ```bash
   ./stop-queue-workers.sh
   ./start-queue-worker.sh 5  # Try 5 workers
   ```

2. **Check if workers are actually running:**
   ```bash
   ps aux | grep queue:work
   ```

3. **Check queue logs for errors:**
   ```bash
   tail -f storage/logs/queue-worker-*.log
   ```

### Server Running Out of Memory?

1. **Reduce number of workers:**
   ```bash
   ./stop-queue-workers.sh
   ./start-queue-worker.sh 2  # Use only 2 workers
   ```

2. **Check memory usage:**
   ```bash
   free -h
   ```

### Jobs Getting Stuck?

1. **Restart workers:**
   ```bash
   ./stop-queue-workers.sh
   ./start-queue-worker.sh
   ```

2. **Check failed jobs:**
   ```bash
   php artisan queue:failed
   ```

3. **Retry failed jobs:**
   ```bash
   php artisan queue:retry all
   ```

---

## Technical Details

### New Job: `ProcessStudentCertificate`
- Location: `app/Jobs/ProcessStudentCertificate.php`
- Processes one student at a time
- Can run in parallel with other jobs

### Updated Listener: `StoreAttachmentListener`
- Location: `app/Listeners/StoreAttachmentListener.php`
- Now just dispatches jobs (very fast)
- Loads fonts once and passes to all jobs

### Queue Workers
- Multiple workers can run simultaneously
- Each worker processes jobs independently
- Workers share the same queue

---

## Best Practices

1. **Start with 3 workers** - Good balance of speed and resource usage
2. **Monitor server resources** - Adjust worker count based on CPU/memory
3. **Use Supervisor** - Auto-restart workers if they crash (see PRODUCTION_EMAIL_SETUP.md)
4. **Check logs regularly** - Monitor for errors or performance issues

---

## Quick Commands

```bash
# Start workers (default: 3)
./start-queue-worker.sh

# Start with custom count
./start-queue-worker.sh 5

# Stop all workers
./stop-queue-workers.sh

# Check if running
ps aux | grep queue:work

# View logs
tail -f storage/logs/queue-worker-*.log
```

---

## Expected Performance

With 3 workers processing 100 students:
- **Before:** ~100 seconds
- **After:** ~35 seconds
- **Improvement:** ~3x faster ⚡

With 5 workers:
- **After:** ~20 seconds
- **Improvement:** ~5x faster 🔥

*Actual times depend on PDF generation speed, email server response, and server resources.*


