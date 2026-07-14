<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    // Hiển thị trang đăng nhập
    public function login(Request $request)
    {
        // validate - kiểm tra dữ liệu đầu vào
        // bổ sung thêm một số ràng buộc khác - nếu có
        $request->validate(
            [
                'username' => 'required',
                'password' => 'required',
            ],
            [
                'required' => ':attribute không được để trống',
            ],
            [
                'username' => 'Tên đăng nhập',
                'password' => 'Mật khẩu',
            ]
        );
        // first(): lấy ra record đầu tiên khi truy vấn dữ liệu
        $user = User::where('username', $request->username)->first();
        // Nếu không tìm thấy người dùng trong bảng users
        if (!$user) {
            return back()
                ->with('message', 'Username không tồn tại')
                ->withInput();
        }
        // Nếu tìm thấy người dùng thì kiểm tra mật khẩu
        // do mật khẩu dùng Hash::make() để mã hóa, nên cần so sánh phải dùng với hàm Hash::check()
        $check = Hash::check($request->password, $user->password); // true hoặc false
        // trường hợp mật khẩu không khớp
        if (!$check) {
            // điều hướng về trước (login) với session flash 'message'
            return back()->with('message', 'Mật khẩu không đúng')->withInput();
        }
        // Nếu biến $remember có giá trị true (nếu người dùng chọn nhớ tài khoản)
        $remember = $request->has('remember') ? true : false;
        Auth::login($user, $remember);
        // sử dụng intended để điều hướng về URL mà người dùng muốn truy cập
        // nếu không có thì điều hướng về dasboard (route name dashboard được khai báo trong web.php)

        if (Auth::check()) {
            return redirect()->route('admin.dashboard');
        }

        return redirect()->intended(route('admin.dashboard'));
    }
    // Xử lý đăng nhập
    public function postLogin(Request $request) {}
    // Đăng xuất
    public function logout(Request $request)
    {
        // Đăng xuất user
        Auth::logout();
        // Xóa session hiện tại
        $request->session()->invalidate();
        // Tạo lại CSRF token mới
        $request->session()->regenerateToken();
        // Redirect về trang login
        return redirect()->route('admin.login');
    }
    // Hiển thị trang Quên mật khẩu
    public function forgotPassword()
    {
        return view('admin.users.forgotpassword');
    }
    // Xử lý quên mật khẩu
    public function postForgotpassword(Request $request) {}
}
