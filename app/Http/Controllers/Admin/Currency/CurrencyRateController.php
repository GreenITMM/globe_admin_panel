<?php

namespace App\Http\Controllers\Admin\Currency;

use App\Http\Controllers\Controller;
use App\Models\CurrencyRate;
use Illuminate\Http\Request;

class CurrencyRateController extends Controller
{
    public function index() {
        $currency_rate = CurrencyRate::where('from_currency', 'USD')->where('to_currency', 'MMK')->orderBy('created_at', 'desc')->first();
        $rate = $currency_rate->rate ?? 0;
        return view('admin.currency_rate.index', compact('rate'));
    }

    public function changeRate(Request $request) {
        $rate = $request->mmk_amount;
        $currency_rate = CurrencyRate::where('from_currency', 'USD')->where('to_currency', 'MMK')->orderBy('created_at', 'desc')->first();
        $currency_rate->rate = $rate;
        $currency_rate->save();

        session()->flash('success', 'Currency rate updated successfully');
        return 'success';
    }
}
