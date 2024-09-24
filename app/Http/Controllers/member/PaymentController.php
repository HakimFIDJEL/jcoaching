<?php

namespace App\Http\Controllers\member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Stripe\Stripe;
use Stripe\Checkout\Session;


// Models
use App\Models\Plan;
use App\Models\Workout;
use App\Models\Setting;
use App\Models\Reduction;
use App\Models\Pricing;
use App\Models\Order;
use App\Models\ReductionUser;

// Requests
use App\Http\Requests\member\payment\ReductionRequest;
use App\Http\Requests\member\payment\PlanRequest;
use App\Http\Requests\member\payment\WorkoutRequest;

class PaymentController extends Controller
{
    // PLAN INDEX - DONE
    public function plan_index() {
        $pricings = Pricing::available()->get();

        return view('member.payment.plan_index')->with([
            'pricings' => $pricings,
            'nutrition_price' => Setting::first()->nutrition_price,
        ]);
    }

    // WORKOUT INDEX - DONE
    public function workout_index() {
        $workout_price = Setting::first()->workout_price;

        return view('member.payment.workout_index')->with([
            'workout_price' => $workout_price,
        ]);
    }

    // GET REDUCTION - DONE
    public function get_reduction(ReductionRequest $request) {
        $data = $request->validated();
        $code = $data['code'];

        $reduction = Reduction::available()->where('code', $code)->first();

        if(Auth::user()->hasUsedReduction($reduction->id)) {
            return response()->json([
                'status' => "error",
                'message' => 'Vous avez déjà utilisé ce code de réduction.',
            ]);
        }

        if($reduction) {
            return response()->json([
                'status' => "success",
                'reduction' => $reduction,
            ]);
        } else {
            return response()->json([
                'status' => "error",
                'message' => 'Code de réduction invalide.',
            ]);
        }
    }

    // APPLY REDUCTION - DONE
    private function applyReduction($total_price, $reduction_id)
    {
        if ($reduction_id) {
            $reduction = Reduction::findOrFail($reduction_id);

            if (Auth::user()->hasUsedReduction($reduction->id)) {
                return ['error' => 'Vous avez déjà utilisé ce code de réduction.'];
            } else {
                ReductionUser::create([
                    'reduction_id' => $reduction->id,
                    'user_id' => Auth::id(),
                ]);
                $total_price -= ($total_price * $reduction->percentage / 100);
            }
        }
        return ['total_price' => $total_price];
    }

    // CREATE STRIPE SESSION - DONE
    private function createStripeSession($order, $amount_cents, $product_name, $type, $data)
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        $metadata = [];

        if($type == 'plan') {
            $metadata = [
                'type' => 'plan',
                'pricing_id' => $data['pricing_id'],
                'nutrition_option' => $data['nutrition_option'],
            ];
        } elseif($type == 'workout') {
            $metadata = [
                'type' => 'workout',
                'workouts' => $data['workouts'],
            ];
        } else {
            return redirect()->back()->with('error', 'Une erreur est survenue.');
        }

        return Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'eur',
                    'product_data' => [
                        'name' => env('APP_NAME') . ' - ' . $product_name,
                    ],
                    'unit_amount' => $amount_cents,
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => route('member.payment.success') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('member.payment.cancel') . '?session_id={CHECKOUT_SESSION_ID}',
            'client_reference_id' => $order->id,
            'metadata' => $metadata,
        ]);
    }

    // WORKOUT PAYMENT - DONE
    public function workout_payment(WorkoutRequest $request)
    {
        $data = $request->validated();

        // Calcul du prix total
        $workouts = $data['workouts'];
        $workout_price = Setting::first()->workout_price;
        $total_price = $workout_price * $workouts;

        // Application de la réduction
        $reductionResult = $this->applyReduction($total_price, $data['reduction_id'] ?? null);
        if (isset($reductionResult['error'])) {
            return redirect()->back()->with('error', $reductionResult['error']);
        }
        $total_price = $reductionResult['total_price'];

        // Arrondir et convertir en centimes
        $total_price = round($total_price, 2);
        $total_price_cents = $total_price * 100;

        // Création de la commande
        $order = Order::create([
            'type'                  => 'workout',
            'user_id'               => Auth::id(),
            'reduction_id'          => $data['reduction_id'] ?? null,
            'total_price'           => $total_price,
            'description'           => $this->CreateDescription($data, "workout"),
        ]);

        // Création de la session Stripe
        $session = $this->createStripeSession($order, $total_price_cents, $workouts . " séances de sport", 'workout', $data);

        // Sauvegarder l'ID de la session Stripe
        $order->stripe_session_id = $session->id;
        $order->save();

        return redirect($session->url);
    }

    // PLAN PAYMENT - DONE
    public function plan_payment(PlanRequest $request)
    {
        $data = $request->validated();

        // Calcul du prix total
        $pricing = Pricing::findOrFail($data['pricing_id']);
        $total_price = $pricing->price;

        // Ajouter le prix de l'option nutrition si sélectionnée
        if ($data['nutrition_option']) {
            $total_price += Setting::first()->nutrition_price;
        }

        // Application de la réduction
        $reductionResult = $this->applyReduction($total_price, $data['reduction_id'] ?? null);
        if (isset($reductionResult['error'])) {
            return redirect()->back()->with('error', $reductionResult['error']);
        }
        $total_price = $reductionResult['total_price'];

        // Arrondir et convertir en centimes
        $total_price = round($total_price, 2);
        $total_price_cents = $total_price * 100;

        // Création de la commande
        $order = Order::create([
            'type'                  => 'plan',
            'user_id'               => Auth::id(),
            'reduction_id'          => $data['reduction_id'] ?? null,
            'total_price'           => $total_price,
            'description'           => $this->CreateDescription($data, "plan"),
        ]);

        // Création de la session Stripe
        $session = $this->createStripeSession($order, $total_price_cents, $pricing->title, 'plan', $data);

        // Sauvegarder l'ID de la session Stripe
        $order->stripe_session_id = $session->id;
        $order->save();

        return redirect($session->url);
    }

    // SUCCESS - DOING
    public function success(Request $request)
    {
        $session_id = $request->get('session_id');

        // Un utilisateur essaye d'accéder à la page sans passer par Stripe
        if (!$session_id) {
            return redirect()->route('main.account')->with('error', 'Une erreur est survenue.');
        }

        Stripe::setApiKey(config('services.stripe.secret'));

        // Récupération de la session Stripe et de la commande
        $session = Session::retrieve($session_id);
        $orderId = $session->client_reference_id;
        $order = Order::findOrFail($orderId);

        // Vérification du statut du paiement
        if ($session->payment_status == 'paid') {
            $order->update(['status' => 1]);

            // Récupération des métadonnées
            $metadata = $session->metadata->toArray();

            if ($metadata['type'] === 'plan') {
                // Création de l'abonnement
                $pricing = Pricing::findOrFail($metadata['pricing_id']);
                $plan = Plan::create([
                    'user_id' => $order->user_id,
                    'order_id' => $order->id,
                    'pricing_id' => $pricing->id,
                    'start_date' => now(),
                    'nutrition_option' => $metadata['nutrition_option'],
                    'sessions_left' => $pricing->nbr_sessions,
                    'expiration_date' => now()->addDays(30),
                ]);

            } elseif ($metadata['type'] === 'workout') {

                // Création des séances individuelles
                $nbr_sessions = $metadata['workouts'];
                for ($i = 0; $i < $nbr_sessions; $i++) {
                    $workout = Workout::create([
                        'user_id' => $order->user_id,
                        'order_id' => $order->id,
                        'plan_id' => null,
                        'date' => null,
                        'status' => 0,
                        'notified' => 0,
                    ]);
                }
            } else {
                return redirect()->route('main.account')->with('error', 'Une erreur est survenue.');
            }

            return view('member.payment.success');
        } else {
            return redirect()->route('member.payment.cancel', ['session_id' => $session_id]);
        }
}



    // CANCEL - DONE
    public function cancel(Request $request)
    {
        $session_id = $request->get('session_id');

        // Un utilisateur essaye d'accéder à la page sans passer par Stripe
        if (!$session_id) {
            return redirect()->route('main.account')->with('error', 'Une erreur est survenue.');
        }

        // Récupération de la session Stripe et de la commande
        Stripe::setApiKey(config('services.stripe.secret'));

        $session = Session::retrieve($session_id);
        $orderId = $session->client_reference_id;
        $order = Order::findOrFail($orderId);

        // La commande est annulée
        $order->update(['status' => -1]);

        return view('member.payment.cancel');
    }


    // CREATE DESCRIPTION - DONE
    private function CreateDescription($data, $payment) {
        $description = "";
        if($payment == "plan") {
            $pricing = Pricing::findOrFail($data['pricing_id']);
            $description = "L'utilisateur ". Auth::user()->firstname. " " .Auth::user()->lastname. " a souscrit à l'abonnement ". $pricing->title. " pour un montant de ". $data['total_price']. "€. <br>";
            if($data['nutrition_option']) {
                $description .= "L'utilisateur a également souscrit à l'option nutrition. <br>";
            }
            if($data['reduction_id']) {
                $reduction = Reduction::findOrFail($data['reduction_id']);
                $description .= "L'utilisateur a utilisé le code de réduction ". $reduction->code. " pour un montant de ". $reduction->percentage. "%. <br>";
            }
            $description .= "L'utilisateur a renseigné les informations suivantes :<br>Nom : ". $data['lastname']. "<br>Prénom : ". $data['firstname']. "<br>Email : ". $data['email']. "<br>Téléphone : ". $data['phone']. "<br>Adresse : ". $data['address']. "<br>Ville : ". $data['city']. "<br>Code postal : ". $data['postal_code']. ".";
        } elseif ($payment == "workout") {
            $description = "L'utilisateur ". Auth::user()->firstname. " " .Auth::user()->lastname. " a acheté ". $data['workouts']. " séances de sport pour un montant de ". $data['total_price']. "€. <br>";
            if($data['reduction_id']) {
                $reduction = Reduction::findOrFail($data['reduction_id']);
                $description .= "L'utilisateur a utilisé le code de réduction ". $reduction->code. " pour un montant de ". $reduction->percentage. "%. <br>";
            }
            $description .= "L'utilisateur a renseigné les informations suivantes :<br>Nom : ". $data['lastname']. "<br>Prénom : ". $data['firstname']. "<br>Email : ". $data['email']. "<br>Téléphone : ". $data['phone']. "<br>Adresse : ". $data['address']. "<br>Ville : ". $data['city']. "<br>Code postal : ". $data['postal_code']. ".";
        } else {
            $description = "Aucune description.";
        }
        return $description;
    }
    

    
}
