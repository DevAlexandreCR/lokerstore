<?php

namespace App\Jobs;

use App\Models\Admin\Admin;
use App\Notifications\ImportEnds;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class NotifyAdminsAfterCompleteImport implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    private Admin $admin;

    public bool $deleteWhenMissingModels = true;

    /**
     * Create a new job instance.
     *
     * @param Admin $admin
     */
    public function __construct(Admin $admin)
    {
        $this->admin = $admin;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(): void
    {
        $this->admin->notify(new ImportEnds());
    }
}
