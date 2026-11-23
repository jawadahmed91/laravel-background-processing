# Laravel Background Processing

Laravel 13 examples for queued jobs, unique work, retries, backoff, timeouts, batching, and safe failure handling.

`GenerateReport` is a unique queued job with explicit retry behavior. `ReportBatch` dispatches many report jobs with completion and failure callbacks.

```bash
composer install
composer test
php artisan queue:work --queue=reports --tries=3
```

Use Redis or a database queue in production, run workers under a process supervisor, and keep jobs idempotent.
