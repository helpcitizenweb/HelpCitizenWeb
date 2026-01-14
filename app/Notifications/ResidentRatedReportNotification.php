<?php

namespace App\Notifications;

use App\Models\Report;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ResidentRatedReportNotification extends Notification
{
    use Queueable;

    protected $report;
    protected $residentName;

    public function __construct(Report $report, string $residentName)
    {
        $this->report = $report;
        $this->residentName = $residentName;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'report_id' => $this->report->id,
            'message'   => "Resident {$this->residentName} has submitted a rating for Report ID #{$this->report->id}.",
            //'url' => route('admin.reports.feedback', $this->report->id),
            'url' => route('admin.reports.viewreport', $this->report->id) . '?tab=feedback',


        ];
    }
}
