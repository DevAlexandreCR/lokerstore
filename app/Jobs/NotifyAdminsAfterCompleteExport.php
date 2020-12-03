<?php

namespace App\Jobs;

use App\Models\Admin\Admin;
use App\Notifications\ExportEndsOk;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class NotifyAdminsAfterCompleteExport implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /**
     * @var Admin
     */
    private Admin $admin;

    private string $fileName;

    private string $export;

    private string $message;

    public bool $deleteWhenMissingModels = true;

    /**
     * Create a new job instance.
     *
     * @param Admin $admin
     * @param string $fileName
     * @param string $export
     * @param string $message
     */
    public function __construct(Admin $admin, string $fileName, string $export, string $message)
    {
        $this->admin = $admin;
        $this->fileName = $fileName;
        $this->export = $export;
        $this->message = $message;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(): void
    {
        $this->admin->notify(new ExportEndsOk($this->fileName, $this->export, $this->message));
    }
}
