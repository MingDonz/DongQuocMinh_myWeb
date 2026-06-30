<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    //     Tên sản phẩm và slug không được trùng
    // o 
    // o Kiểm tra status chỉ nhận các giá trị hợp lệ (0, 1)
    // o Kiểm tra cateid phải tồn tại trong bảng categories bằng rule exists
    // o Kiểm tra brandid phải tồn tại trong bảng categories bằng rule exists
    // o Kiểm tra trường description không được chứa các ký tự đặc biệt như: @, !, $, ^
    public function rules(): array
    {
        // lấy giá trị tham số id từ URL hiện tại
        $id = $this->route('id');
        return [
            // Tên sản phẩm: bắt buộc, kiểu chuỗi, từ 5 đến X ký tự, không được trùng (bảng products)
            'productname' => [
                'required',
                'string',
                'min:5',
                'max:255',
                'unique:products,productname'
            ],

            // Slug: bắt buộc, kiểu chuỗi, từ 5 đến X ký tự, chỉ chứa chữ, số, dấu _, dấu -, không được trùng
            'slug' => [
                'required',
                'string',
                'min:5',
                'max:255',
                'regex:/^[a-zA-Z0-9_-]+$/',
                'unique:products,slug'
            ],

            // Giá: Bắt buộc, kiểu số, lớn hơn hoặc bằng 0 và nhỏ hơn 10.000.000
            'price' => [
                'required',
                'numeric',
                'min:0',
                'max:9999999'
            ],

            // Kiểm tra sale_price: là số, lớn hơn hoặc bằng 0 và không được lớn hơn price
            'sale_price' => [
                'required', // hoặc 'required' tùy thuộc form của bạn có bắt buộc nhập không
                'numeric',
                'min:0',
                'lte:price' // lte = Less Than or Equal (nhỏ hơn hoặc bằng trường price)
            ],

            // Kiểm tra status: chỉ nhận các giá trị hợp lệ (0, 1)
            'status' => [
                'required',
                'in:0,1'
            ],

            // Kiểm tra cateid: phải tồn tại trong bảng categories bằng rule exists
            'cateid' => [
                'required',
                'exists:categories,id' // giả định khóa chính của bảng categories là id
            ],

            // Kiểm tra brandid: phải tồn tại trong bảng categories bằng rule exists (theo đúng yêu cầu trong ảnh)
            'brandid' => [
                'nullable',
                'exists:categories,id' // Lưu ý: Ảnh yêu cầu tồn tại trong bảng 'categories' thay vì 'brands'
            ],

            // Kiểm tra trường description: không được chứa các ký tự đặc biệt như: @, !, $, ^
            'description' => [
                'nullable',
                'string',
                'not_regex:/[@!$^]/' // Không cho phép xuất hiện bất kỳ ký tự nào trong nhóm này
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'required' => ':attribute không được để trống.',
            'min' => ':attribute phải từ :min ký tự trở lên.',
            'max' => ':attribute không vượt quá :max ký tự.',
            'productname.unique' => ':attribute đã tồn tại.',
            'slug.regex' => ':attribute bắt buộc, kiểu chuỗi, từ 5 đến X ký tự, chỉ chứa chữ, số, dấu _, dấu - .',
            'status.in' => ':attribute không hợp lệ.',
            'productname' => ':attribute từ 5 đến 255 ký tự, không được trùng.',
            'price' => ':attribute là số, lớn hơn hoặc bằng 0 và nhỏ hơn 10.000.000.',
            'sale_price' => ':attribute là số, lớn hơn hoặc bằng 0 và không được lớn hơn giá gốc.',
            'description.not_regex' => ':attribute không được chứa các ký tự đặc biệt như: @, !, $, ^.',
            'cateid' => ':attribute không được để trống.',
        ];
    }

    public function attributes(): array
    {
        return [
            'productname' => 'Tên sản phẩm',
            'slug' => 'Đường dẫn (Slug)',
            'status' => 'Trạng thái',
            'price' => 'Giá gốc',
            'sale_price' => 'Giá đã giảm',
            'description' => 'Mô tả sản phẩm',
            'cateid' => 'Danh mục sản phẩm'
        ];
    }
}
