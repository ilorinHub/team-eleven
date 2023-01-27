<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('is-admin', function($user) {
            return $user->hasAnyRole('admin');
        });

        Gate::define('is-staff', function($user) {
            return $user->hasAnyRole('staff');
        });

        Gate::define('is-user', function($user) {
            return $user->hasAnyRole('user');
        });

        VerifyEmail::toMailUsing(function ($notifiable, $url) {
            return (new MailMessage)
                ->subject($notifiable->first_name . ', one more step...')
                ->greeting('Hi ' . $notifiable->first_name)
                ->line('Just click the button below to verify your email address.')
                ->action('Verify Email Address', $url)
                ->line('If you did not create an account, no further action is required.');
        });
    }
}
