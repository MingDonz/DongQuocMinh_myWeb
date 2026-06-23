<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Category;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($limit = 10)
    {
        // $list = DB::table('categories')
        //     ->select('cateid', 'catename', 'slug', 'image', 'status')
        //     ->where('status', 1)
        //     ->orderBy('catename')
        //     ->get();


        //---ORM
        $list = Category::select('cateid', 'catename', 'slug', 'image', 'status')
            ->orderBy('catename')
            ->paginate($limit);

        return view('admin.categories.index', compact('list'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('admin.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(
            // Parram 1: Rules - khai báo các quy tắc kiểm tra dữ liệu
            [
                'catename' => 'required|min:3|max:100|unique:categories,catename',
                'slug' => [
                    'required',
                    'min:5',
                    'max:150',
                    'unique:categories,slug',
                    'regex:/^[a-z0-9-]+$/'
                ],
                'status' => 'required|in:0,1'
            ],
            // Parram 2: Messages - tùy chỉnh nội dung thông báo lỗi.
            [
                'required' => ':attribute không được để trống.',
                'min' => ':attribute phải từ :min ký tự trở lên.',
                'max' => ':attribute không vượt quá :max ký tự.',
                'unique' => ':attribute đã tồn tại.',
                'slug.regex' => ':attribute chỉ được chứa chữ thường, số và dấu gạch ngang (-).',
                'status.in' => ':attribute không hợp lệ.'
            ],
            // Parram 3: Attributes- tên hiển thị của các trường
            [
                'catename' => 'Tên loại',
                'slug' => 'Đường dẫn (Slug)',
                'status' => 'Trạng thái'
            ]
        );

        try {

            Category::create([
                'catename' => $request->catename,
                'slug' => $request->slug,
                'status' => $request->status
            ]);

            return redirect()->route('admin.categories.index')
                ->with('success', 'Thêm loại sản phẩm thành công');
        } catch (\Exception $e) {

            return back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        return "nội dung tùy ý";
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        return "nội dung tùy ý";
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $request->validate(
            // Parram 1: Rules - khai báo các quy tắc kiểm tra dữ liệu
            [
                'catename' => 'required|min:3|max:100|unique:categories,catename,' . $id . ',cateid',
                'slug' => [
                    'required',
                    'min:5',
                    'max:150',
                    'unique:categories,slug',
                    'regex:/^[a-z0-9-]+$/',
                    Rule::unique('categories', 'slug')->ignore($id, 'cateid'),
                ],
                'status' => 'required|in:0,1'
            ],
            // Parram 2: Messages - tùy chỉnh nội dung thông báo lỗi.
            [
                'required' => ':attribute không được để trống.',
                'min' => ':attribute phải từ :min ký tự trở lên.',
                'max' => ':attribute không vượt quá :max ký tự.',
                'unique' => ':attribute đã tồn tại.',
                'slug.regex' => ':attribute chỉ được chứa chữ thường, số và dấu gạch ngang (-).',
                'status.in' => ':attribute không hợp lệ.'
            ],
            // Parram 3: Attributes- tên hiển thị của các trường
            [
                'catename' => 'Tên loại',
                'slug' => 'Đường dẫn (Slug)',
                'status' => 'Trạng thái'
            ]
        );

        try {
            // Tìm category theo id
            $category = Category::findOrFail($id);
            // Cập nhật dữ liệu
            $category->update([
                'catename'    => $request->catename,
                'slug'        => $request->slug,
                'status'      => $request->status,
                'description' => $request->description,
            ]);

            return redirect()
                ->route('admin.categories.index')
                ->with('success', 'Cập nhật thành công.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Cập nhật thất bại.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DB::table('categories')->delete($id);
        return redirect()->route('admin.categories.index');
    }
}
