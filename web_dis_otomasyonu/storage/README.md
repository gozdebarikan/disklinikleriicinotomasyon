# Dental App - Storage Directory

This directory stores application data:

- `/logs` - Application log files (daily rotation)
- `/cache` - Cached data (future use)
- `/uploads` - User uploaded files (future use)
- `/sessions` - Session files (if file-based sessions)

**Security Note:** This directory should NOT be web-accessible.
All files here are protected by .htaccess rules.
