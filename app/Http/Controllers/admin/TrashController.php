<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// Models
use App\Models\User;
use App\Models\Contact;
use App\Models\Faq;
use App\Models\Feedback;
use App\Models\Media;
use App\Models\Plan;
use App\Models\Pricing;
use App\Models\Reduction;
use App\Models\Workout;

// Controllers
use App\Http\Controllers\admin\AdminController;
use App\Http\Controllers\admin\MemberController;
use App\Http\Controllers\admin\ContactController;
use App\Http\Controllers\admin\FaqController;
use App\Http\Controllers\admin\FeedbackController;
use App\Http\Controllers\admin\MediaController;
use App\Http\Controllers\admin\PlanController;
use App\Http\Controllers\admin\PricingController;
use App\Http\Controllers\admin\ReductionController;
use App\Http\Controllers\CalendarController;

class TrashController extends Controller
{
    // Members - DONE
    public function members() {
        $members = User::onlyTrashed()->where('role', 'member')->get();
        return view('admin.trash.members')->with(['members' => $members]);
    }

    public function restoreAllMembers() {
        $members = User::onlyTrashed()->where('role', 'member')->get();
        $memberController = new MemberController();

        foreach($members as $member) {
            $memberController->restore($member->id);
        }

        return redirect()->back()->with('success', 'Tous les membres ont été restaurés avec succès.');
    }

    public function deleteAllMembers() {
        $members = User::onlyTrashed()->where('role', 'member')->get();
        $memberController = new MemberController();

        foreach($members as $member) {
            $memberController->delete($member->id);
        }

        return redirect()->back()->with('success', 'Tous les membres ont été supprimés avec succès.');
    }

    // Admins - DONE
    public function admins() {
        $admins = User::onlyTrashed()->where('role', 'admin')->get();
        return view('admin.trash.admins')->with(['admins' => $admins]);
    }

    public function restoreAllAdmins() {
        $admins = User::onlyTrashed()->where('role', 'admin')->get();
        $adminController = new AdminController();

        foreach($admins as $admin) {
            $adminController->restore($admin->id);
        }

        return redirect()->back()->with('success', 'Tous les administrateurs ont été restaurés avec succès.');
    }

    public function deleteAllAdmins() {
        $admins = User::onlyTrashed()->where('role', 'admin')->get();
        $adminController = new AdminController();

        foreach($admins as $admin) {
            $adminController->delete($admin->id);
        }

        return redirect()->back()->with('success', 'Tous les administrateurs ont été supprimés avec succès.');
    }

    // Contacts - DONE
    public function contacts() {
        $contacts = Contact::onlyTrashed()->get();
        return view('admin.trash.contacts')->with(['contacts' => $contacts]);
    }

    public function restoreAllContacts() {
        $contacts = Contact::onlyTrashed()->get();
        $contactController = new ContactController();

        foreach($contacts as $contact) {
            $contactController->restore($contact->id);
        }

        return redirect()->back()->with('success', 'Tous les contacts ont été restaurés avec succès.');
    }   

    public function deleteAllContacts() {
        $contacts = Contact::onlyTrashed()->get();
        $contactController = new ContactController();

        foreach($contacts as $contact) {
            $contactController->delete($contact->id);
        }

        return redirect()->back()->with('success', 'Tous les contacts ont été supprimés avec succès.');
    }

    // Faqs - DONE
    public function faqs() {
        $faqs = Faq::onlyTrashed()->get();
        return view('admin.trash.faqs')->with(['faqs' => $faqs]);
    }

    public function restoreAllFaqs() {
        $faqs = Faq::onlyTrashed()->get();
        $faqController = new FaqController();

        foreach($faqs as $faq) {
            $faqController->restore($faq->id);
        }

        return redirect()->back()->with('success', 'Toutes les questions fréquentes ont été restaurées avec succès.');
    }

    public function deleteAllFaqs() {
        $faqs = Faq::onlyTrashed()->get();
        $faqController = new FaqController();

        foreach($faqs as $faq) {
            $faqController->delete($faq->id);
        }

        return redirect()->back()->with('success', 'Toutes les questions fréquentes ont été supprimées avec succès.');
    }

    // Feedbacks - DONE
    public function feedbacks() {
        $feedbacks = Feedback::onlyTrashed()->get();
        return view('admin.trash.feedbacks')->with(['feedbacks' => $feedbacks]);
    }

    public function restoreAllFeedbacks() {
        $feedbacks = Feedback::onlyTrashed()->get();
        $feedbackController = new FeedbackController();

        foreach($feedbacks as $feedback) {
            $feedbackController->restore($feedback->id);
        }

        return redirect()->back()->with('success', 'Tous les témoinages ont été restaurés avec succès.');
    }

    public function deleteAllFeedbacks() {
        $feedbacks = Feedback::onlyTrashed()->get();
        $feedbackController = new FeedbackController();

        foreach($feedbacks as $feedback) {
            $feedbackController->delete($feedback->id);
        }

        return redirect()->back()->with('success', 'Tous les témoinages ont été supprimés avec succès.');
    }

    // Medias - DONE
    public function medias() {
        $medias = Media::onlyTrashed()->get();
        return view('admin.trash.medias')->with(['medias' => $medias]);
    }

    public function restoreAllMedias() {
        $medias = Media::onlyTrashed()->get();
        $mediaController = new MediaController();

        foreach($medias as $media) {
            $mediaController->restore($media->id);
        }

        return redirect()->back()->with('success', 'Tous les médias ont été restaurés avec succès.');
    }

    public function deleteAllMedias() {
        $medias = Media::onlyTrashed()->get();
        $mediaController = new MediaController();

        foreach($medias as $media) {
            $mediaController->delete($media->id);
        }

        return redirect()->back()->with('success', 'Tous les médias ont été supprimés avec succès.');
    }

    // Plans - DONE
    public function plans() {
        $plans = Plan::onlyTrashed()->get();
        return view('admin.trash.plans')->with(['plans' => $plans]);
    }

    public function restoreAllPlans() {
        $plans = Plan::onlyTrashed()->get();
        $planController = new PlanController();

        foreach($plans as $plan) {
            $planController->restore($plan->id);
        }

        return redirect()->back()->with('success', 'Tous les plans ont été restaurés avec succès.');
    }

    public function deleteAllPlans() {
        $plans = Plan::onlyTrashed()->get();
        $planController = new PlanController();

        foreach($plans as $plan) {
            $planController->delete($plan->id);
        }

        return redirect()->back()->with('success', 'Tous les plans ont été supprimés avec succès.');
    }

    // Pricings - DONE
    public function pricings() {
        $pricings = Pricing::onlyTrashed()->get();
        return view('admin.trash.pricings')->with(['pricings' => $pricings]);
    }

    public function restoreAllPricings() {
        $pricings = Pricing::onlyTrashed()->get();
        $pricingController = new PricingController();

        foreach($pricings as $pricing) {
            $pricingController->restore($pricing->id);
        }

        return redirect()->back()->with('success', 'Tous les tarifs ont été restaurés avec succès.');
    }

    public function deleteAllPricings() {
        $pricings = Pricing::onlyTrashed()->get();
        $pricingController = new PricingController();

        foreach($pricings as $pricing) {
            $pricingController->delete($pricing->id);
        }

        return redirect()->back()->with('success', 'Tous les tarifs ont été supprimés avec succès.');
    }

    // Reductions - DONE
    public function reductions() {
        $reductions = Reduction::onlyTrashed()->get();
        return view('admin.trash.reductions')->with(['reductions' => $reductions]);
    }

    public function restoreAllReductions() {
        $reductions = Reduction::onlyTrashed()->get();
        $reductionController = new ReductionController();

        foreach($reductions as $reduction) {
            $reductionController->restore($reduction->id);
        }

        return redirect()->back()->with('success', 'Toutes les réductions ont été restaurées avec succès.'); 
    }

    public function deleteAllReductions() {
        $reductions = Reduction::onlyTrashed()->get();
        $reductionController = new ReductionController();

        foreach($reductions as $reduction) {
            $reductionController->delete($reduction->id);
        }

        return redirect()->back()->with('success', 'Toutes les réductions ont été supprimées avec succès.');  
    }

    // Workouts - DONE
    public function workouts() {
        $workouts = Workout::onlyTrashed()->get();
        return view('admin.trash.workouts')->with(['workouts' => $workouts]);
    }

    public function restoreAllWorkouts() {
        $workouts = Workout::onlyTrashed()->get();
        $workoutController = new CalendarController();

        foreach($workouts as $workout) {
            if($workout->user) {
                $workoutController->restoreWorkout($workout->id);
            }
        }

        return redirect()->back()->with('success', 'Tous les entraînements ont été restaurés avec succès.');
    }

    public function deleteAllWorkouts() {
        $workouts = Workout::onlyTrashed()->get();
        $workoutController = new CalendarController();

        foreach($workouts as $workout) {
            $workoutController->deleteWorkout($workout->id);
        }

        return redirect()->back()->with('success', 'Tous les entraînements ont été supprimés avec succès.');
    }
}
