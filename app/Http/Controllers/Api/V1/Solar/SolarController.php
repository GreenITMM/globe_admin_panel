<?php

namespace App\Http\Controllers\Api\V1\Solar;

use App\Models\SolarProduct;
use Illuminate\Http\Request;
use App\Models\SolarCategory;
use App\Http\Controllers\Controller;
use App\Http\Resources\SolarManagement\SolarProductResource;
use App\Http\Resources\SolarManagement\SolarCategoryResource;
use App\Http\Resources\SolarManagement\SolarAttributeResource;

class SolarController extends Controller
{
    public function getCategories() {
        $categories = SolarCategoryResource::collection(SolarCategory::with('children')->where('parent_id', null)->get());

        return response()->json(['status' => 'success', 'categories' => $categories]);
    }

    public function getProducts($category_slug) {
        $category = SolarCategory::where('slug', $category_slug)->first();
        $products = SolarProductResource::collection(SolarProduct::with('category',  'images', 'attributes', 'variations')->where('solar_category_id', $category->id)->get());

        $attributes = $products->isNotEmpty() ? SolarAttributeResource::collection(...$products->pluck('attributes')->unique('id')->values()->all()): [];

        return response()->json(['status' => 'success',  'attributes' => $attributes,   'products' => $products]);
    }

    public function getProductDetail($product_slug) {
        $product = new SolarProductResource(SolarProduct::with('category', 'images', 'attributes', 'variations')->where('slug', $product_slug)->first());

        $related_products = SolarProductResource::collection(SolarProduct::with('category', 'images', 'attributes', 'variations')->inRandomOrder()->limit(4)->get());

        return response()->json(['status' => 'success', 'product' => $product, 'related_products' => $related_products]);
    }
}
