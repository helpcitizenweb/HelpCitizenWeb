<?php

namespace App\Notifications;

use App\Models\Report;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use NotificationChannels\WebPush\WebPushChannel;
use NotificationChannels\WebPush\WebPushMessage;

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
        return [
            'database',
            WebPushChannel::class,
        ];
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

    public function toWebPush($notifiable, $notification)
    {
        return (new WebPushMessage)
            ->title('Case Resolved')
            ->body("Report ID #{$this->report->id} has been confirmed resolved by the resident ({$this->residentEmail}).")
            ->icon('/favicon.ico')
            ->data([
                'url' => route('admin.reports.viewreport', $this->report->id),
            ]);
    }
}