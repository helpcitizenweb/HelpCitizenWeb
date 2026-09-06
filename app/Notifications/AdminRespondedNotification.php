<?php

namespace App\Notifications;

use App\Models\Report;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use NotificationChannels\WebPush\WebPushChannel;
use NotificationChannels\WebPush\WebPushMessage;

class AdminRespondedNotification extends Notification
{
    use Queueable;

    protected $report;

    public function __construct(Report $report)
    {
        $this->report = $report;
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
            'message'   => "An admin has responded to your report (ID #{$this->report->id}).",
            'url'       => route('reports.full', $this->report->id),
        ];
    }

    public function toWebPush($notifiable, $notification)
    {
        return (new WebPushMessage)
            ->title('HelpCitizen Report Update')
            ->body("An admin has responded to your report (ID #{$this->report->id}).")
            ->icon('/favicon.ico')
            ->data([
                'url' => route('reports.full', $this->report->id),
            ]);
    }
}