<?php

namespace App\Http\Controllers\Admin\ProductManagement;

use App\Models\ProductVariation;
use DataTables;
use App\Models\Brand;
use App\Models\Series;
use App\Models\Product;
use App\Models\Category;
use App\Models\Attribute;
use App\Models\ProductType;
use Illuminate\Support\Str;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    public function index()
    {
        $attributes = Attribute::with('values')->select('id', 'name')->get();

        return view('admin.product_management.product.index', compact('attributes'));
    }

    public function productLists()
    {
        $data = Product::with(['brand', 'category', 'images'])->latest();

        return Datatables::of($data)
            ->editColumn('plus-icon', function ($each) {
                return null;
            })
            ->addIndexColumn()

            ->editColumn('brand_id', function ($each) {
                return $each->brand->name ?? '';
            })

            ->filterColumn('brand_id', function($query, $keyword) {
                $query->whereHas('brand', function ($q) use ($keyword) {
                    $q->where('name', 'like', '%' . $keyword . '%');
                });
            })

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
                    $show_icon = '<a href="' . route('admin.products.show', $each->slug) . '" class="text-warning me-3"><i class="bx bxs-show fs-4"></i></a>';
                // }

                // if (auth()->user()->can('brand_edit')) {
                    $edit_icon = '<a href="' . route('admin.products.edit', $each->slug) . '" class="text-info me-3"><i class="bx bx-edit fs-4" ></i></a>';
                // }

                // if (auth()->user()->can('brand_delete')) {
                    $del_icon = '<a href="" class="text-danger delete-btn" data-slug="' . $each->slug . '"><i class="bx bxs-trash-alt fs-4" ></i></a>';
                // }

                return '<div class="action-icon">' . $show_icon . $edit_icon . $del_icon . '</div>';
            })
            ->rawColumns(['images', 'qty', 'action'])
            ->make(true);

    }

    public function create() {
        $brands = Brand::select('id', 'name')->get();
        $categories = Category::select('id', 'name')->get();
        $productTypes = ProductType::select('id', 'name')->get();
        $attributes = Attribute::with('values')->select('id', 'name')->get();

        return view('admin.product_management.product.create', compact('brands', 'categories', 'productTypes', 'attributes'));
    }

    public function storeMedia(Request $request)
    {
        $path = storage_path('tmp/uploads');

        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }

        $file = $request->file('file');

        $name = uniqid() . '_' . str_replace(' ', '_', trim($file->getClientOriginalName()));
        $file->move($path, $name);

        return response()->json([
            'name' => $name,
            'original_name' => $file->getClientOriginalName(),
        ]);
    }

    /**
     * delete dropzone photos
     */
    public function deleteMedia(Request $request)
    {
        $file = $request->file_name;

        File::delete(storage_path('tmp/uploads/' . $file));

        return 'success';

    }

    public function store(Request $request) {

        DB::beginTransaction();

        try {
            $product = new Product();
            $product->name = $request->name;
            $product->sku = $this->generateSku();
            $product->brand_id = $request->brand_id;
            $product->series_id = $request->series_id;
            $product->category_id = $request->category_id;
            $product->product_type_id = $request->product_type_id;
            $product->description = $request->description;
            $product->specification = $request->specification;
            $product->price_mmk = $request->price_mmk ?? 0;
            $product->price_us = $request->price_us ?? 0;
            $product->qty = $request->qty ?? 0;
            $product->save();

            if(!empty($request->images) && is_array($request->images)) {

                // create folder if not exist
                $path = public_path('storage/images/products');

                if (!file_exists($path)) {
                    mkdir($path, 0777, true);
                }

                foreach ($request->input('images', []) as $image) {

                    $sourcePath = storage_path('tmp/uploads/' . $image);
                    $destinationPath = public_path('storage/images/products/' . $image);

                    if (file_exists($sourcePath)) {

                        File::move($sourcePath, $destinationPath);

                        $productImage = new ProductImage();
                        $productImage->image = '/images/products/' . $image;
                        $productImage->product_id = $product->id;
                        $productImage->save();
                    }
                }
            }

            if($request->product_type_id && $request->product_type_id == 2) {

                $product->attributes()->attach($request->input('attributes'));

                foreach ($request->variation as $variation) {
                    $product_variation = new ProductVariation();
                    $product_variation->product_id = $product->id;
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

    public function show(Product $product) {
        $product = $product->load('category', 'brand', 'images', 'series');
        return view('admin.product_management.product.show', compact('product'));
    }

    public function edit(Product $product) {
        $brands = Brand::select('id', 'name')->get();
        $categories = Category::select('id', 'name')->get();
        $productTypes = ProductType::select('id', 'name')->get();
        $series = Series::select('id', 'name')->get();
        $attributes = Attribute::with('values')->select('id', 'name')->get();


        $product_images = array_map(function ($image) {
            return [
                'image_name' => $image['image'],
                'image_path' => asset('storage/' . $image['image']),
            ];
        }, $product->images->toArray());

        return view('admin.product_management.product.edit', compact('product', 'brands', 'categories', 'productTypes', 'series', 'product_images', 'attributes'));
    }

    public function updateProduct(Request $request, Product $product) {

        DB::beginTransaction();

        try {
            $product->name = $request->name;
            $product->brand_id = $request->brand_id;
            $product->series_id = $request->series_id;
            $product->category_id = $request->category_id;
            $product->product_type_id = $request->product_type_id ?? $product->product_type_id;
            $product->description = $request->description;
            $product->specification = $request->specification;
            $product->price_mmk = $request->price_mmk ?? 0;
            $product->price_us = $request->price_us ?? 0;
            $product->qty = $request->qty;
            $product->update();


            if (count($product->images) > 0) {
                foreach ($product->images as $media) {

                    $imagePath = '/'.ltrim($media->image, '/');  // change image format to match input images

                    if (!in_array($imagePath, $request->input('images', []))) {
                        ProductImage::where('id', $media->id)->delete();
                        File::delete(public_path('/storage'.$imagePath));
                    }
                }
            }

            $old_images = $product->images()->pluck('image')->toArray();

            foreach ($request->input('images', []) as $image) {
                if (count($old_images) === 0 || !in_array($image, $old_images)) {

                    $sourcePath = storage_path('tmp/uploads/' . $image);
                    $destinationPath = public_path('storage/images/products/' . $image);

                    if (file_exists($sourcePath)) {

                        File::move($sourcePath, $destinationPath);

                        $productImage = new ProductImage();
                        $productImage->image = '/images/products/' . $image;
                        $productImage->product_id = $product->id;
                        $productImage->save();
                    }
                }
            }

            if($product->product_type_id == 1) {
                // delete all attributes
                $product->attributes()->detach();
                $product->variations()->delete();
            }

            if($product->product_type_id == 2) {
                $product->attributes()->detach();
                $product->variations()->delete();

                $product->attributes()->attach($request->input('attributes'));
                foreach ($request->variation as $variation) {
                    $product_variation = new ProductVariation();
                    $product_variation->product_id = $product->id;
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

    public function destroy(Product $product) {
        DB::beginTransaction();
        try {
            foreach ($product->images as $media) {
                File::delete(public_path('/storage'.$media->image));
            }
            $product->images()->delete();

            if($product->product_type_id == 2) {
                $product->attributes()->detach();
                $product->variations()->delete();
            }
            $product->delete();
            DB::commit();
            return 'success';
        } catch (\Exception $e) {
            DB::rollBack();
            logger($e->getMessage());
            return 'error';
        }
    }

    protected function generateSku() {
        return  'GLB-' . strtoupper(Str::random(5)) . '-' . now()->timestamp;
    }
}
