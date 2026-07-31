@extends('admin.layouts.admin')

@section('title', 'Danh sách đơn hàng')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0">Danh sách đơn hàng</h2>
        </div>

        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <div class="text-muted">Tổng số đơn hàng</div>
                        <h4 class="mb-0">{{ $totalOrders }}</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <div class="text-muted">Tổng doanh thu</div>
                        <h4 class="mb-0">{{ number_format($totalRevenue, 0, ',', '.') }} đ</h4>
                    </div>
                </div>
            </div>
        </div>

        <form method="GET" class="row g-2 mb-3">
            <div class="col-md-6">
                <input type="text" name="search" class="form-control"
                    placeholder="Tìm theo mã đơn, khách hàng, số điện thoại..." value="{{ request('search') }}">
            </div>
            <div class="col-md-2">
                <button class="btn btn-primary w-100">Tìm kiếm</button>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Mã đơn</th>
                        <th>Khách hàng</th>
                        <th>Số điện thoại</th>
                        <th>Tổng tiền</th>
                        <th>Trạng thái</th>
                        <th>Ngày đặt</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($orders as $order)
                        <tr>
                            <td>{{ $order->id }}</td>
                            <td>{{ $order->order_code }}</td>
                            <td>{{ $order->customer->fullname ?? '' }}</td>
                            <td>{{ $order->customer->phone ?? '' }}</td>
                            <td>{{ number_format($order->total_amount, 0, ',', '.') }} đ</td>
                            <td>
                                <span class="badge bg-info text-dark">{{ $order->status }}</span>
                            </td>
                            <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                            <td>
                                <a href="{{ route('admin.orders.show', $order->id) }}"
                                    class="btn btn-sm btn-outline-primary">Xem</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted">Không có đơn hàng nào.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-center">
            {{ $orders->links() }}
        </div>
    </div>
@endsection