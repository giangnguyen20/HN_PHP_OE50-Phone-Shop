<?php

namespace App\Http\Controllers;

use Cart;
use App\Models\Image;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Requests\Cart\AddToCartRequest;
use App\Http\Requests\Cart\UpdateCartRequest;

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

    public function updateCart(UpdateCartRequest $request)
    {
        foreach ($request->rowId as $key => $item) {
            Cart::update($item, $request->qty[$key]);
        }

        return redirect()->back()->with('message', 'update_success');
    }

    public function delete($id)
    {
        Cart::remove($id);

        return redirect()->back()->with('message', 'delete_success');
    }
}
