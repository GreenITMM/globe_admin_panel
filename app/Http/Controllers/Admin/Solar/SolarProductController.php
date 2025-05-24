<?php

namespace App\Http\Controllers\Admin\Solar;

use App\Models\ProductType;
use Illuminate\Support\Str;
use App\Models\SolarProduct;
use Illuminate\Http\Request;
use App\Models\SolarCategory;
use App\Models\SolarAttribute;
use App\Models\SolarProductImage;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\SolarProductVariation;
use DataTables;

class SolarProductController extends Controller
{
    public function index()
    {
        $attributes = SolarAttribute::with('values')->select('id', 'name')->get();

        return view('admin.solar.product.index', compact('attributes'));
    }

    public function productLists()
    {
        $data = SolarProduct::with(['category'])->latest();

        return Datatables::of($data)
            ->editColumn('plus-icon', function ($each) {
                return null;
            })
            ->addIndexColumn()

            ->editColumn('category_id', function ($each) {
                return $each->category->name ?? '';
            })

            ->filterColumn('category_id', function($query, $keyword) {
                $query->whereHas('category', function ($q) use ($keyword) {
                    $q->where('name', 'like', "%" . $keyword . "%");
                });
            })

            ->editColumn('qty', function($each) {
                if($each->variations && count($each->variations) > 0) {
                    $qty = $each->variations->sum('qty');
                    $bg = $qty > 0 ? 'bg-success' : ($qty == 0 ? 'bg-warning' : 'bg-danger');
                    return "<span class='$bg py-1 px-2 text-white fw-bold rounded'>$qty</span>";
                } else {
                    $bg = $each->qty > 0 ? 'bg-success' : ($each->qty == 0 ? 'bg-warning' : 'bg-danger');
                    return "<span class='$bg py-1 px-2 text-white fw-bold rounded'>$each->qty</span>";
                }
            })

            ->editColumn('images', function($each) {
                $image = '';
                $index = 0;
                foreach ($each->images as $file) {
                    if ($index < 2) {
                        $filePath = asset('storage/' . $file->image );
                        $style = "width: 40px; height: 40px; display: flex; justify-content:center; align-items:center ;border-radius: 100%; object-fit: cover; border: 1px solid #333;";
                        $style .= $index == 0 ? '' : 'margin-left: -15px;';

                        $image .= "<img src='$filePath' width='35' height='35' style='$style'/>";
                    }
                    $index++;
                }

                if ($index > 2) {
                    $index = $index - 2;
                    $image .= "<div style='$style background: #fff;'>+$index</div>";
                }

                return "<div class='d-flex align-items-center'> $image </div>";
            })

            ->addColumn('action', function ($each) {
                $show_icon = '';
                $edit_icon = '';
                $del_icon = '';

                // if (auth()->user()->can('user_show')) {
                    $show_icon = '<a href="' . route('admin.solar-products.show', $each->id) . '" class="text-warning me-3"><i class="bx bxs-show fs-4"></i></a>';
                // }

                // if (auth()->user()->can('brand_edit')) {
                    $edit_icon = '<a href="' . route('admin.solar-products.edit', $each->id) . '" class="text-info me-3"><i class="bx bx-edit fs-4" ></i></a>';
                // }

                // if (auth()->user()->can('brand_delete')) {
                    $del_icon = '<a href="" class="text-danger delete-btn" data-id="' . $each->id . '"><i class="bx bxs-trash-alt fs-4" ></i></a>';
                // }

                return '<div class="action-icon">' . $show_icon . $edit_icon . $del_icon . '</div>';
            })
            ->rawColumns(['images', 'qty', 'action'])
            ->make(true);

    }

    public function create() {
        $parent_categories = SolarCategory::where('parent_id', null)->select('id', 'name')->get();
        $productTypes = ProductType::select('id', 'name')->get();
        $attributes = SolarAttribute::with('values')->select('id', 'name')->get();

        return view('admin.solar.product.create', compact('parent_categories',  'productTypes', 'attributes'));
    }

    public function store(Request $request) {

        DB::beginTransaction();

        try {
            $solarProduct = new SolarProduct();
            $solarProduct->name = $request->name;
            $solarProduct->sku = $this->generateSku();
            $solarProduct->solar_category_id = $request->child_category_id ?? $request->parent_category_id;
            $solarProduct->parent_category_id = $request->parent_category_id;
            $solarProduct->child_category_id = $request->child_category_id;
            $solarProduct->product_type_id = $request->product_type_id;
            $solarProduct->description = $request->description;
            $solarProduct->specification = $request->specification;
            $solarProduct->price_mmk = $request->price_mmk ?? 0;
            $solarProduct->price_us = $request->price_us ?? 0;
            $solarProduct->qty = $request->qty ?? 0;
            $solarProduct->save();

            if(!empty($request->images) && is_array($request->images)) {

                // create folder if not exist
                $path = public_path('storage/images/solar');

                if (!file_exists($path)) {
                    mkdir($path, 0777, true);
                }

                foreach ($request->input('images', []) as $image) {

                    $sourcePath = storage_path('tmp/uploads/' . $image);
                    $destinationPath = public_path('storage/images/solar/' . $image);

                    if (file_exists($sourcePath)) {

                        \File::move($sourcePath, $destinationPath);

                        $solarProductImage = new SolarProductImage();
                        $solarProductImage->image = '/images/solar/' . $image;
                        $solarProductImage->solar_product_id = $solarProduct->id;
                        $solarProductImage->save();
                    }
                }
            }

            if($request->product_type_id && $request->product_type_id == 2) {

                $solarProduct->attributes()->attach($request->input('attributes'));

                foreach ($request->variation as $variation) {
                    $product_variation = new SolarProductVariation();
                    $product_variation->solar_product_id = $solarProduct->id;
                    $product_variation->price_mmk = $variation['price_mmk'];
                    $product_variation->price_us = $variation['price_us'];
                    $product_variation->qty = $variation['qty'] ?? 0;
                    $product_variation->sku = $this->generateSku();
                    $product_variation->attributes = json_encode($variation['attributes']);
                    $product_variation->save();
                }
            }

            DB::commit();
            session()->flash('success', 'Successfully Created !');
            return 'success';

        } catch (\Exception $e) {
            DB::rollBack();
            logger($e->getMessage());
            return $e->getMessage();
        }
    }

    public function show(SolarProduct $solarProduct) {
        $solarProduct = $solarProduct->load('category', 'images');
        return view('admin.solar.product.show', compact('solarProduct'));
    }

    public function edit(SolarProduct $solarProduct) {
        $parent_categories = SolarCategory::where('parent_id', null)->select('id', 'name')->get();
        $child_categories = SolarCategory::where('parent_id', '!=', null)->where('parent_id', $solarProduct->parent_category_id)->select('id', 'name')->get();
        $productTypes = ProductType::select('id', 'name')->get();
        $attributes = SolarAttribute::with('values')->select('id', 'name')->get();

        $product_images = array_map(function ($image) {
            return [
                'image_name' => $image['image'],
                'image_path' => asset('storage/' . $image['image']),
            ];
        }, $solarProduct->images->toArray());

        return view('admin.solar.product.edit', compact('solarProduct',  'parent_categories', 'child_categories', 'productTypes', 'product_images', 'attributes'));
    }

    public function updateProduct(Request $request, SolarProduct $solarProduct) {

        DB::beginTransaction();

        try {
            $solarProduct->name = $request->name;
            $solarProduct->solar_category_id = $request->child_category_id ?? $request->parent_category_id;
            $solarProduct->parent_category_id = $request->parent_category_id;
            $solarProduct->child_category_id = $request->child_category_id;
            $solarProduct->product_type_id = $request->product_type_id ?? $solarProduct->product_type_id;
            $solarProduct->description = $request->description;
            $solarProduct->specification = $request->specification;
            $solarProduct->price_mmk = $request->price_mmk ?? 0;
            $solarProduct->price_us = $request->price_us ?? 0;
            $solarProduct->qty = $request->qty;
            $solarProduct->update();


            if (count($solarProduct->images) > 0) {
                foreach ($solarProduct->images as $media) {

                    $imagePath = '/'.ltrim($media->image, '/');  // change image format to match input images

                    if (!in_array($imagePath, $request->input('images', []))) {
                        SolarProductImage::where('id', $media->id)->delete();
                        \File::delete(public_path('/storage'.$imagePath));
                    }
                }
            }

            $old_images = $solarProduct->images()->pluck('image')->toArray();

            foreach ($request->input('images', []) as $image) {
                if (count($old_images) === 0 || !in_array($image, $old_images)) {

                    $sourcePath = storage_path('tmp/uploads/' . $image);
                    $destinationPath = public_path('storage/images/solar/' . $image);

                    if (file_exists($sourcePath)) {

                        \File::move($sourcePath, $destinationPath);

                        $productImage = new SolarProductImage();
                        $productImage->image = '/images/solar/' . $image;
                        $productImage->solar_product_id = $solarProduct->id;
                        $productImage->save();
                    }
                }
            }

            if($solarProduct->product_type_id == 1) {
                // delete all attributes
                $solarProduct->attributes()->detach();
                $solarProduct->variations()->delete();
            }

            if($solarProduct->product_type_id == 2) {
                $solarProduct->attributes()->detach();
                $solarProduct->variations()->delete();

                $solarProduct->attributes()->attach($request->input('attributes'));
                foreach ($request->variation as $variation) {
                    $product_variation = new SolarProductVariation();
                    $product_variation->solar_product_id = $solarProduct->id;
                    $product_variation->price_mmk = $variation['price_mmk'];
                    $product_variation->price_us = $variation['price_us'];
                    $product_variation->qty = $variation['qty'];
                    $product_variation->sku = $this->generateSku();
                    $product_variation->attributes = json_encode($variation['attributes']);
                    $product_variation->save();
                }
            }

            DB::commit();
            session()->flash('success', 'Successfully Updated !');
            return 'success';

        } catch (\Exception $e) {
            DB::rollBack();
            logger($e->getMessage());
            return $e->getMessage();
        }
    }

    public function destroy(SolarProduct $solarProduct) {
        DB::beginTransaction();
        try {
            foreach ($solarProduct->images as $media) {
                \File::delete(public_path('/storage'.$media->image));
            }
            $solarProduct->images()->delete();

            if($solarProduct->product_type_id == 2) {
                $solarProduct->attributes()->detach();
                $solarProduct->variations()->delete();
            }
            $solarProduct->delete();
            DB::commit();
            return 'success';
        } catch (\Exception $e) {
            DB::rollBack();
            logger($e->getMessage());
            return 'error';
        }
    }

    protected function generateSku() {
        return  'GLB-SLR-' . strtoupper(Str::random(5)) . '-' . now()->timestamp;
    }
}
