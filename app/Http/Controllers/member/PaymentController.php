<?php

namespace App\Http\Controllers\member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


// Models
use App\Models\Plan;
use App\Models\Workout;
use App\Models\Setting;
use App\Models\Reduction;
use App\Models\Pricing;
use App\Models\Order;

// Requests
use App\Http\Requests\member\payment\ReductionRequest;
use App\Http\Requests\member\payment\PlanRequest;

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

    public function workout_index() {
        // 
    }

    

    // GET REDUCTION - DONE
    public function get_reduction(ReductionRequest $request) {
        $data = $request->validated();
        $code = $data['code'];

        $reduction = Reduction::available()->where('code', $code)->first();

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



    public function plan_payment(PlanRequest $request)
    {

        $data = $request->validated();

        $total_price = $data['total_price'] * 100; // Convertir en centimes
        $pricing = Pricing::findOrFail($data['pricing_id']);

        // 1. Créer l'ordre d'achat dans la base de données
        $order = Order::create([
            'user_id' => Auth::id(),
            'total_price' => $total_price / 100, // Convertir en euros
            'description' => $this->CreateDescription($data, "abonnement"),
            'status' => 0, // Statut initial
        ]);


        // 2. Créer la session de paiement Stripe
        Stripe::setApiKey(config('services.stripe.secret'));

        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'eur',
                    'product_data' => [
                        'name' => $pricing->title,
                    ],
                    'unit_amount' => $total_price,
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => route('member.payment.success') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('member.payment.cancel'),

            // 3. Associer l'ordre à la session Stripe via client_reference_id ou metadata
            'client_reference_id' => $order->id,
        ]);

        // 4. Sauvegarder l'ID de la session Stripe dans l'ordre (optionnel mais recommandé)
        $order->stripe_session_id = $session->id;
        $order->save();

        // 5. Rediriger vers l'URL de paiement de Stripe
        return redirect($session->url);
    }

    public function success(Request $request)
    {
        // Récupérer l'ID de la session
        $session_id = $request->get('session_id');

        Stripe::setApiKey(config('services.stripe.secret'));

        // Récupérer la session Stripe
        $session = Session::retrieve($session_id);

        // Récupérer l'ordre d'achat en utilisant client_reference_id
        $orderId = $session->client_reference_id;
        $order = Order::findOrFail($orderId);

        // Vérifier le statut du paiement
        if ($session->payment_status == 'paid') {
            // Mettre à jour l'ordre avec le statut "paid"
            $order->update(['status' => 1]);

            // TODO : Créer un abonnement pour l'utilisateur si nécessaire


            // Oublier la variable de session
            session()->forget('order_id');

            return view('checkout.success');
        } else {
            // Gérer les cas où le paiement n'est pas réussi
            return redirect()->route('checkout.cancel', ['order' => $order]);
        }
    }


    public function cancel(Order $order)
    {
        // Mettre à jour l'ordre avec le statut "cancelled"
        $order->update(['status' => -1]);

        // Oublier la variable de session
        session()->forget('order_id');
    

        // Le paiement a été annulé
        return view('checkout.cancel');
    }


    private function CreateDescription($data, $payment) {
        $description = "";
        if($payment == "abonnement") {
            // Abonnement
            $pricing = Pricing::findOrFail($data['pricing_id']);
            $description = "L'utilisateur ". Auth::user()->firstname. " " .Auth::user()->lastname. " a souscrit à l'abonnement ". $pricing->title. " pour un montant de ". $data['total_price']. "€. ";
            if($data['nutrition_option']) {
                $description .= " L'utilisateur a également souscrit à l'option nutrition. ";
            }
            if($data['reduction_id']) {
                $reduction = Reduction::findOrFail($data['reduction_id']);
                $description .= "L'utilisateur a utilisé le code de réduction ". $reduction->code. " pour un montant de ". $reduction->percentage. "%. ";
            }
            $description .= "L'utilisateur a renseigné les informations suivantes = Nom : ". $data['lastname']. ", Prénom : ". $data['firstname']. ", Email : ". $data['email']. ", Téléphone : ". $data['phone']. ", Adresse : ". $data['address']. ", Ville : ". $data['city']. ", Code postal : ". $data['postal_code']. ". ";
        } else {
            // Workouts
        }
        return $description;
    }

    
}
