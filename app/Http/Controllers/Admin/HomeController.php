<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Reports\MonthlyRequest;
use App\Http\Requests\Admin\Reports\ReportRequest;
use App\Interfaces\MetricsInterface;
use App\Models\Metric;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class HomeController extends Controller
{
    private MetricsInterface $metrics;

    public function __construct(MetricsInterface $metrics)
    {
        $this->metrics = $metrics;
    }

    /**
     * @throws AuthorizationException
     * @return View
     */
    public function index(): View
    {
        $this->authorize('viewAmy', Metric::class);

        $data = $this->metrics->homeMetrics();

        return view('admin.stats', $data);
    }

    /**
     * @param ReportRequest $request
     * @return RedirectResponse
     */
    public function reports(ReportRequest $request): RedirectResponse
    {
        $this->metrics->reports($request);

        return redirect(route('admin.home'))->with('success', trans('messages.reporting'));
    }

    /**
     * @param MonthlyRequest $request
     * @return RedirectResponse
     */
    public function monthlyReport(MonthlyRequest $request): RedirectResponse
    {
        $this->metrics->monthlyReport($request->get('date'));

        return redirect(route('admin.home'))->with('success', trans('messages.reporting'));
    }

    public function testApi(): View
    {
        return view('admin.test_api.test_api');
    }
}
