<?php

namespace App\Providers;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Notifications\Messages\MailMessage;
use Lang;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        ResetPassword::toMailUsing(function ($notifiable, $token) {
            return (new MailMessage)
            ->subject(__('auth.reset_password.reset_password_notification'))
            ->line(__('auth.reset_password.reset_password_msg'))
            ->action(__('auth.reset_password.reset_pwd_btn'), url(config('app.url').route('password.reset', $token, false)))
            ->line(Lang::get(__('auth.reset_password.reset_password_msg3'), ['count' => config('auth.passwords.'.config('auth.defaults.passwords').'.expire')]))
            ->line(__('auth.reset_password.reset_password_msg2'));
        });
    }
}
