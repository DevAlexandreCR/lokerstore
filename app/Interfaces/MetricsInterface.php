<?php

namespace App\Interfaces;

use App\Http\Requests\Admin\Reports\ReportRequest;

interface MetricsInterface
{
    /**
     * @return array
     */
    public function homeMetrics(): array;

    /**
     * @param ReportRequest $request
     * @return mixed
     */
    public function reports(ReportRequest $request);

    /**
     * @param string $date
     * @param string $status
     * @return mixed
     */
    public function monthlyReport(string $date, string $status = '');
}
