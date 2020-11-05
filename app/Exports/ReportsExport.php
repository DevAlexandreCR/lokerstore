<?php

namespace App\Exports;

use App\Models\Metric;
use Illuminate\View\View;
use App\Repositories\Metrics;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use App\Interfaces\UsersInterface;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use App\Http\Requests\Admin\Reports\ReportRequest;

class ReportsExport implements FromView, ShouldAutoSize
{
    use Exportable;

    private array $metrics;
    private ReportRequest $request;

    public function __construct(array $metrics)
    {
        $this->metrics = $metrics;
    }

    public function view(): View
    {
        return view('admin.exports.reports', [
            'categories' => $this->reorderCategories(),
            'monthly' => $this->reorderMonthly()
        ]);
    }

    /**
     * Reorder list of categories to report
     * @return Collection
     */
    public function reorderCategories(): Collection
    {
        $categories = new Collection();
        $collection = collect($this->metrics);
        foreach ($collection->get('categories') as $category) {
            $date = explode('-', $category->date);
            $month = $date[0] . '-' . $date[1];
            if ($categories->has($month)) {
                if ($categories->get($month)->amount < $category->amount) {
                    $categories->put($month, $category);
                }
            } else {
                $categories->put($month, $category);
            }
        }
        return $categories;
    }

    /**
     * Reorder list of orders to report
     * @return Collection
     */
    public function reorderMonthly(): Collection
    {
        $orders = new Collection();
        $collection = collect($this->metrics);

        foreach ($collection->get('monthly') as $order) {

            $date = explode('-', $order->date);
            $month = $date[0] . '-' . $date[1];
            if ($orders->has($month)) {
                $o = $orders->get($month);
                $o->genderF = $order->gender;
                $o->totalF = $order->amount;
                $orders->put($month, $o);
            } else {
                $orders->put($month, $order);
            }
        }
        return $orders;
    }
}
