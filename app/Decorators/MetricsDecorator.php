<?php

namespace App\Decorators;

use App\Repositories\Metrics;
use App\Exports\ReportsExport;
use App\Interfaces\UsersInterface;
use App\Interfaces\MetricsInterface;
use App\Http\Requests\Admin\Reports\ReportRequest;

class MetricsDecorator implements MetricsInterface
{
    private Metrics $metrics;
    private UsersInterface $users;

    public function __construct(Metrics $metrics, UsersInterface $users)
    {
        $this->metrics = $metrics;
        $this->users = $users;
    }
    /**
     * @return array
     */
    public function homeMetrics(): array
    {
        return [
            'metricsGeneral'  => $this->metrics->getMetricsAllOrders(),
            'metricsSeller'   => $this->metrics->getMetricsAdminOrders(),
            'metricsCategory' => $this->metrics->getMetricsCategory(),
            'pendingShipment' => $this->metrics->getpendingShipmentOrders(),
            'usersCount'      => $this->users->index()->count()
        ];
    }

    /**
     * @param ReportRequest $request
     * @return void
     */
    public function reports(ReportRequest $request): void
    {
        $fileName = 'report_' . now()->getTimestamp() .'.xlsx';
        (new ReportsExport($this->metrics->reports($request)))->queue($fileName, 'exports');//->chain([
//            new NotifyAdminsAfterCompleteExport(
//                $request->user(Admins::GUARDED),
//                $fileName,
//                trans('Reports'),
//                trans('Reports generated successfully')
//            )
//        ]);
    }

    /**
     * @param string $date
     * @return mixed
     */
    public function monthlyReport(string $date)
    {
        return $this->metrics->monthlyReport($date);
    }
}
