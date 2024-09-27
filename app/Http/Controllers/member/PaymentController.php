<?php

namespace App\Http\Controllers\member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Facades\Mail;
use PDF;

// Jobs
use App\Jobs\SendEmailJob;

// Mails
use App\Mail\InvoiceMail;

// Models
use App\Models\Plan;
use App\Models\Workout;
use App\Models\Setting;
use App\Models\Reduction;
use App\Models\Pricing;
use App\Models\Order;
use App\Models\ReductionUser;
use App\Models\Invoice;

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
        $product_quantity   = $data['workouts'];
        $product_price      = Setting::first()->workout_price;
        $price_ttc          = $product_quantity * $product_price;

        // Application de la réduction
        $reductionResult = $this->applyReduction($price_ttc, $data['reduction_id'] ?? null);
        if (isset($reductionResult['error'])) {
            return redirect()->back()->with('error', $reductionResult['error']);
        }
        $price_ttc  = $reductionResult['total_price'];

        // Arrondir et convertir en centimes
        $price_ttc          = round($price_ttc, 2);
        $price_ttc_cents    = $price_ttc * 100;

        // Taux de TVA
        $tax_rate = 0.20;

        // Calcul du prix HT et des taxes
        $price_ht   = $price_ttc / (1 + $tax_rate); // Calcul du prix HT
        $taxes      = $price_ttc - $price_ht; // Calcul des taxes

        // Création de la commande
        $order = Order::create([
            'reference'             => 'ORD-W-'. Str::random(8),
            
            'product_type'          => 'workout',
            'product_name'          => 'Séance de sport',
            'product_quantity'      => $product_quantity,
            'product_price'         => $product_price,

            'price_ttc'             => round($price_ttc, 2),
            'price_ht'              => round($price_ht, 2),
            'taxes'                 => round($taxes, 2),
            'currency'              => 'EUR',
            'description'           => $this->CreateDescription($data, "workout"),

            'user_id'               => Auth::id(),
            'customer_firstname'    => $data['firstname'],
            'customer_lastname'     => $data['lastname'],
            'customer_email'        => $data['email'],
            'customer_phone'        => $data['phone'],
            'customer_address'      => $data['address'],
            'customer_city'         => $data['city'],
            'customer_postal_code'  => $data['postal_code'],
            'customer_country'      => $data['country'],

            'payment_method'        => 'stripe',
            'stripe_session_id'     => null,
            'status'                => 0,
            'reduction_id'          => $data['reduction_id'] ?? null,
            'ip_address'            => $request->ip(),

            'cgv_terms_accepted_at' => now(),
            'rgpd_terms_accepted_at' => now(),
        ]);

        // Création de la session Stripe
        $session = $this->createStripeSession($order, $price_ttc_cents, $product_quantity . ' séance(s) de sport', 'workout', $data);

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
        $product        = Pricing::findOrFail($data['pricing_id']);
        $product_price      = $product->price;
        $price_ttc  = $product_price;
        $product_name   = $product->title;

        // Ajouter le prix de l'option nutrition si sélectionnée
        if ($data['nutrition_option']) {
            $price_ttc += Setting::first()->nutrition_price;
        }

        // Application de la réduction
        $reductionResult = $this->applyReduction($price_ttc, $data['reduction_id'] ?? null);
        if (isset($reductionResult['error'])) {
            return redirect()->back()->with('error', $reductionResult['error']);
        }
        $price_ttc    = $reductionResult['total_price'];

        // Arrondir et convertir en centimes
        $price_ttc          = round($price_ttc, 2);
        $price_ttc_cents    = $price_ttc * 100;

        // Taux de TVA
        $tax_rate = 0.20;

        // Calcul du prix HT et des taxes
        $price_ht   = $price_ttc / (1 + $tax_rate); // Calcul du prix HT
        $taxes      = $price_ttc - $price_ht; // Calcul des taxes

        // Création de la commande
        $order = Order::create([
            'reference'             => 'ORD-P-'. Str::random(8),
            
            'product_type'          => 'plan',
            'product_name'          => $product_name,
            'product_quantity'      => 1,
            'product_price'         => $product_price,

            'price_ttc'             => round($price_ttc, 2),
            'price_ht'              => round($price_ht, 2),
            'taxes'                 => round($taxes, 2),
            'currency'              => 'EUR',
            'description'           => $this->CreateDescription($data, "plan"),

            'user_id'               => Auth::id(),
            'customer_firstname'    => $data['firstname'],
            'customer_lastname'     => $data['lastname'],
            'customer_email'        => $data['email'],
            'customer_phone'        => $data['phone'],
            'customer_address'      => $data['address'],
            'customer_city'         => $data['city'],
            'customer_postal_code'  => $data['postal_code'],
            'customer_country'      => $data['country'],

            'payment_method'        => 'stripe',
            'stripe_session_id'     => null,
            'status'                => 0,
            'reduction_id'          => $data['reduction_id'] ?? null,
            'ip_address'            => $request->ip(),

            'cgv_terms_accepted_at' => now(),
            'rgpd_terms_accepted_at' => now(),
        ]);

        // Création de la session Stripe
        $session = $this->createStripeSession($order, $price_ttc_cents, $product_name, 'plan', $data);

        // Sauvegarder l'ID de la session Stripe
        $order->stripe_session_id = $session->id;
        $order->save();

        return redirect($session->url);
    }

    // INVOICE
    public function invoice() {
        
        $invoice = Invoice:: first();
        $order = $invoice->order;
        $setting = Setting::first();

        return view('member.payment.invoice')->with([
            'invoice' => $invoice,
            'order' => $order,
            'settings' => $setting,
        ]);
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

        // La commande a déjà été traitée
        if($order->status != 0) {
            return redirect()->route('main.account')->with('error', 'Une erreur est survenue.');
        }

        // Vérification du statut du paiement
        if ($session->payment_status == 'paid') {
            $order->update(['status' => 1]);

            // Récupération des métadonnées
            $metadata = $session->metadata->toArray();

            // Facture
            $this->createInvoice($order);

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
    
    // GENERATE INVOICE NUMBER - DONE
    private function generateInvoiceNumber() {
        $year = date('Y');
        
        // Récupère le dernier numéro de facture pour l'année en cours
        $lastInvoice = Invoice::where('invoice_number', 'like', "INV-{$year}-%")->latest()->first();
        
        if($lastInvoice) {
            $lastInvoiceNumber = $lastInvoice->invoice_number;
            $parts = explode('-', $lastInvoiceNumber);
            
            // Assure-toi que la partie incrémentale existe
            $lastIncrement = isset($parts[2]) ? intval($parts[2]) : 0;
            $lastIncrement++;
            
            // Remplit avec des zéros à gauche pour obtenir un format de 4 chiffres
            $lastIncrement = str_pad($lastIncrement, 4, '0', STR_PAD_LEFT);
            
            $invoiceNumber = 'INV-' . $year . '-' . $lastIncrement;
        } else {
            // Première facture de l'année
            $invoiceNumber = 'INV-' . $year . '-0001';
        }
        
        return $invoiceNumber;
    }
    

    private function createInvoice(Order $order) {
    
        // Génération du numéro de facture
        $invoice_number = $this->generateInvoiceNumber();
    
        // Récupération des informations nécessaires
        $order_id = $order->id;
        $user = $order->user;
        $settings = Setting::first();
    
        // Création de l'Invoice sans les informations du PDF pour éviter les conflits
        $invoice = Invoice::create([
            'invoice_number' => $invoice_number,
            'order_id' => $order_id,
            'path' => '', // Temporarily empty
            'filename' => '',
            'type' => 'application/pdf',
            'size' => 0,
            'extension' => 'pdf',
            'mime_type' => 'application/pdf',
            'is_cancelled' => false,
            'cancellation_reason' => null,
        ]);
    
        // Génération du PDF
        $pdf = PDF::loadView('member.payment.invoice', [
            'invoice' => $invoice,
            'order' => $order,
            'settings' => $settings,
        ]);
    
        // Définition du nom et du chemin du fichier
        $filename = 'facture_' . $invoice_number . '.pdf';
        $path = 'invoices/' . $filename;
    
        // Sauvegarde du PDF dans le stockage
        Storage::put('public/' . $path, $pdf->output());
    
        // Mise à jour de l'Invoice avec les informations du fichier
        $invoice->update([
            'path' => 'public/' . $path,
            'filename' => $filename,
            'size' => Storage::size('public/' . $path),
        ]);
    
        // Envoi de la facture par email via un job
        $mail = new InvoiceMail($invoice);
        SendEmailJob::dispatch($mail);
    
        return $invoice;
    }
    
    
}
