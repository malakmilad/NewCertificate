<?php

namespace App\Providers;

use App\Events\AttachmentEvent;
use App\Events\StoreAttachmentEvent;
use App\Listeners\AttachmentListener;
use App\Listeners\StoreAttachmentListener;
use App\Models\Font;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\View;
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
        Event::listen(
            AttachmentEvent::class,
            AttachmentListener::class,
        );
        Event::listen(
            StoreAttachmentEvent::class,
            StoreAttachmentListener::class,
        );
        if (!app()->runningInConsole()) {
            try {
                $fonts = Font::get();
                View::share('fonts', $fonts);
            } catch (\Exception $e) {
                // Ignore database errors during setup
            }
        }
    }
}
