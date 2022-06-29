<?php

namespace App\Http\Controllers;

use Pusher\Pusher;
use Illuminate\Http\Request;
use App\Events\NotificationEvent;
use Illuminate\Support\Facades\Auth;
use App\Notifications\OrderNotifications;
use App\Repositories\User\UserRepositoryInterface;
use App\Repositories\Order\OrderRepositoryInterface;

class OrderAdminController extends Controller
{
    protected $orderRepo;
    protected $userRepo;

    public function __construct(
        OrderRepositoryInterface $orderRepo,
        UserRepositoryInterface $userRepo
    ) {
        $this->orderRepo = $orderRepo;
        $this->userRepo = $userRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = $this->orderRepo->getAllWithUsers();

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
        $order = $this->orderRepo->getOrderById($id);
        $user = $this->userRepo->getUser($order->user_id);
        $order_product = $this->orderRepo->getOrderProductByOrderId($order->id);

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
        $attribute = [
            'status' => $request->status,
        ];
        $this->orderRepo->update($id, $attribute);
        $order = $this->orderRepo->getOrderById($id);
        
        $data = [
            'id' => $order->id,
            'status' => $order->status,
        ];
        
        $user =  $this->userRepo->getUser($order->user_id);
        $this->userRepo->setNotification($order->user_id, $data);
        $notification_id = $this->userRepo->getIdNotificationWithUser($order->user_id);
        $data['notification_id'] = $notification_id;

        event(new NotificationEvent($user->id, $data));

        return redirect()->back()->with('messages', __('update_success'));
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
            $this->userRepo->markAsReadtNotificationById($id);
            $order_id = $this->userRepo->getDataNotificationById($id);
        } catch (\Exception $e) {
            return response()->json([
                'mess' => $e,
            ], 404);
        }

        $order = $this->orderRepo->getOrderById($order_id);
        $user = $this->userRepo->getUser($order->user_id);
        $order_product = $this->orderRepo->getOrderProductByOrderId($order->id);
        
        return view('user.cart.order_detail', compact('order', 'user', 'order_product'));
    }

    public function readAllNotification()
    {
        try {
            $this->userRepo->markAsReadtAllNotification();
        } catch (\Throwable $e) {
            return response()->json([
                'mess' => 'fail',
            ], 302);
        }

        return redirect()->back();
    }
}
