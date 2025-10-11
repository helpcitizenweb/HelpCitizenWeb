<?php

namespace App\Notifications;

use App\Models\Report;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ReportStatusNotification extends Notification
{
    use Queueable;

    protected $report;
    protected $message;

    public function __construct(Report $report, $message)
    {
        $this->report = $report;
        $this->message = $message;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'report_id' => $this->report->id,
            'message'   => $this->message,
            'url'       => url("/admin/reports/{$this->report->id}"),
        ];
    }
}