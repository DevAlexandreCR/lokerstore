<?php

namespace App\Decorators;

use App\Constants\Admins;
use App\Exports\ReportsExport;
use App\Http\Requests\Admin\Reports\ReportRequest;
use App\Interfaces\MetricsInterface;
use App\Interfaces\UsersInterface;
use App\Jobs\NotifyAdminsAfterCompleteExport;
use App\Repositories\Metrics;
use Illuminate\Support\Facades\Artisan;

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
            'pendingShipment' => $this->metrics->getPendingShipmentOrders(),
            'percentMetrics' => $this->metrics->getPercentMetrics(),
            'usersCount'      => $this->users->index()->count(),
        ];
    }

    /**
     * @param ReportRequest $request
     * @return void
     */
    public function reports(ReportRequest $request): void
    {
        $fileName = 'report_' . now()->getTimestamp() .'.xlsx';
        (new ReportsExport($this->metrics->reports($request)))->queue($fileName, 'exports')->chain([
            new NotifyAdminsAfterCompleteExport(
                $request->user(Admins::GUARDED),
                $fileName,
                trans('Reports'),
                trans('Reports generated successfully')
            ),
        ]);
    }

    /**
     * @param string $date
     * @param string $status
     * @return mixed
     */
    public function monthlyReport(string $date, string $status = '')
    {
        return Artisan::call('report:monthly', [
            'date' => $date . '-01',
            '--status' => $status,
            '--admin' => auth()->id(),
        ]);
    }
}
