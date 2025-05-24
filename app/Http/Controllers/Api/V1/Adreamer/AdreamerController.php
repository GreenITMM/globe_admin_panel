<?php

namespace App\Http\Controllers\Api\V1\Adreamer;

use App\Http\Controllers\Controller;
use App\Http\Resources\AdreamerManagement\AdreamerAttributeResource;
use App\Http\Resources\AdreamerManagement\AdreamerCategoryResource;
use App\Http\Resources\AdreamerManagement\AdreamerProductResource;
use App\Models\AdreamerCategory;
use App\Models\AdreamerProduct;
use Illuminate\Http\Request;

class AdreamerController extends Controller
{
    public function getCategories() {
        $categories = AdreamerCategoryResource::collection(AdreamerCategory::all());

        return response()->json(['status' => 'success', 'categories' => $categories]);
    }

    public function getProducts($category_slug) {
        $category = AdreamerCategory::where('slug', $category_slug)->first();
        $products = AdreamerProductResource::collection(AdreamerProduct::with('category',  'images', 'attributes', 'variations')->where('adreamer_category_id', $category->id)->get());

        $attributes = $products->isNotEmpty() ? AdreamerAttributeResource::collection(...$products->pluck('attributes')->unique('id')->values()->all()): [];

        return response()->json(['status' => 'success',  'attributes' => $attributes,   'products' => $products]);
    }

    public function getProductDetail($product_slug) {
        $product = new AdreamerProductResource(AdreamerProduct::with('category', 'images', 'attributes', 'variations')->where('slug', $product_slug)->first());

        $related_products = AdreamerProductResource::collection(AdreamerProduct::with('category', 'images', 'attributes', 'variations')->inRandomOrder()->limit(4)->get());

        return response()->json(['status' => 'success', 'product' => $product, 'related_products' => $related_products]);
    }
}
