<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Admin\UserRequest;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $list = DB::table('users')
            ->select('id', 'fullname', 'username', 'email', 'address', 'phone', 'image', 'status')
            ->where('status', 1)
            ->orderBy('id')
            ->get();

        $trashCount = User::onlyTrashed()->count();

        return view('admin.users.index', compact('list', 'trashCount'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::select('id', 'fullname')->get();

        return view('admin.users.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {
        try {
            User::create([
                'fullname' => $request->fullname,
                'username' => $request->username,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'phone' => $request->phone,
                'address' => $request->address,
                'gender' => $request->gender,
                'birthday' => $request->birthday,
                'role' => $request->role ?? '2',
                'status' => $request->status
            ]);
            return redirect()
                ->route('admin.users.index')
                ->with('success', 'Thêm người dùng thành công');
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
        return "Hien thi chi tiet nguoi dung";
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::find($id);
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request, string $id)
    {
        try {
            $user = User::find($id);

            if (!$user) {
                return redirect()
                    ->route('admin.users.index')
                    ->with('error', 'Người dùng không tồn tại');
            }

            $user->update([
                'fullname' => $request->fullname,
                'username' => $request->username,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address,
                'gender' => $request->gender,
                'birthday' => $request->birthday,
                'role' => $request->role,
                'status' => $request->status
            ]);


            // Để trống mật khẩu ➜ giữ nguyên mật khẩu cũ.
            // Nhập mật khẩu mới ➜ cập nhật mật khẩu mới đã được mã hóa.
            if (!empty($request->password)) {
                $user['password'] = Hash::make($request->password);
            }

            return redirect()
                ->route('admin.users.index')
                ->with('success', 'Cập nhật người dùng thành công');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            User::findOrFail($id)->delete();

            return redirect()
                ->route('admin.users.index')
                ->with('success', 'Xóa người dùng thành công.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Thực hiện thất bại.');
        }
    }

    public function trash($limit = 10)
    {
        $list = User::onlyTrashed()
            ->select('id', 'fullname', 'username', 'email', 'phone', 'role', 'status', 'deleted_at')
            ->orderBy('deleted_at', 'desc')
            ->paginate($limit);
        $trashCount = User::onlyTrashed()->count();

        return view('admin.users.trash', compact('list', 'trashCount'));
    }

    public function restore($id)
    {
        try {
            User::onlyTrashed()->findOrFail($id)->restore();

            return redirect()
                ->route('admin.users.trash')
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
            User::onlyTrashed()->findOrFail($id)->forceDelete();

            return redirect()
                ->route('admin.users.trash')
                ->with('success', 'Xóa vĩnh viễn thành công.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Xóa thất bại.');
        }
    }

    public function restoreAll()
    {
        User::onlyTrashed()->restore();

        return redirect()
            ->route('admin.users.trash')
            ->with('success', 'Khôi phục tất cả thành công.');
    }

    public function forceDeleteAll()
    {
        User::onlyTrashed()->forceDelete();

        return redirect()
            ->route('admin.users.trash')
            ->with('success', 'Xóa vĩnh viễn tất cả thành công.');
    }
}
