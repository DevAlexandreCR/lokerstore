<?php

namespace App\Http\Controllers\Admin;

use App\Models\Metric;
use App\Interfaces\MetricsInterface;
use Illuminate\Http\RedirectResponse;
use App\Http\Controllers\Controller;
use Illuminate\View\View;
use App\Http\Requests\Admin\Reports\ReportRequest;
use Illuminate\Auth\Access\AuthorizationException;

class HomeController extends Controller
{
    private MetricsInterface $metrics;

    public function __construct(MetricsInterface $metrics)
    {
        $this->metrics = $metrics;
    }

    /**
     * @return View
     * @throws AuthorizationException
     */
    public function index(): View
    {
        $this->authorize('viewAmy', Metric::class);

        $data = $this->metrics->homeMetrics();
        return view('admin.stats', $data);
    }

    public function reports(ReportRequest $request): RedirectResponse
    {
        $this->metrics->reports($request);

        return redirect(route('admin.home'))->with('success', __('We\'ll send the report to your email when it\'s ready.'));
    }
}
