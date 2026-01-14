<?php

namespace App\Notifications;

use App\Models\Feedback;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class AdminRepliedToFeedbackNotification extends Notification
{
    use Queueable;

    protected $feedback;

    public function __construct(Feedback $feedback)
    {
        $this->feedback = $feedback;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
    'feedback_id' => $this->feedback->id,
    //'message' => 'An admin has replied to your feedback (Feedback ID #' . $this->feedback->id . ').',
    'message' => 'An admin has replied to your feedback for Report ID #' . $this->feedback->report_id . '.',

    'url' => route('feedback.create', $this->feedback->report_id),
];

    }
}
