<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {   
        return view('home.index');
    }

    public function dashboard()
    {
        $certificates = DB::table('certificates')
            ->select('certificates.id', 'first_name', 'last_name', 'email', 'tree_amount', 'amount', 'activate_at', 'name')
            ->leftJoin('currencies', 'certificates.currency_id', '=', 'currencies.id')
            ->whereNotNull('activate_at')
            ->get();

        $plantations = DB::table('plantations')
            ->select('id', 'name', 'year', 'cost')
            ->get();
        
        $currencies = DB::table('currencies')
            ->select('id', 'name')
            ->get();

        $paymentOptions = DB::table('payment_options')
            ->select('id', 'name')
            ->get();

        return view('dashboard', compact('certificates', 'plantations', 'currencies', 'paymentOptions'));
    }

}
