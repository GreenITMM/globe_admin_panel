<?php

namespace App\Http\Controllers\Api\V1\Content;

use App\Models\Slider;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ContentManagement\SliderResource;

class SliderController extends Controller
{
    public function index() {
        $sliders = SliderResource::collection(Slider::orderBy('image_order_no', 'asc')->get());

        return response()->json([
            'status' => 'success',
            'sliders' => $sliders
        ]);
    }
}
