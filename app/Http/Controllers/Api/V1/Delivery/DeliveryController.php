<?php

namespace App\Http\Controllers\Api\V1\Delivery;

use App\Http\Controllers\Controller;
use App\Http\Resources\DeliveryManagement\StateResource;
use App\Models\State;
use Illuminate\Http\Request;

class DeliveryController extends Controller
{
    public function getDeliveryStates() {
        $data = StateResource::collection( State::with('cities')->get());

        return response()->json($data);
    }
}
