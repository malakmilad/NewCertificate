#!/bin/bash

# Optimized Queue Worker Starter Script
# This script starts multiple Laravel queue workers for faster processing

# Get the directory where this script is located
SCRIPT_DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"
cd "$SCRIPT_DIR"

# Number of workers to run (adjust based on your server capacity)
# More workers = faster processing, but uses more CPU/memory
WORKER_COUNT=${1:-3}  # Default to 3 workers if not specified

# Check if queue workers are already running
if pgrep -f "queue:work" > /dev/null; then
    echo "Queue workers are already running!"
    echo "To stop them, run: pkill -f 'queue:work'"
    echo "Or use: ./stop-queue-workers.sh"
    exit 1
fi

echo "Starting $WORKER_COUNT queue workers for faster processing..."
echo ""

# Start multiple workers
for i in $(seq 1 $WORKER_COUNT); do
    nohup php artisan queue:work database --sleep=1 --tries=3 --max-time=3600 > storage/logs/queue-worker-$i.log 2>&1 &
    WORKER_PID=$!
    echo "Worker $i started with PID: $WORKER_PID (log: storage/logs/queue-worker-$i.log)"
done

echo ""
echo "All $WORKER_COUNT workers started successfully!"
echo ""
echo "To check if they're running: ps aux | grep queue:work"
echo "To stop all workers: pkill -f 'queue:work'"
echo "To view logs: tail -f storage/logs/queue-worker-*.log"
echo ""
echo "Tip: You can specify number of workers: ./start-queue-worker.sh 5"

