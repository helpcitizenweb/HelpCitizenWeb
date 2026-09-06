<?php

namespace App\Notifications;

use App\Models\Report;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use NotificationChannels\WebPush\WebPushChannel;
use NotificationChannels\WebPush\WebPushMessage;

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
        return [
            'database',
            WebPushChannel::class,
        ];
    }

    public function toDatabase($notifiable)
    {
        return [
            'report_id' => $this->report->id,
            'message'   => $this->message,
            'url'       => route(
                'admin.reports.viewreport',
                $this->report->id
            ),
        ];
    }

    public function toWebPush($notifiable, $notification)
    {
        return (new WebPushMessage)
            ->title('HelpCitizen Report')
            ->body($this->message)
            ->icon('/favicon.ico')
            ->data([
                'url' => route(
                    'admin.reports.viewreport',
                    $this->report->id
                ),
            ]);
    }
}