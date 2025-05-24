<?php

namespace App\Http\Controllers\Api\V1\Content;

use App\Models\Promotion;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ContentManagement\PromotionResource;

class PromotionController extends Controller
{
    public function index(Request $request) {
        $count = $request->count;
        $promotions = PromotionResource::collection($count != 0 ? Promotion::where('is_active', 1)->latest()->take(3)->get() : Promotion::where('is_active', 1)->latest()->get());

        return response()->json([
            'status' => 'success',
            'promotions' => $promotions
        ]);
    }
}
