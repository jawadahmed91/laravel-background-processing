<?php

namespace JawadAhmed\BackgroundProcessing;

interface ReportGenerator
{
    public function generate(int $reportId): void;
}
