<?php

namespace JawadAhmed\BackgroundProcessing;

use Illuminate\Bus\Batch;
use Illuminate\Support\Facades\Bus;
use Throwable;

final class ReportBatch
{
    /** @param list<int> $reportIds */
    public function dispatch(array $reportIds): Batch
    {
        $jobs = array_map(static fn (int $id): GenerateReport => new GenerateReport($id), $reportIds);

        return Bus::batch($jobs)
            ->name('Generate reports')
            ->allowFailures()
            ->catch(static function (Batch $batch, Throwable $error): void {
                report($error);
            })
            ->onQueue('reports')
            ->dispatch();
    }
}
