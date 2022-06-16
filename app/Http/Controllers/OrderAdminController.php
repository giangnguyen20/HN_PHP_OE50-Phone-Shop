<?php

namespace App\Http\Controllers;

use Exception;
use Pusher\Pusher;
use App\Models\User;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Events\OrderNotificationsEvent;
use App\Notifications\OrderNotifications;
use App\Repositories\Order\OrderRepositoryInterface;

class OrderAdminController extends Controller
{
    protected $orderRepo;

    public function __construct(OrderRepositoryInterface $orderRepo)
    {
        $this->orderRepo = $orderRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::with('user')
            ->select('orders.*')
            ->orderBy('created_at', 'desc')
            ->paginate(config('product.PAGINATION_NUMBER'));

        return view('admin.order.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $order = Order::findOrFail($id);
        $user = User::findOrFail($order->user_id);
        $order_product = $order->products;

        return view('admin.order.edit', compact('order_product', 'user', 'order'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $order->status = $request->status;
        $order->save();

        $data = [
            'id' => $order->id,
            'status' => $order->status,
        ];

        $user = $order->user;
        $user->notify(new OrderNotifications($data));
        $notification_id = $user->notifications->first()->id;
        $data['notification_id'] = $notification_id;

        $options = [
            'cluster' => 'ap1',
            'encrypted' => true,
        ];

        $pusher = new Pusher(
            env('PUSHER_APP_KEY'),
            env('PUSHER_APP_SECRET'),
            env('PUSHER_APP_ID'),
            $options
        );

        $pusher->trigger('channel-notificationstatus-'.$user->id, 'notificationstatus-event', $data);

        return redirect()->route('admin.orders.edit', $id)->with('messages', __('update_success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function readNotification($id)
    {
        try {
            Auth::user()->Notifications->find($id)->markAsRead();
            $order_id = Auth::user()->Notifications->find($id)->data['id'];
        } catch (\Exception $e) {
            return response()->json([
                'mess' => $e,
            ], 404);
        }

        $order = Order::findOrFail($order_id);
        $user = User::findOrFail($order->user_id);
        $order_product = $order->products;
        
        return view('user.cart.order_detail', compact('order', 'user', 'order_product'));
    }

    public function readAllNotification()
    {
        try {
            Auth::user()->Notifications->markAsRead();
        } catch (\Throwable $e) {
            return response()->json([
                'mess' => 'fail',
            ], 500);
        }
        return redirect()->back();
    }
}
