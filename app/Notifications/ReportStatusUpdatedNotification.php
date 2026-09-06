<?php

namespace App\Notifications;

use App\Models\Report;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use NotificationChannels\WebPush\WebPushChannel;
use NotificationChannels\WebPush\WebPushMessage;

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
        return [
            'database',
            WebPushChannel::class,
        ];
    }

    public function toDatabase($notifiable)
    {
        return [
            'report_id' => $this->report->id,
            'message'   => "Your report (ID #{$this->report->id}) status has been updated to {$this->newStatus}.",
            'url'       => route('reports.full', $this->report->id),
        ];
    }

    public function toWebPush($notifiable, $notification)
    {
        return (new WebPushMessage)
            ->title('HelpCitizen Report Update')
            ->body("Your report (ID #{$this->report->id}) status has been updated to {$this->newStatus}.")
            ->icon('/favicon.ico')
            ->data([
                'url' => route('reports.full', $this->report->id),
            ]);
    }
}