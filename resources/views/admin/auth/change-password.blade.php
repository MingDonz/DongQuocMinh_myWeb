@extends('admin.layouts.admin')

@section('title', 'Đổi mật khẩu')

@section('content')
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Đổi mật khẩu</h5>
                    </div>
                    <div class="card-body">
                        <x-admin.alert />

                        <div class="mb-3">
                            <label class="form-label">Thông tin người đăng nhập</label>
                            <div class="border rounded p-3 bg-light">
                                <div><strong>Họ tên:</strong> {{ Auth::user()->fullname }}</div>
                                <div><strong>Username:</strong> {{ Auth::user()->username }}</div>
                                <div><strong>Email:</strong> {{ Auth::user()->email }}</div>
                            </div>
                        </div>

                        <form action="{{ route('admin.change-password.post') }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label for="current_password" class="form-label">Mật khẩu cũ</label>
                                <input type="password" class="form-control" id="current_password" name="current_password"
                                    placeholder="Nhập mật khẩu cũ">
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Mật khẩu mới</label>
                                <input type="password" class="form-control" id="password" name="password"
                                    placeholder="Nhập mật khẩu mới">
                            </div>

                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label">Xác nhận mật khẩu mới</label>
                                <input type="password" class="form-control" id="password_confirmation"
                                    name="password_confirmation" placeholder="Nhập lại mật khẩu mới">
                            </div>

                            <button type="submit" class="btn btn-primary w-100">Cập nhật mật khẩu</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection