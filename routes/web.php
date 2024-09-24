<?php

use Illuminate\Support\Facades\Route;

// Middlewares
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\MemberMiddleware;
use App\Http\Middleware\AuthMiddleware;


// Controllers
use App\Http\Controllers\MainController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\ChatboxController;

//      Admin Controllers
use App\Http\Controllers\admin\MainController as AdminMainController;
use App\Http\Controllers\admin\MemberController as AdminMemberController;
use App\Http\Controllers\admin\AdminController as AdminAdminController;
use App\Http\Controllers\admin\FeedbackController as AdminFeedbackController;
use App\Http\Controllers\admin\ContactController as AdminContactController;
use App\Http\Controllers\admin\MediaController as AdminMediaController;
use App\Http\Controllers\admin\FaqController as AdminFaqController;
use App\Http\Controllers\admin\PricingController as AdminPricingController;
use App\Http\Controllers\admin\PlanController as AdminPlanController;
use App\Http\Controllers\admin\ReductionController as AdminReductionController;
use App\Http\Controllers\admin\SettingController as AdminSettingController;
use App\Http\Controllers\admin\TrashController as AdminTrashController;
use App\Http\Controllers\admin\OrderController as AdminOrderController;


//      Member Controllers
use App\Http\Controllers\member\MainController as MemberMainController;
use App\Http\Controllers\member\PlanController as MemberPlanController;
use App\Http\Controllers\member\AccountController as MemberAccountController;
use App\Http\Controllers\member\PaymentController as MemberPaymentController;


// MAIN ROUTES
Route::get('/', [MainController::class, 'index'])->name('main.index');
Route::get('/account', [MainController::class, 'account'])->name('main.account');

// AUTH ROUTES
Route::prefix('/auth')->name('auth.')->controller(AuthController::class)->group(function()
{
    // Authentification
    Route::get('/login', 'login')->name('login');
    Route::get('/register', 'register')->name('register');
    Route::get('/logout', 'logout')->name('logout');
    Route::get('/email-verification/{user_token}', 'emailVerification')->name('email-verification');
    Route::get('/email-verification/{user_token}/sresend', 'emailVerificationResend')->name('email-verification.resend');

    Route::post('/login', 'loginPost')->name('toLogin');
    Route::post('/register', 'registerPost')->name('toRegister');
    Route::post('/email-verification', 'emailVerificationPost')->name('toVerifyEmail');

    // Passwords
    Route::prefix('/password')->name('password.')->group(function()
    {
        Route::get('/forget', 'forget')->name('forget');
        Route::get('/reset/{password_token?}', 'reset')->name('reset');
        Route::get('/change', 'change')->name('change');

        Route::post('/forget', 'forgetPost')->name('toForget');
        Route::post('/reset', 'resetPost')->name('toReset');
        Route::post('/change', 'changePost')->name('toChange');
    });
});

// ADMIN ROUTES
Route::prefix("/admin")->middleware([AdminMiddleware::class])->name("admin.")->group(function(){

    // MAIN - DONE
    Route::get('/', [AdminMainController::class, 'index'])->name('index');

    // MEMBERS - DONE
    Route::prefix("/members")->name("members.")->controller(AdminMemberController::class)->group(function(){

        // INFORMATIONS
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::get('/edit/{user}', 'edit')->name('edit');
        Route::post('/store', 'store')->name('store');
        Route::post('/update/{user}', 'update')->name('update');
        
        // PLANS
        Route::prefix('/plans/{user}')->name('plans.')->group(function()
        {
                Route::get('/', 'plans')->name('index');
                Route::get('/unexpire/{plan}', 'unexpirePlan')->name('unexpire');
                Route::get('/delete/{plan}', 'deletePlan')->name('delete');
                Route::get('/soft-delete/{plan}', 'softDeletePlan')->name('soft-delete');
                Route::get('/expire', 'expirePlan')->name('expire');
                Route::post('/add', 'addPlan')->name('add');
                Route::post('/update', 'updatePlan')->name('update');
        });

       
        
        // DOCUMENTS
        Route::get('/documents/{user}', 'documents')->name('documents');
        Route::get('/download-documents/{user}', 'downloadDocuments')->name('download-documents');
        Route::post('/update-documents/{user}', 'updateDocuments')->name('update-documents');
        
        // PFP
        Route::get('/pfp/{user}', 'pfp')->name('pfp');
        Route::post('/update-pfp/{user}', 'updatePfp')->name('update-pfp');
        Route::get('/download-pfp/{user}', 'downloadPfp')->name('download-pfp');
        
        // CALENDAR
        Route::get('/calendar/{user}', 'calendar')->name('calendar');
        Route::get('/calendar/notify/{user}', 'calendarNotify')->name('calendar.notify');

        // DELETE
        Route::get('/soft-delete/{user}', 'softDelete')->name('soft-delete');
        Route::get('/restore/{id}', 'restore')->name('restore');
        Route::get('/delete/{id}', 'delete')->name('delete');
    });

    // CALENDAR - DONE 
    Route::prefix("/calendar")->name("calendar.")->controller(CalendarController::class)->group(function(){

        Route::get('/', 'index')->name('index');
        Route::get('/notify', 'notify')->name('notify');
        
        Route::post('/notify', 'toNotify')->name('notify-post');
    

        // WORKOUTS
        Route::prefix('/workouts')->name('workouts.')->group(function()
        {
            Route::get('/soft-delete/{user}/{workout}', 'softDeleteWorkout')->name('soft-delete');
            Route::get('/restore/{id}', 'restoreWorkout')->name('restore');
            Route::get('/delete/{id}', 'deleteWorkout')->name('delete');

            Route::get('/done/{user}/{workout}', 'doneWorkout')->name('done');
            Route::get('/undone/{user}/{workout}', 'undoneWorkout')->name('undone');

            Route::post('/store', 'storeWorkout')->name('store');
            Route::post('/update', 'updateWorkout')->name('update');
        });

        // REST PERIODS
        Route::prefix('/rest-periods')->name('rest-periods.')->group(function()
        {
            Route::post('/add', 'addRestPeriod')->name('add');
            Route::post('/update', 'updateRestPeriod')->name('update');
            Route::post('/delete', 'deleteRestPeriod')->name('delete');
        });

    });

    // ADMINS - DONE
    Route::prefix("/admins")->name("admins.")->controller(AdminAdminController::class)->group(function(){

        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::get('/edit', 'edit')->name('edit');
        Route::get('/pfp', 'pfp')->name('pfp');
        Route::get('/security', 'security')->name('security');
        Route::get('/soft-delete/{user}', 'softDelete')->name('soft-delete');
        Route::get('/restore/{id}', 'restore')->name('restore');
        Route::get('/delete/{id}', 'delete')->name('delete');
        Route::get('/download-pfp', 'downloadPfp')->name('download-pfp');

        Route::post('/store', 'store')->name('store');
        Route::post('/update', 'update')->name('update');
        Route::post('/update-password', 'updatePassword')->name('updatePassword');
        Route::post('/update-pfp', 'updatePfp')->name('update-pfp');
    });

    // FEEDBACKS - DONE
    Route::prefix("/feedbacks")->name("feedbacks.")->controller(AdminFeedbackController::class)->group(function(){

        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::get('/edit/{feedback}', 'edit')->name('edit');
        Route::get('/soft-delete/{feedback}', 'softDelete')->name('soft-delete');
        Route::get('/restore/{id}', 'restore')->name('restore');
        Route::get('/delete/{id}', 'delete')->name('delete');

        Route::post('/store', 'store')->name('store');
        Route::post('/update/{feedback}', 'update')->name('update');
    });

    // CONTACTS - DONE
    Route::prefix("/contacts")->name("contacts.")->controller(AdminContactController::class)->group(function(){

        Route::get('/', 'index')->name('index');
        Route::get('/show/{contact}', 'show')->name('show');
        Route::get('/soft-delete/{contact}', 'softDelete')->name('soft-delete');
        Route::get('/restore/{id}', 'restore')->name('restore');
        Route::get('/delete/{id}', 'delete')->name('delete');
        
    });

    // MEDIAS - DONE
    Route::prefix("/medias")->name("medias.")->controller(AdminMediaController::class)->group(function(){

        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::get('/edit/{media}', 'edit')->name('edit');
        Route::get('/soft-delete/{media}', 'softDelete')->name('soft-delete');
        Route::get('/delete/{id}', 'delete')->name('delete');
        Route::get('/restore/{id}', 'restore')->name('restore');
        Route::get('/download/{media}', 'download')->name('download');

        Route::post('/store', 'store')->name('store');
        Route::post('/update/{media}', 'update')->name('update');
    });

    // FAQS - DONE
    Route::prefix("/faqs")->name("faqs.")->controller(AdminFaqController::class)->group(function(){

        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::get('/edit/{faq}', 'edit')->name('edit');
        Route::get('/soft-delete/{faq}', 'softDelete')->name('soft-delete');
        Route::get('/restore/{id}', 'restore')->name('restore');
        Route::get('/delete/{id}', 'delete')->name('delete');

        Route::post('/store', 'store')->name('store');
        Route::post('/update/{faq}', 'update')->name('update');
    });

    // PRICINGS - DONE
    Route::prefix("/pricings")->name("pricings.")->controller(AdminPricingController::class)->group(function(){

        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::get('/edit/{pricing}', 'edit')->name('edit');
        Route::get('/soft-delete/{pricing}', 'softDelete')->name('soft-delete');
        Route::get('/restore/{id}', 'restore')->name('restore');
        Route::get('/delete/{id}', 'delete')->name('delete');

        Route::post('/store', 'store')->name('store');
        Route::post('/update/{pricing}', 'update')->name('update');
    });


    // PLANS - DONE
    Route::prefix("/plans")->name("plans.")->controller(AdminPlanController::class)->group(function(){
        Route::get('/', 'index')->name('index');
        Route::get('/soft-delete/{plan}', 'softDelete')->name('soft-delete');
        Route::get('/restore/{id}', 'restore')->name('restore');
        Route::get('/delete/{id}', 'delete')->name('delete');
    });


    // REDUCTIONS - DONE
    Route::prefix("/reductions")->name("reductions.")->controller(AdminReductionController::class)->group(function(){

        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::get('/edit/{reduction}', 'edit')->name('edit');
        Route::get('/members/{reduction}', 'members')->name('members');
        Route::get('/link/{user}/{reduction}', 'link')->name('link');
        Route::get('/unlink/{user}/{reduction}', 'unlink')->name('unlink');
        Route::get('/soft-delete/{reduction}', 'softDelete')->name('soft-delete');
        Route::get('/restore/{id}', 'restore')->name('restore');
        Route::get('/delete/{id}', 'delete')->name('delete');

        Route::post('/store', 'store')->name('store');
        Route::post('/update/{reduction}', 'update')->name('update');
    });


    // SETTINGS - DONE
    Route::prefix("/settings")->name("settings.")->controller(AdminSettingController::class)->group(function(){

        Route::get('/', 'index')->name('index');
        Route::get('/notify', 'notify')->name('notify');
        Route::get('/download-logo', 'downloadLogo')->name('download-logo');

        Route::post('/update-company', 'updateCompany')->name('update-company');
        Route::post('/update-socials', 'updateSocials')->name('update-socials');
        Route::post('/update-nutrition', 'updateNutrition')->name('update-nutrition');
        Route::post('/update-pricings', 'updatePricings')->name('update-pricings');
    });

    // CHATBOX - DONE
    Route::prefix("/chatbox")->name("chatbox.")->controller(ChatboxController::class)->group(function(){

        Route::get('/', 'index')->name('index');
        Route::get('/mark-as-read', 'markAsRead')->name('mark-as-read');
        Route::get('/show/{user}', 'show')->name('show');
        Route::get('/block/{user}', 'block')->name('block');
        Route::get('/unblock/{user}', 'unblock')->name('unblock');   
        Route::get('/delete-messages/{user}', 'deleteMessages')->name('delete-messages');

        Route::post('/send/{user}', 'send')->name('send');
    });

    // CORBEILLE - DONE
    Route::prefix("/trash")->name("trash.")->controller(AdminTrashController::class)->group(function(){

        Route::prefix("/feedbacks")->name("feedbacks.")->group(function(){
            Route::get('/', 'feedbacks')->name('index');
            Route::get('/restore-all', 'restoreAllFeedbacks')->name('restore-all');
            Route::get('/delete-all', 'deleteAllFeedbacks')->name('delete-all');
        });

        Route::prefix("/members")->name("members.")->group(function(){
            Route::get('/', 'members')->name('index');
            Route::get('/restore-all', 'restoreAllMembers')->name('restore-all');
            Route::get('/delete-all', 'deleteAllMembers')->name('delete-all');
        });

        Route::prefix('/admins')->name('admins.')->group(function(){
            Route::get('/', 'admins')->name('index');
            Route::get('/restore-all', 'restoreAllAdmins')->name('restore-all');
            Route::get('/delete-all', 'deleteAllAdmins')->name('delete-all');
        });

        Route::prefix("/workouts")->name("workouts.")->group(function(){
            Route::get('/', 'workouts')->name('index');
            Route::get('/restore-all', 'restoreAllWorkouts')->name('restore-all');
            Route::get('/delete-all', 'deleteAllWorkouts')->name('delete-all');
        });

        Route::prefix("/contacts")->name("contacts.")->group(function(){
            Route::get('/', 'contacts')->name('index');
            Route::get('/restore-all', 'restoreAllContacts')->name('restore-all');
            Route::get('/delete-all', 'deleteAllContacts')->name('delete-all');
        });

        Route::prefix("/faqs")->name("faqs.")->group(function(){
            Route::get('/', 'faqs')->name('index');
            Route::get('/restore-all', 'restoreAllFaqs')->name('restore-all');
            Route::get('/delete-all', 'deleteAllFaqs')->name('delete-all');
        });

        Route::prefix("/medias")->name("medias.")->group(function(){
            Route::get('/', 'medias')->name('index');
            Route::get('/restore-all', 'restoreAllMedias')->name('restore-all');
            Route::get('/delete-all', 'deleteAllMedias')->name('delete-all');
        });

        Route::prefix("/plans")->name("plans.")->group(function(){
            Route::get('/', 'plans')->name('index');
            Route::get('/restore-all', 'restoreAllPlans')->name('restore-all');
            Route::get('/delete-all', 'deleteAllPlans')->name('delete-all');
        });

        Route::prefix("/pricings")->name("pricings.")->group(function(){
            Route::get('/', 'pricings')->name('index');
            Route::get('/restore-all', 'restoreAllPricings')->name('restore-all');
            Route::get('/delete-all', 'deleteAllPricings')->name('delete-all');
        });

        Route::prefix("/reductions")->name("reductions.")->group(function(){
            Route::get('/', 'reductions')->name('index');
            Route::get('/restore-all', 'restoreAllReductions')->name('restore-all');
            Route::get('/delete-all', 'deleteAllReductions')->name('delete-all');
        });


    });

    // ORDERS - DONE
    Route::prefix("/orders")->name("orders.")->controller(AdminOrderController::class)->group(function(){
        Route::get('/', 'index')->name('index');
        Route::get('/delete/{order}', 'delete')->name('delete');
    });

});


// MEMBER ROUTES
Route::prefix("/member")->middleware([MemberMiddleware::class])->name("member.")->group(function(){

    // MAIN
    Route::get('/', [MemberMainController::class, 'index'])->name('index');

    // PLANS - DOING
    Route::prefix("/plans")->name("plans.")->controller(MemberPlanController::class)->group(function(){
        Route::get('/', 'index')->name('index');
    });

    // CALENDAR ROUTES - DONE
    Route::prefix("/calendar")->name("calendar.")->controller(CalendarController::class)->group(function(){
    
        Route::get('/', 'index')->name('index');
        Route::get('/notify', 'notify')->name('notify');

        Route::post('/notify', 'toNotify')->name('notify-post');

        // WORKOUTS
        Route::prefix('/workouts')->name('workouts.')->group(function()
        {
            Route::get('/add', 'addWorkout')->name('add');

            Route::post('/update', 'updateWorkout')->name('update');
        });
    });

    // CHATBOX - DONE
    Route::prefix("/chatbox")->name("chatbox.")->controller(ChatboxController::class)->group(function(){

        Route::get('/', 'index')->name('index');
        Route::get('/show/{user}', 'show')->name('show'); 
        Route::post('/send/{user}', 'send')->name('send');
    });

    // ACCOUNT - DONE
    Route::prefix("/account")->name("account.")->controller(MemberAccountController::class)->group(function(){

        Route::get('/', 'index')->name('index');
        Route::get('/pfp', 'pfp')->name('pfp'); 
        Route::get('/security', 'security')->name('security'); 
        Route::get('/documents', 'documents')->name('documents');

        Route::post('/update', 'update')->name('update');
        Route::post('/update-password', 'updatePassword')->name('update-password');
        Route::post('/update-pfp', 'updatePfp')->name('update-pfp');

        Route::get('/download-pfp', 'downloadPfp')->name('download-pfp');
        Route::get('/download-documents', 'downloadDocuments')->name('download-documents');
    });

    // PAYMENT - DOING
    Route::prefix("/payment")->name("payment.")->controller(MemberPaymentController::class)->group(function(){

        Route::get('/plan', 'plan_index')->name('plan.index');
        Route::get('/workout', 'workout_index')->name('workout.index');

        Route::get('/success', 'success')->name('success');
        Route::get('/cancel', 'cancel')->name('cancel');

        Route::post('/reduction', 'get_reduction')->name('reduction');
        Route::post('/plan', 'plan_payment')->name('plan.payment');
        Route::post('/workout', 'workout_payment')->name('workout.payment');

    });
});


