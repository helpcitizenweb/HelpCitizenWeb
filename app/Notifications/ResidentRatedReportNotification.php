<?php

namespace App\Notifications;

use App\Models\Report;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ResidentRatedReportNotification extends Notification
{
    use Queueable;

    protected $report;
    protected $residentEmail;

    public function __construct(Report $report, string $residentEmail)
    {
        $this->report = $report;
        $this->residentEmail = $residentEmail;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'report_id' => $this->report->id,
            'message'   => "Resident ({$this->residentEmail}) has submitted a rating for Report ID #{$this->report->id}.",
            'url'       => route('admin.reports.viewreport', $this->report->id) . '?tab=feedback',
        ];
    }
}
