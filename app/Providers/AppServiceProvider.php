<?php

namespace App\Providers;

use App\Http\Controllers\CommunityChatController;
use Illuminate\Support\Facades\Auth;
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
        View::composer('partials.navbar', function ($view) {
            if (Auth::check()) {
                $summary = CommunityChatController::getUserChatSummary(Auth::user());
                $view->with('navbarChatSummary', $summary);
            } else {
                $view->with('navbarChatSummary', [
                    'communities' => [],
                    'total_unread_count' => 0,
                    'all_chat_url' => route('community.index'),
                ]);
            }
        });
    }
}
