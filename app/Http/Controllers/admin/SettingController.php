<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

// Models
use App\Models\Setting;
use App\Models\User;

// Requests
use App\Http\Requests\admin\settings\CompanyRequest;
use App\Http\Requests\admin\settings\SocialsRequest;
use App\Http\Requests\admin\settings\NutritionRequest;
use App\Http\Requests\admin\settings\PricingRequest;
use App\Http\Requests\admin\settings\ColorRequest;

// Mails
use App\Mail\NutritionMail;

// Jobs
use App\Jobs\SendEmailJob;

class SettingController extends Controller
{
    // Index - DONE
    public function index() {
        $setting = Setting::first();

        if(!$setting) {
            $setting = Setting::create();
        }

        return view('admin.settings.index')->with(['setting' => $setting]);
    }

    // Notify the members about the nutrition idea - DONE
    public function notify() {
        $setting = Setting::first();
        if(!$setting) {
            $setting = Setting::create();
        }

        // Every member that currently have a plan with the nutrition option
        $members = User::where('role', 'member')->get()->filter(function($member) {
            return $member->hasCurrentPlan() && $member->currentPlan()->first()->nutrition_option;
        });

        // Notify each member
        foreach($members as $member) {
            $mail = new NutritionMail($member);
            SendEmailJob::dispatch($mail);
        }

        return redirect()->back()->with(['success' => 'Les membres ont été notifiés avec succès.']);
    }

    public function colorsReset() {

        $setting = Setting::first();
        if(!$setting) {
            $setting = Setting::create();
        }

        $setting->update([
            'primary_color' => null,
            'secondary_color' => null,
            'background_color' => null,
            'font_color' => null,
        ]);

        return redirect()->back()->with(['success' => 'Les couleurs ont été réinitialisées avec succès.']);
    }

    // Download the company logo - DONE
    public function downloadLogo() {
        $setting = Setting::first();
        if(!$setting) {
            return redirect()->back()->with(['error' => 'Aucun logo de société trouvé.']);
        }
        return Storage::download($setting->company_logo);
    }

    // Update the company - DONE
    public function updateCompany(CompanyRequest $request) {
        $data = $request->validated();


        $setting = Setting::first();
        if(!$setting) {
            $setting = Setting::create();
        }
    
        if ($request->hasFile('company_logo')) {
            if ($setting->company_logo) {
                Storage::delete($setting->company_logo);
            }
            $path = $request->file('company_logo')->store('public/settings');
            $data['company_logo'] = $path;
        } else {

            if ($setting->company_logo) {
                Storage::delete($setting->company_logo);
            }
            $data['company_logo'] = null;
        }
    
        $setting->update($data);
    
        return redirect()->back()->with(['success' => 'Les informations de la société ont été mises à jour avec succès.']);
    }
    
    // Update the socials - DONE
    public function updateSocials(SocialsRequest $request) {
        $data = $request->validated();

        $setting = Setting::first();
        if(!$setting) {
            $setting = Setting::create();
        }

        $setting->update($data);

        return redirect()->back()->with(['success' => 'Les réseaux sociaux ont été mis à jour avec succès.']);
    }

    // Update the nutrition - DONE
    public function updateNutrition(NutritionRequest $request) {
        $data = $request->validated();

        $setting = Setting::first();
        if(!$setting) {
            $setting = Setting::create();
        }

        $setting->update($data);

        return redirect()->back()->with(['success' => 'L\'idée de nutrition a été mise à jour avec succès.']);
    }

    // Update the pricings - DONE
    public function updatePricings(PricingRequest $request) {
        $data = $request->all();

        $setting = Setting::first();
        if(!$setting) {
            $setting = Setting::create();
        }

        $setting->update($data);

        return redirect()->back()->with(['success' => 'Les prix ont été mis à jour avec succès.']);
    }

    public function updateColors(ColorRequest $request) {
        $data = $request->validated();

        $setting = Setting::first();
        if(!$setting) {
            $setting = Setting::create();
        }

        $setting->update($data);

        return redirect()->back()->with(['success' => 'Les couleurs ont été mises à jour avec succès.']);
    }
}
