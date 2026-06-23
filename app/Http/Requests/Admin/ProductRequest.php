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
        //     'productname',
        // 'cateid',
        // 'brandid',
        // 'slug',
        // 'price',
        // 'image',
        // 'status',
        // 'description'
        return [
            'productname' => [
                'required',
                'min:3',
                'max:100',
                Rule::unique('brands', 'brandname')->ignore($id, 'brandid'),
            ],
            'slug' => [
                'required',
                'min:3',
                'max:150',
                Rule::unique('brands', 'slug')
                    ->ignore($id, 'brandid'),
                'regex:/^[a-z0-9-]+$/',
            ],

            // Giá: Bắt buộc, kiểu số, lớn hơn hoặc bằng 0 và nhỏ hơn 10.000.000
            'price' => 'required|between:0,10000000',
            // Kiểm tra sale_price là số, lớn hơn hoặc bằng 0 và không được lớn hơn price
            'status' => 'required|in:0,1',
        ];
    }

    public function messages(): array
    {
        return [
            'required' => ':attribute không được để trống.',
            'min' => ':attribute phải từ :min ký tự trở lên.',
            'max' => ':attribute không vượt quá :max ký tự.',
            'unique' => ':attribute đã tồn tại.',
            'slug.regex' => ':attribute chỉ được chứa chữ thường, số và dấu gạch ngang (-).',
            'status.in' => ':attribute không hợp lệ.',
        ];
    }

    public function attributes(): array
    {
        return [
            'brandname' => 'Tên thương hiệu',
            'slug' => 'Đường dẫn (Slug)',
            'status' => 'Trạng thái',
        ];
    }
}
