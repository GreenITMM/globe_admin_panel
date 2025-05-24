<?php

namespace App\Http\Controllers\Api\V1\Content;

use App\Http\Controllers\Controller;
use App\Http\Resources\ContentManagement\PartnerResource;
use App\Models\Partner;
use Illuminate\Http\Request;

class PartnerController extends Controller
{
    public function index() {
        $partners = PartnerResource::collection(Partner::select('id', 'name', 'logo', 'website_url')->latest()->get());

        return response()->json([
            'status' => 'success',
            'partners' => $partners
        ]);
    }
}
