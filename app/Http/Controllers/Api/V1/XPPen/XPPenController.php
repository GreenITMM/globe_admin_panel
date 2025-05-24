<?php

namespace App\Http\Controllers\Api\V1\XPPen;

use App\Http\Resources\XpPenManagement\XPPenProductResource;
use App\Models\XpPenProduct;
use App\Models\XpPenSeries;
use Illuminate\Http\Request;
use App\Models\XpPenCategory;
use App\Http\Controllers\Controller;
use App\Http\Resources\XpPenManagement\XPPenSeriesResource;
use App\Http\Resources\XpPenManagement\XPPenCategoryResource;

class XPPenController extends Controller
{
    public function getCategory() {
        $categories = XPPenCategoryResource::collection(XpPenCategory::orderBy('created_at', 'asc')->get());

        return response()->json([
            'status' => 'success',
            'categories' => $categories
        ]);
    }

    public function getSeries() {
        $xppen_series = XPPenSeriesResource::collection(XpPenSeries::orderBy('created_at', 'asc')->get());

        return response()->json([
            'status' => 'success',
            'xppen_series' => $xppen_series
        ]);
    }

    public function getProducts($category_slug) {
        $category = XpPenCategory::where('slug', $category_slug)->select('id')->first();
        $products = XPPenProductResource::collection(XpPenProduct::with('category', 'series', 'images')->where('category_id', $category->id)->get());

        return response()->json([
            'status' => 'success',
            'products' => $products
        ]);
    }

    public function getProductDetail($product_slug) {
        $product = new XPPenProductResource(XpPenProduct::with('category', 'series', 'images')->where('slug', $product_slug)->first());

        $related_products = XPPenProductResource::collection(XpPenProduct::with('category', 'series', 'images')->inRandomOrder()->limit(4)->get());

        return response()->json([
            'status' => 'success',
            'product' => $product,
            'related_products' => $related_products
        ]);
    }

}
