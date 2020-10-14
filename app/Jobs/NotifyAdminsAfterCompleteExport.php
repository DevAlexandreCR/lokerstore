<?php

namespace App\Jobs;

use App\Models\Admin\Admin;
use Illuminate\Bus\Queueable;
use App\Notifications\ExportEndsOk;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class NotifyAdminsAfterCompleteExport implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var Admin
     */
    private Admin $admin;
    private string $fileName;

    /**
     * Create a new job instance.
     *
     * @param Admin $admin
     * @param string $fileName
     */
    public function __construct(Admin $admin, string $fileName)
    {
        $this->admin = $admin;
        $this->fileName = $fileName;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(): void
    {
        $this->admin->notify(new ExportEndsOk($this->fileName));
    }
}
