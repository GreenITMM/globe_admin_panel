<?php

namespace App\Http\Controllers\Api\V1\Product;

use App\Models\Product;
use App\Models\Category;
use App\Models\SolarProduct;
use App\Models\XpPenProduct;
use Illuminate\Http\Request;
use App\Models\AdreamerProduct;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductManagement\BrandResource;
use App\Http\Resources\ProductManagement\ProductResource;
use App\Http\Resources\ProductManagement\CategoryResource;
use App\Http\Resources\ProductManagement\AttributeResource;
use App\Http\Resources\SolarManagement\SolarProductResource;
use App\Http\Resources\XpPenManagement\XPPenProductResource;
use App\Http\Resources\AdreamerManagement\AdreamerProductResource;

class ProductController extends Controller
{
    public function getCategories() {
        $categories = CategoryResource::collection(Category::all());

        return response()->json(['status' => 'success', 'categories' => $categories]);
    }

    public function getProducts($category_slug) {
        $category = Category::where('slug', $category_slug)->first();
        $products = ProductResource::collection(Product::with('category', 'series', 'brand', 'images', 'attributes', 'variations')->where('category_id', $category->id)->get());

        $brands = BrandResource::collection($products->pluck('brand')->unique('id')->values()->all());

        $attributes = AttributeResource::collection(
            $products->flatMap(fn ($product) => $product->attributes)->unique('id')->values()
        );
        return response()->json(['status' => 'success', 'brands' => $brands, 'attributes' => $attributes,   'products' => $products]);
    }

    public function getProductDetail($product_slug) {
        $product = new ProductResource(Product::with('category', 'series', 'images', 'attributes', 'variations')->where('slug', $product_slug)->first());

        $related_products = ProductResource::collection(Product::with('category', 'series', 'images', 'attributes', 'variations')->inRandomOrder()->limit(4)->get());

        return response()->json(['status' => 'success', 'product' => $product, 'related_products' => $related_products]);
    }

    public function getRandomProducts() {
        $products = ProductResource::collection(Product::with('category', 'series', 'images', 'attributes', 'variations')->inRandomOrder()->limit(4)->get());

        return response()->json(['status' => 'success', 'products' => $products]);
    }

    public function searchProducts(Request $request)
    {
        $keyword = $request->input('q');

        if (!$keyword) {
            return response()->json([
                'ok' => false,
                'message' => 'Search keyword is required.'
            ], 400);
        }

        // Search in each product table
        $products = ProductResource::collection(
            Product::with(['category', 'brand', 'images'])
                ->where('name', 'like', "%{$keyword}%")
                ->get()
        );

        $xpPenProducts = XPPenProductResource::collection(
            XpPenProduct::with(['category', 'series', 'images'])
                ->where('name', 'like', "%{$keyword}%")
                ->get()
        );

        $adreamerProducts = AdreamerProductResource::collection(
            AdreamerProduct::with('category',  'images', 'attributes', 'variations')
                ->where('name', 'like', "%{$keyword}%")
                ->get()
        );

        $solarProducts = SolarProductResource::collection(
            SolarProduct::with(['category', 'images', 'attributes'])
                ->where('name', 'like', "%{$keyword}%")
                ->get()
        );

        // Merge and return results
        $allResults = collect()
            ->merge($products)
            ->merge($xpPenProducts)
            ->merge($solarProducts)
            ->merge($adreamerProducts)
            ->values();

        return response()->json([
            'ok' => true,
            'results' => $allResults
        ]);
    }

    public function getPopularProducts() {
        $products = ProductResource::collection(
            Product::with(['category', 'brand', 'images'])
                ->inRandomOrder()->limit(4)
                ->get()
        );

        $xpPenProducts = XPPenProductResource::collection(
            XpPenProduct::with(['category', 'series', 'images'])
                ->inRandomOrder()->limit(4)
                ->get()
        );

        $adreamerProducts = AdreamerProductResource::collection(
            AdreamerProduct::with('category',  'images', 'attributes', 'variations')
                ->inRandomOrder()->limit(4)
                ->get()
        );

        $solarProducts = SolarProductResource::collection(
            SolarProduct::with(['category', 'images', 'attributes'])
                ->inRandomOrder()->limit(4)
                ->get()
        );

        // Merge and return results
        $allResults = collect()
            ->merge($products)
            ->merge($xpPenProducts)
            ->merge($solarProducts)
            ->merge($adreamerProducts)
            ->values();

        return response()->json([
            'ok' => true,
            'products' => $allResults
        ]);
    }

}
