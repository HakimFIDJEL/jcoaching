<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Carbon\Carbon;

use App\Models\User;
use App\Models\Workout;
use App\Models\Contact;
use App\Models\Setting;
use App\Models\Order;

class MainController extends Controller
{
    public function index()
    {
        $contacts   = Contact::all();
        $members    = User::members()->get();
        $workouts   = Workout::all()->load('user');
        $orders     = Order::all();
        $revenues   = 0;

        // Calcul des revenus totaux
        foreach($orders as $order) {
            $revenues += $order->price_ttc;
        }

        // 1. Données pour le graphique annuel
        $currentYear = Carbon::now()->year;
        $chartMonths = collect([
            'Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin',
            'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'
        ]);

        $yearlyRevenues = $chartMonths->map(function ($month, $index) use ($currentYear) {
            return Order::whereYear('created_at', $currentYear)
                        ->whereMonth('created_at', $index + 1)
                        ->sum('price_ttc');
        });

        $yearChartData = [
            'months' => $chartMonths,
            'revenues' => $yearlyRevenues
        ];

        // 2. Données pour le graphique mensuel
        $currentMonth = Carbon::now()->month;
        $daysInMonth = Carbon::now()->daysInMonth;
        $chartDays = collect(range(1, $daysInMonth))->map(function ($day) {
            return (string)$day;
        });

        $monthlyRevenues = $chartDays->map(function ($day) use ($currentMonth, $currentYear) {
            return Order::whereYear('created_at', $currentYear)
                        ->whereMonth('created_at', $currentMonth)
                        ->whereDay('created_at', $day)
                        ->sum('price_ttc');
        });

        $monthChartData = [
            'days' => $chartDays,
            'revenues' => $monthlyRevenues
        ];

        // 3. Données pour le graphique hebdomadaire
        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now()->endOfWeek();
        $chartDaysWeek = collect([]);
        $weeklyRevenues = collect([]);

        for ($date = $startOfWeek->copy(); $date->lte($endOfWeek); $date->addDay()) {
            $chartDaysWeek->push($date->format('l')); // Nom du jour en anglais
            $weeklyRevenues->push(
                Order::whereDate('created_at', $date->toDateString())
                    ->sum('price_ttc')
            );
        }

        // Pour les noms des jours en français
        $chartDaysWeek = $chartDaysWeek->map(function($day) {
            return Carbon::parse($day)->translatedFormat('l'); // Assurez-vous que la locale est bien définie en français
        });

        $weekChartData = [
            'days' => $chartDaysWeek,
            'revenues' => $weeklyRevenues
        ];

        return view('admin.index')->with([
            'contacts' => $contacts,
            'members' => $members,
            'workouts' => $workouts,
            'orders' => $orders,
            'revenues' => $revenues,

            'yearChartData' => $yearChartData,
            'monthChartData' => $monthChartData,
            'weekChartData' => $weekChartData
        ]);
    }

}
