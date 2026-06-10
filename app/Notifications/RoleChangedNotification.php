<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RoleChangedNotification extends Notification
{
    use Queueable;

    protected string $newRole;

    public function __construct(string $newRole)
    {
        $this->newRole = $newRole;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'ROLE_UPDATE',
            'message' => 'CLEARANCE_OVERRIDDEN_TO_' . strtoupper($this->newRole),
            'action_url' => '/dashboard',
        ];
    }
}
