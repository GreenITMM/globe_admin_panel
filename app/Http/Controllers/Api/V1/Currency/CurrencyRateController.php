<?php

namespace App\Http\Controllers\Api\V1\Currency;

use App\Models\CurrencyRate;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CurrencyRateController extends Controller
{
    public function getUsdMmkRate() {
        $usdToMmkRate = CurrencyRate::where('from_currency', 'USD')
                        ->where('to_currency', 'MMK')
                        ->latest('created_at')
                        ->value('rate');

        $rate = $usdToMmkRate ?? 0;

        return response()->json([
            'status' => 'success',
            'rate' => $rate
        ]);
    }
}
