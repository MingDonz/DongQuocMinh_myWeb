<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
// use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Brand;
use App\Http\Requests\Admin\BrandRequest;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $list = DB::table('brands')
            ->select('id', 'brandname', 'slug', 'image', 'status')
            ->where('status', 1)
            ->orderBy('brandname')
            ->get();
        $trashCount = Brand::onlyTrashed()->count();
        return view('admin.brands.index', compact('list', 'trashCount'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('admin.brands.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BrandRequest $request)
    {
        //
        try {
            // upload hình ảnh (nếu có)
            $fileName = null;
            if ($request->hasFile('img')) {
                $file = $request->file('img');
                $fileName = Str::slug($request->brandname)
                    . '-' . time()
                    . '.' . $file->extension();
                // hình ảnh được lưu vào thư mục storage/app/public/brands
                $file->storeAs('brands', $fileName, 'public');
            }
            Brand::create([
                'brandname'   => $request->brandname,
                'slug'        => $request->slug,
                'status'      => $request->status,
                'description' => $request->description,
                'image' => $fileName
            ]);

            return redirect()
                ->route('admin.brands.index')
                ->with('success', 'Thêm thành công.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Thêm thất bại.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $brand = Brand::findOrFail($id);
        $brands = Brand::select('id', 'brandname')->get();

        return view('admin.brands.edit', compact('brand', 'brands'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BrandRequest $request, string $id)
    {
        try {
            // Tìm brand theo id
            $brand = Brand::findOrFail($id);
            // Có chọn hình ảnh mới
            // Giữ tên hình ảnh cũ
            $fileName = $brand->image;
            if ($request->hasFile('img')) {
                // Xóa hình ảnh cũ
                if ($fileName) {
                    Storage::disk('public')->delete('brands/' . $brand->image);
                }
                // Upload hình ảnh mới
                $file = $request->file('img');
                $fileName = Str::slug($request->brandname)

                    . '-' . time()
                    . '.' . $file->extension();
                $file->storeAs('brands', $fileName, 'public');
            }
            $brand->update([
                'brandname' => $request->brandname,
                'slug' => $request->slug,
                'status' => $request->status,
                'description' => $request->description,
                'image' => $fileName,
            ]);
            return redirect()
                ->route('admin.brands.index')
                ->with('success', 'Cập nhật thành công.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Cập nhật thất bại.');
        }
    }

    public function destroy(string $id)
    {
        try {
            Brand::findOrFail($id)->delete();

            return redirect()
                ->route('admin.brands.index')
                ->with('success', 'Xóa thương hiệu thành công.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Thực hiện thất bại.');
        }
    }

    public function trash($limit = 10)
    {
        $list = Brand::onlyTrashed()
            ->select('id', 'brandname', 'slug', 'image', 'status', 'deleted_at')
            ->orderBy('deleted_at', 'desc')
            ->paginate($limit);
        $trashCount = Brand::onlyTrashed()->count();

        return view('admin.brands.trash', compact('list', 'trashCount'));
    }

    public function restore($id)
    {
        try {
            Brand::onlyTrashed()->findOrFail($id)->restore();

            return redirect()
                ->route('admin.brands.trash')
                ->with('success', 'Khôi phục thành công.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Khôi phục thất bại.');
        }
    }

    public function forceDelete($id)
    {
        try {
            Brand::onlyTrashed()->findOrFail($id)->forceDelete();

            return redirect()
                ->route('admin.brands.trash')
                ->with('success', 'Xóa vĩnh viễn thành công.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Xóa thất bại.');
        }
    }

    public function restoreAll()
    {
        Brand::onlyTrashed()->restore();

        return redirect()
            ->route('admin.brands.trash')
            ->with('success', 'Khôi phục tất cả thành công.');
    }

    public function forceDeleteAll()
    {
        Brand::onlyTrashed()->forceDelete();

        return redirect()
            ->route('admin.brands.trash')
            ->with('success', 'Xóa vĩnh viễn tất cả thành công.');
    }
}
