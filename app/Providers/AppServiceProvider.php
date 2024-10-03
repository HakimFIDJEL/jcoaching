<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

// Models
use App\Models\User;
use App\Models\Chatbox;
use App\Models\Contact;
use App\Models\Faq;
use App\Models\Feedback;
use App\Models\Media;
use App\Models\Plan;
use App\Models\Pricing;
use App\Models\Reduction;
use App\Models\Workout;
use App\Models\Setting;

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

        View::composer('*', function ($view) {
            
            $company_logo = Setting::first()->company_logo;
            $company_icon = Setting::first()->company_icon;
            $company_name = Setting::first()->company_name;
            $company_address = Setting::first()->company_address;
            $company_phone = Setting::first()->company_phone;
            $company_email = Setting::first()->company_email;
            $company_siret = Setting::first()->company_siret;
            $company_tva = Setting::first()->company_tva;

            $meta_title = Setting::first()->meta_title;
            $meta_description = Setting::first()->meta_description;


            $company_facebook = Setting::first()->company_facebook;
            $company_instagram = Setting::first()->company_instagram;
            $company_twitter = Setting::first()->company_twitter;
            $company_linkedin = Setting::first()->company_linkedin;
            $company_youtube = Setting::first()->company_youtube;

            $primary_color = Setting::first()->primary_color;
            $secondary_color = Setting::first()->secondary_color;
            $background_color = Setting::first()->background_color;
            $font_color = Setting::first()->font_color;

            $view->with([
                'company_logo' => $company_logo,
                'company_icon' => $company_icon,
                'company_name' => $company_name,
                'company_address' => $company_address,
                'company_phone' => $company_phone,
                'company_email' => $company_email,
                'company_siret' => $company_siret,
                'company_tva' => $company_tva,

                'meta_title' => $meta_title,
                'meta_description' => $meta_description,

                'company_facebook' => $company_facebook,
                'company_instagram' => $company_instagram,
                'company_twitter' => $company_twitter,
                'company_linkedin' => $company_linkedin,
                'company_youtube' => $company_youtube,

                'primary_color' => $primary_color,
                'secondary_color' => $secondary_color,
                'background_color' => $background_color,
                'font_color' => $font_color,
            ]);
        });

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


                $trash_members = User::onlyTrashed()->where('role', 'member')->count();
                $trash_admins = User::onlyTrashed()->where('role', 'admin')->count();
                $trash_contacts = Contact::onlyTrashed()->count();
                $trash_faqs = Faq::onlyTrashed()->count();
                $trash_feedbacks = Feedback::onlyTrashed()->count();
                $trash_medias = Media::onlyTrashed()->count();
                $trash_plans = Plan::onlyTrashed()->count();
                $trash_pricings = Pricing::onlyTrashed()->count();
                $trash_reductions = Reduction::onlyTrashed()->count();
                $trash_workouts = Workout::onlyTrashed()->count();


                $view->with([
                    'members_view' => $members_view,
                    'unread_messages_view' => $unread_messages_view,

                    'trash_members' => $trash_members,
                    'trash_admins' => $trash_admins,
                    'trash_contacts' => $trash_contacts,
                    'trash_faqs' => $trash_faqs,
                    'trash_feedbacks' => $trash_feedbacks,
                    'trash_medias' => $trash_medias,
                    'trash_plans' => $trash_plans,
                    'trash_pricings' => $trash_pricings,
                    'trash_reductions' => $trash_reductions,
                    'trash_workouts' => $trash_workouts,
                ]);

            }
        });
    }
}
