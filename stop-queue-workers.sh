#!/bin/bash

# Stop all queue workers

SCRIPT_DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"
cd "$SCRIPT_DIR"

if ! pgrep -f "queue:work" > /dev/null; then
    echo "No queue workers are running."
    exit 0
fi

echo "Stopping all queue workers..."
pkill -f "queue:work"

# Wait a moment and verify
sleep 2

if pgrep -f "queue:work" > /dev/null; then
    echo "Some workers are still running. Force stopping..."
    pkill -9 -f "queue:work"
fi

echo "All queue workers stopped."


