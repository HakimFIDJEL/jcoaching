<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

// Models
use App\Models\User;
use App\Models\Chatbox;

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
        Schema::defaultStringLength(191);

        // Send all users to the admin views
        View::composer('admin.*', function ($view) {
            // Vérification supplémentaire pour éviter les erreurs
            if (Auth::check() && Auth::user()->isAdmin()) {

                $members_view = User::members()->get();
                $chatboxs = Chatbox::all();
                $unread_messages_view = 0;
                foreach ($chatboxs as $chatbox) {
                    $unread_messages_view += $chatbox->unreadMessages()->count();
                }

                $view->with([
                    'members_view' => $members_view,
                    'unread_messages_view' => $unread_messages_view,
                ]);

            }
        });
    }
}
