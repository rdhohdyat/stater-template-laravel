<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Event::listen(function (Login $event) {
            /** @var \App\Models\User $user */
            $user = $event->user;

            activity('auth')
                ->causedBy($user)
                ->event('login')
                ->withProperties([
                    'ip_address' => request()->ip(),
                    'user_agent' => request()->userAgent(),
                ])
                ->log('login');
        });

        Event::listen(function (Logout $event) {
            if ($event->user) {
                /** @var \App\Models\User $user */
                $user = $event->user; // Keep this line
                // Simpan log ke tabel Activity Log
                activity('auth')
                    ->causedBy($user)
                    ->event('logout')
                    ->withProperties([
                        'ip_address' => request()->ip(),
                        'user_agent' => request()->userAgent(),
                    ])
                    ->log('logout');
            }
        });
    }
}
