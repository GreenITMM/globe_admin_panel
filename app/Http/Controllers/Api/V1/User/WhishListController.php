<?php

namespace App\Http\Controllers\Api\V1\User;

use App\Models\Product;
use App\Models\WhishList;
use App\Models\SolarProduct;
use App\Models\XpPenProduct;
use Illuminate\Http\Request;
use App\Models\AdreamerProduct;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductManagement\ProductResource;
use App\Http\Resources\SolarManagement\SolarProductResource;
use App\Http\Resources\XpPenManagement\XPPenProductResource;
use App\Http\Resources\AdreamerManagement\AdreamerProductResource;

class WhishListController extends Controller
{
    public function addToWishlist(Request $request)
    {
        $user = auth()->user();

        $productModel = match ($request->product_type) {
            'normal'   => Product::class,
            'solar'    => SolarProduct::class,
            'xp_pen'   => XpPenProduct::class,
            'adreamer' => AdreamerProduct::class,
            default    => throw new \InvalidArgumentException("Invalid product type"),
        };

        $exists = WhishList::where('user_id', $user->id)
            ->where('product_type', $productModel)
            ->where('product_id', $request->product_id)
            ->exists();

        if (!$exists) {
            Whishlist::create([
                'user_id' => $user->id,
                'product_type' => $productModel,
                'product_id' => $request->product_id,
            ]);
        }

        $wishlistProductIds = Whishlist::where('user_id', $user->id)
            ->where('product_type', Product::class)
            ->pluck('product_id');

        $wishlistXpPenProductIds = Whishlist::where('user_id', $user->id)
            ->where('product_type', XpPenProduct::class)
            ->pluck('product_id');

        $wishlistSolarProductIds = Whishlist::where('user_id', $user->id)
            ->where('product_type', SolarProduct::class)
            ->pluck('product_id');

        $adreamerProductIds = Whishlist::where('user_id', $user->id)
            ->where('product_type', AdreamerProduct::class)
            ->pluck('product_id');

        $products = ProductResource::collection(
            Product::with('category', 'series', 'brand', 'images', 'attributes', 'variations')
                ->whereIn('id', $wishlistProductIds)
                ->get()
        );

        $adremerProducts = AdreamerProductResource::collection(
            AdreamerProduct::with('category',  'images', 'attributes', 'variations')
                ->whereIn('id', $adreamerProductIds)
                ->get()
        );

        $xpPenProducts = XPPenProductResource::collection(
            XpPenProduct::with('category', 'series', 'images')
                    ->whereIn('id', $wishlistXpPenProductIds)->get());

        $solarProducts = SolarProductResource::collection(
            SolarProduct::with('category',  'images', 'attributes', 'variations')
                ->whereIn('id', $wishlistSolarProductIds)
                ->get()
            );

        $allWishlists = collect()
            ->merge($products)
            ->merge($xpPenProducts)
            ->merge($solarProducts)
            ->merge($adremerProducts)
            ->values(); // Reset keys

        return response()->json(['ok' => true, 'message' => 'Added to wishlist', 'wishlists' => $allWishlists]);
    }

    public function getWishlists($user_id) {
        $wishlistProductIds = Whishlist::where('user_id', $user_id)
            ->where('product_type', Product::class)
            ->pluck('product_id');

        $wishlistXpPenProductIds = Whishlist::where('user_id', $user_id)
            ->where('product_type', XpPenProduct::class)
            ->pluck('product_id');

        $wishlistSolarProductIds = Whishlist::where('user_id', $user_id)
            ->where('product_type', SolarProduct::class)
            ->pluck('product_id');

        $adreamerProductIds = Whishlist::where('user_id', $user_id)
            ->where('product_type', AdreamerProduct::class)
            ->pluck('product_id');


        $products = ProductResource::collection(
            Product::with('category', 'series', 'brand', 'images', 'attributes', 'variations')
                ->whereIn('id', $wishlistProductIds)
                ->get()
        );

        $adremerProducts = AdreamerProductResource::collection(
            AdreamerProduct::with('category',  'images', 'attributes', 'variations')
                ->whereIn('id', $adreamerProductIds)
                ->get()
        );

        $xpPenProducts = XPPenProductResource::collection(
            XpPenProduct::with('category', 'series', 'images')
                    ->whereIn('id', $wishlistXpPenProductIds)->get());

        $solarProducts = SolarProductResource::collection(
            SolarProduct::with('category',  'images', 'attributes', 'variations')
                ->whereIn('id', $wishlistSolarProductIds)
                ->get()
            );

        $allWishlists = collect()
            ->merge($products)
            ->merge($xpPenProducts)
            ->merge($solarProducts)
            ->merge($adremerProducts)
            ->values(); // Reset keys

        return response()->json([
            'ok' => true,
            'wishlists' => $allWishlists,
        ]);
    }

    public function removeFromWishlist($product_id, $product_type) {
        $user = auth()->user();

        $productModel = match ($product_type) {
            'normal'   => Product::class,
            'solar'    => SolarProduct::class,
            'xp_pen'   => XpPenProduct::class,
            'adreamer' => AdreamerProduct::class,
            default    => throw new \InvalidArgumentException("Invalid product type"),
        };

        Whishlist::where('product_id', $product_id)->where('product_type', $productModel)->where('user_id', $user->id)->delete();

        $wishlistProductIds = Whishlist::where('user_id', $user->id)
            ->where('product_type', Product::class)
            ->pluck('product_id');

        $wishlistXpPenProductIds = Whishlist::where('user_id', $user->id)
            ->where('product_type', XpPenProduct::class)
            ->pluck('product_id');

        $wishlistAdreamerProductIds = Whishlist::where('user_id', $user->id)
            ->where('product_type', AdreamerProduct::class)
            ->pluck('product_id');

        $wishlistSolarProductIds = Whishlist::where('user_id', $user->id)
            ->where('product_type', SolarProduct::class)
            ->pluck('product_id');

        $products = ProductResource::collection(
            Product::with('category', 'series', 'brand', 'images', 'attributes', 'variations')
                ->whereIn('id', $wishlistProductIds)
                ->get()
        );

        $adremerProducts = AdreamerProductResource::collection(
            AdreamerProduct::with('category',  'images', 'attributes', 'variations')
                ->whereIn('id', $wishlistAdreamerProductIds)
                ->get()
        );

        $xpPenProducts = XPPenProductResource::collection(
            XpPenProduct::with('category', 'series', 'images')
                    ->whereIn('id', $wishlistXpPenProductIds)->get());

        $solarProducts = SolarProductResource::collection(
            SolarProduct::with('category',  'images', 'attributes', 'variations')
                ->whereIn('id', $wishlistSolarProductIds)
                ->get()
            );

        $allWishlists = collect()
            ->merge($products)
            ->merge($xpPenProducts)
            ->merge($solarProducts)
            ->merge($adremerProducts)
            ->values(); // Reset keys

        return response()->json([
            'ok' => true,
            'wishlists' => $allWishlists,
        ]);
    }
}
