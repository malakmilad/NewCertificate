#!/bin/bash

# Simple Queue Worker Starter Script
# This script starts the Laravel queue worker in the background

# Get the directory where this script is located
SCRIPT_DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"
cd "$SCRIPT_DIR"

# Check if queue worker is already running
if pgrep -f "queue:work" > /dev/null; then
    echo "Queue worker is already running!"
    echo "To stop it, run: pkill -f 'queue:work'"
    exit 1
fi

# Start queue worker in background
nohup php artisan queue:work database --sleep=3 --tries=3 --max-time=3600 > storage/logs/queue-worker.log 2>&1 &

# Get the process ID
QUEUE_PID=$!

echo "Queue worker started with PID: $QUEUE_PID"
echo "Logs are being written to: storage/logs/queue-worker.log"
echo ""
echo "To check if it's running: ps aux | grep queue:work"
echo "To stop it: kill $QUEUE_PID"
echo "To view logs: tail -f storage/logs/queue-worker.log"

