<?php

namespace Tests;

use JawadAhmed\BackgroundProcessing\GenerateReport;
use JawadAhmed\BackgroundProcessing\ReportGenerator;
use PHPUnit\Framework\TestCase;

final class GenerateReportTest extends TestCase
{
    public function test_job_is_unique_and_delegates_generation(): void
    {
        $generator = $this->createMock(ReportGenerator::class);
        $generator->expects(self::once())->method('generate')->with(42);
        $job = new GenerateReport(42);
        $job->handle($generator);
        self::assertSame('42', $job->uniqueId());
        self::assertSame([30, 120, 300], $job->backoff());
    }
}
