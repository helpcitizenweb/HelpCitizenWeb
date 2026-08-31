<?php

namespace App\Notifications;

use App\Models\Announcement;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use NotificationChannels\WebPush\WebPushChannel;
use NotificationChannels\WebPush\WebPushMessage;

class AnnouncementNotification extends Notification
{
    use Queueable;

    protected $announcement;
    protected $message;

    public function __construct(Announcement $announcement, $message)
    {
        $this->announcement = $announcement;
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
            'announcement_id' => $this->announcement->id,
            'message'         => $this->message,
            'url'             => route(
                'resident.announcements.show',
                $this->announcement->id
            ),
        ];
    }

    public function toWebPush($notifiable, $notification)
    {
        return (new WebPushMessage)
            ->title('HelpCitizen Announcement')
            ->body($this->message)
            ->icon('/favicon.ico')
            ->data([
                'url' => route(
                    'resident.announcements.show',
                    $this->announcement->id
                ),
            ]);
    }
}