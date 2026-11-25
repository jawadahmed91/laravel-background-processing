# Laravel Background Processing


Laravel 13 examples for queued jobs, unique work, retries, backoff, timeouts, batching, and safe failure handling.


`GenerateReport` is a unique queued job with explicit retry behavior. `ReportBatch` dispatches many report jobs with completion and failure callbacks.


```bash
composer install
composer test
php artisan queue:work --queue=reports --tries=3
```


Use Redis or a database queue in production, run workers under a process supervisor, and keep jobs idempotent.

## Add this to an existing Laravel project

1. Choose and configure a queue connection in `.env`, such as `QUEUE_CONNECTION=database` or `QUEUE_CONNECTION=redis`.
2. For the database driver, run `php artisan make:queue-table` followed by `php artisan migrate`. Configure Redis before using the Redis driver.
3. Copy `src/GenerateReport.php` to `app/Jobs/GenerateReport.php` and change its namespace to `App\Jobs`.
4. Copy `src/ReportGenerator.php` to `app/Contracts/ReportGenerator.php`, change its namespace, and create an application service that implements the interface.
5. Bind the interface to your implementation in a service provider so Laravel can inject it into the job's `handle()` method.
6. Dispatch one job with `GenerateReport::dispatch($reportId)`. Copy and adapt `ReportBatch` when several reports should be tracked as one batch.
7. Run `php artisan queue:batches-table` and migrate before using job batches.
8. Start a worker with `php artisan queue:work --queue=reports --tries=3`. Run workers under Supervisor, systemd, Horizon, or your hosting platform's worker manager in production.
9. Make report generation idempotent because a queued job can be retried. Store completion state and avoid generating the same external side effect twice.
10. Copy `tests/GenerateReportTest.php` into your project, update its namespace and imports, and run `php artisan test`.
11. Test one successful job, a retryable failure, a permanent failure, and duplicate dispatches for the same report ID.
