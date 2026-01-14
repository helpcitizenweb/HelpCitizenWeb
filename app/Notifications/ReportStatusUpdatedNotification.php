<?php

namespace App\Notifications;

use App\Models\Report;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ReportStatusUpdatedNotification extends Notification
{
    use Queueable;

    protected $report;
    protected $newStatus;

    public function __construct(Report $report, string $newStatus)
    {
        $this->report = $report;
        $this->newStatus = $newStatus;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'report_id' => $this->report->id,
            'message'   => "Your report (ID #{$this->report->id}) status has been updated to {$this->newStatus}.",
            'url'       => route('reports.full', $this->report->id),
        ];
    }
}
