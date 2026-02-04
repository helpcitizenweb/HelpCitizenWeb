<?php

namespace App\Notifications;

use App\Models\Report;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ResolvedNotification extends Notification
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
            'title'     => 'Case Resolved',
            'message'   => "Report ID #{$this->report->id} has been confirmed resolved by the resident ({$this->residentEmail}).",
            'url'       => route('admin.reports.viewreport', $this->report->id),
            'report_id' => $this->report->id,
        ];
    }
}
