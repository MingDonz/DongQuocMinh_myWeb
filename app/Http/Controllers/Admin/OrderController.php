<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with(['customer', 'items.product'])->latest();

        if ($request->filled('search')) {
            $search = trim($request->input('search'));
            $query->whereHas('customer', function ($q) use ($search) {
                $q->where('fullname', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            })
                ->orWhere('order_code', 'like', "%{$search}%")
                ->orWhere('status', 'like', "%{$search}%");
        }

        $orders = $query->paginate(10)->appends($request->only('search'));

        $totalOrders = Order::count();
        $totalRevenue = Order::sum('total_amount');

        return view('admin.orders.index', compact('orders', 'totalOrders', 'totalRevenue'));
    }

    public function show(Order $order)
    {
        $order->load(['customer', 'items.product']);

        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,completed,cancelled',
        ]);

        $order->update([
            'status' => $request->input('status'),
        ]);

        return redirect()->route('admin.orders.show', $order->id)->with('success', 'Cập nhật trạng thái đơn hàng thành công.');
    }
}
