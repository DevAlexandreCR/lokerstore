<?php

namespace App\Console\Commands;

use App\Constants\Roles;
use App\Models\Admin\Admin;
use App\Repositories\Metrics;
use Illuminate\Console\Command;
use Spatie\Permission\Models\Role;
use App\Interfaces\MetricsInterface;
use App\Exports\MonthlyReportsExport;
use Illuminate\Database\Eloquent\Builder;
use App\Jobs\NotifyAdminsAfterCompleteExport;

class GenerateMonthlyReport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = "report:monthly
                                {date=last : Year and month to report}
                                {admin=admin : Admin to send report}";

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate report monthly, arg \'date\' is year and month to report, if it\'s null,
     \'date\' is last month';

    private string $date;
    private $admin = null;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->date = now()->format('Y-m');
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @param Metrics $metrics
     * @return int
     */
    public function handle(Metrics $metrics): int
    {
        if($this->argument('date') !== 'last'){
            $this->date = (string)$this->argument('date');
        }

        if ($this->argument('admin') === 'admin'){
            Admin::all()->each(function ($admin){
                if ($admin->hasRole(Roles::ADMIN)){
                    $this->admin = $admin;
                }
            });
        } else {
            $this->admin = Admin::find($this->argument('admin'));
        }


        if (!$this->admin){
            logger()->info(trans('No admin to send report, abort export'));
            return 0;
        }

        $fileName = 'report_monthly_' . now()->getTimestamp() .'.xlsx';
        (new MonthlyReportsExport($metrics->monthlyReport($this->date)))->queue($fileName, 'exports')->chain([
            new NotifyAdminsAfterCompleteExport(
                $this->admin,
                $fileName,
                trans('Reports'),
                trans('Reports generated successfully')
            )
        ]);

        logger()->info(trans('Report monthly sent successfully'));

        return 0;
    }
}
