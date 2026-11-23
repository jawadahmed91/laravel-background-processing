<?php

namespace JawadAhmed\BackgroundProcessing;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

final class GenerateReport implements ShouldQueue, ShouldBeUnique
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;
    public int $timeout = 120;
    public int $uniqueFor = 3600;

    public function __construct(public readonly int $reportId)
    {
        $this->onQueue('reports');
    }

    public function uniqueId(): string
    {
        return (string) $this->reportId;
    }

    public function backoff(): array
    {
        return [30, 120, 300];
    }

    public function handle(ReportGenerator $generator): void
    {
        $generator->generate($this->reportId);
    }
}

interface ReportGenerator
{
    public function generate(int $reportId): void;
}
