<?php

namespace App\Notifications;

use App\Models\Alert;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class WeatherNotification extends Notification
{
    use Queueable;

    protected string $countryName;
    protected string $cityName;
    protected string $precipitation;
    protected string $uvi;

    /**
     * Create a new notification instance.
     */
    public function __construct($countryName, $cityName, $precipitationLevel, $uviLevel)
    {
        $this->countryName = $countryName;
        $this->cityName = $cityName;
        $this->precipitation = Alert::$precipitationLevelMessages[$precipitationLevel];
        $this->uvi = Alert::$uviLevelMessages[$uviLevel];
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->greeting("Hi, $notifiable->name")
            ->line("$this->countryName, $this->cityName: $this->precipitation $this->uvi")
            ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
