<?php

namespace App\Http\Controllers;

use Cart;
use App\Models\Image;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Cart\PaymentRequest;
use App\Http\Requests\Cart\AddToCartRequest;
use App\Http\Requests\Cart\UpdateCartRequest;
use App\Models\Order;

class CartController extends Controller
{
    public function cart()
    {
        $data['cart'] = Cart::content();
        $data['priceTotal'] = Cart::priceTotal();

        return view('user.cart.cart', $data);
    }

    public function addToCart(AddToCartRequest $request)
    {
        $qty = $request->quantity ? $request->quantity : 1;
        $product = Product::findorFail($request->id);
        $image = Image::where('product_id', $request->id)->first();
        if ($product->quantity >= $qty) {
            Cart::add([
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'qty' => $qty,
                'weight' => 0,
                'options' => [
                    'color' => $product->color,
                    'image' => $image->name,
                ],
            ]);

            return redirect()->route('users.cart.showCart');
        }

        return redirect()
            ->back()
            ->with('message', __('The quantity of product :product is only :quantity', [
                'product' => $product->name,
                'quantity' => $product->quantity
            ]));
    }

    public function updateCart(UpdateCartRequest $request)
    {
        foreach ($request->rowId as $key => $item) {
            Cart::update($item, $request->qty[$key]);
        }

        if (!$this->checkout()) {
            return redirect()->back()->with('message', 'update_success');
        }

        return $this->checkout();
    }

    public function delete($id)
    {
        Cart::remove($id);

        return redirect()->back()->with('message', 'delete_success');
    }

    public function payment(PaymentRequest $request)
    {
        if (!$this->checkout()) {
            $total = str_replace(',', '', Cart::priceTotal());
            Order::create([
                'user_id' => Auth::user()->id,
                'phone' => $request->phone,
                'total_price' => $total,
                'address' => $request->address,
                'status' => config('auth.orderStatus.pending'),
                'note' => $request->note,
            ]);

            $order = Order::where('user_id', Auth::user()->id)
                ->orderBy('created_at', 'desc')
                ->first();

            $data = [];
            foreach (Cart::content() as $item) {
                $data[] =  [
                    'product_id' => $item->id,
                    'quantity' => (int)$item->qty,
                ];
            }

            $order->products()->attach($data);

            $products = Product::whereIn('id', $data)->get();

            foreach ($products as $key => $product) {
                $qty = $product->quantity - $data[$key]['quantity'];

                $product->quantity = $qty;
                $product->save();
            }

            return redirect()->route('users.cart.complete', $order->id);
        }

        return $this->checkout();
    }

    public function complete($id)
    {
        $order = Order::findOrFail($id);
        $order_products = $order->products;
        
        Cart::destroy();

        return view('user.cart.paymentsuccess', compact('order_products', 'order'));
    }

    public function checkout()
    {
        $data = [];
        foreach (Cart::content() as $item) {
            $data[] =  [
                'product_id' => $item->id,
                'quantity' => (int)$item->qty,
                'rowId' => $item->rowId,
            ];
        }

        $products = Product::whereIn('id', $data)->get();
        foreach ($products as $key => $item) {
            if ($item->quantity <= $data[$key]['quantity']) {
                if ($item->quantity == $data[$key]['quantity']) {
                    continue;
                }
                Cart::update($data[$key]['rowId'], $item->quantity);

                return redirect()
                    ->back()
                    ->with('error', __('The quantity of product :product is only :quantity', [
                        'product' => $item->name,
                        'quantity' => $item->quantity
                    ]));
            }
        }

        return false;
    }
}
