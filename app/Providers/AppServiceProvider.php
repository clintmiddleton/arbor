<?php

namespace App\Providers;

use App\Events\AttendanceSessionCreated;
use App\Events\AttendanceSessionSubmitted;
use App\Listeners\LogAttendanceSessionCreated;
use App\Listeners\LogAttendanceSessionSubmitted;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;

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
        Gate::define('accessAdmin', function ($user) {
            return $user->is_admin ?? false;
        });

        Gate::define('accessTeacher', function ($user) {
            return $user->is_teacher ?? false;
        });

        Event::listen(AttendanceSessionCreated::class, LogAttendanceSessionCreated::class);
        Event::listen(AttendanceSessionSubmitted::class, LogAttendanceSessionSubmitted::class);

        Vite::prefetch(concurrency: 3);
    }
}
