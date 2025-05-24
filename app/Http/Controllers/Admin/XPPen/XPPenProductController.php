<?php

namespace App\Http\Controllers\Admin\XPPen;

use DataTables;
use App\Models\XpPenImage;
use App\Models\XpPenSeries;
use Illuminate\Support\Str;
use App\Models\XpPenProduct;
use Illuminate\Http\Request;
use App\Models\XpPenCategory;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class XPPenProductController extends Controller
{
    public function index()
    {
        return view('admin.xp_pen.products.index');
    }

    public function productLists()
    {
        $data = XpPenProduct::with(['series', 'category', 'images'])->latest();

        return Datatables::of($data)
            ->editColumn('plus-icon', function ($each) {
                return null;
            })
            ->addIndexColumn()

            ->editColumn('series_id', function ($each) {
                return $each->series->name ?? '';
            })

            ->filterColumn('series_id', function($query, $keyword) {
                $query->whereHas('series', function ($q) use ($keyword) {
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
                $bg = $each->qty > 0 ? 'bg-info' : ($each->qty == 0 ? 'bg-warning' : 'bg-danger');
                return "<span class='$bg py-1 px-2 text-white fw-bold rounded'>$each->qty</span>";
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
                    $show_icon = '<a href="' . route('admin.xppen-products.show', $each->id) . '" class="text-warning me-3"><i class="bx bxs-show fs-4"></i></a>';
                // }

                // if (auth()->user()->can('brand_edit')) {
                    $edit_icon = '<a href="' . route('admin.xppen-products.edit', $each->id) . '" class="text-info me-3"><i class="bx bx-edit fs-4" ></i></a>';
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
        $categories = XpPenCategory::select('id', 'name')->get();
        $series = XpPenSeries::select('id', 'name')->get();

        return view('admin.xp_pen.products.create', compact('categories', 'series'));
    }

    public function store(Request $request) {

        DB::beginTransaction();

        try {
            $xppen_product = new XpPenProduct();
            $xppen_product->name = $request->name;
            $xppen_product->sku = $this->generateSku();
            $xppen_product->category_id = $request->category_id;
            $xppen_product->series_id = $request->series_id;
            $xppen_product->description = $request->description;
            $xppen_product->specification = $request->specification;
            $xppen_product->price_mmk = $request->price_mmk;
            $xppen_product->price_us = $request->price_usd;
            $xppen_product->qty = $request->qty;
            $xppen_product->save();

            if(!empty($request->images) && is_array($request->images)) {
                foreach ($request->input('images', []) as $image) {

                    $sourcePath = storage_path('tmp/uploads/' . $image);
                    $destinationPath = public_path('storage/images/xppen/' . $image);

                    if (file_exists($sourcePath)) {

                        \File::move($sourcePath, $destinationPath);

                        $productImage = new XpPenImage();
                        $productImage->image = '/images/xppen/' . $image;
                        $productImage->xp_pen_product_id = $xppen_product->id;
                        $productImage->save();
                    }
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

    public function show(XpPenProduct $xppen_product) {
        $xppen_product = $xppen_product->load('category', 'series', 'images');

        return view('admin.xp_pen.products.show', compact('xppen_product'));
    }

    public function edit(XpPenProduct $xppen_product) {
        $categories = XpPenCategory::select('id', 'name')->get();
        $series = XpPenSeries::select('id', 'name')->get();

        $product_images = array_map(function ($image) {
            return [
                'image_name' => $image['image'],
                'image_path' => asset('storage/' . $image['image']),
            ];
        }, $xppen_product->images->toArray());

        return view('admin.xp_pen.products.edit', compact('xppen_product', 'categories', 'series', 'product_images'));
    }

    public function updateProduct(Request $request, XpPenProduct $xppen_product) {

        DB::beginTransaction();

        try {
            $xppen_product->name = $request->name;
            $xppen_product->category_id = $request->category_id;
            $xppen_product->series_id = $request->series_id;
            $xppen_product->description = $request->description;
            $xppen_product->specification = $request->specification;
            $xppen_product->price_mmk = $request->price_mmk;
            $xppen_product->price_us = $request->price_usd;
            $xppen_product->qty = $request->qty;
            $xppen_product->update();

            if (count($xppen_product->images) > 0) {
                foreach ($xppen_product->images as $media) {

                    $imagePath = '/'.ltrim($media->image, '/');  // change image format to match input images

                    if (!in_array($imagePath, $request->input('images', []))) {
                        XpPenImage::where('id', $media->id)->delete();
                        \File::delete(public_path('/storage'.$imagePath));
                    }
                }
            }

            $old_images = $xppen_product->images()->pluck('image')->toArray();

            foreach ($request->input('images', []) as $image) {
                if (count($old_images) === 0 || !in_array($image, $old_images)) {

                    $sourcePath = storage_path('tmp/uploads/' . $image);
                    $destinationPath = public_path('storage/images/xppen/' . $image);

                    if (file_exists($sourcePath)) {

                        \File::move($sourcePath, $destinationPath);

                        $productImage = new XpPenImage();
                        $productImage->image = '/images/xppen/' . $image;
                        $productImage->xp_pen_product_id = $xppen_product->id;
                        $productImage->save();
                    }
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

    public function destroy(XpPenProduct $xppen_product) {
        DB::beginTransaction();
        try {
            foreach ($xppen_product->images as $media) {
                \File::delete(public_path('/storage'.$media->image));
            }
            $xppen_product->images()->delete();
            $xppen_product->delete();
            DB::commit();
            return 'success';
        } catch (\Exception $e) {
            DB::rollBack();
            logger($e->getMessage());
            return 'error';
        }
    }

    protected function generateSku() {
        return  'GLB-XPPEN-' . strtoupper(Str::random(5)) . '-' . now()->timestamp;
    }
}
