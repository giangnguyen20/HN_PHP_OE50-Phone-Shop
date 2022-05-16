<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Products\CommentRequest;

class UserProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::all();
        $products = Product::with('images')
            ->select('products.*')
            ->orderBy('created_at', 'ASC')
            ->paginate(config('product.limit'));

        return view('user.products.index', compact('categories', 'products'));
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
        $categories = Category::all();
        $product = Product::with('images')->where('products.id', "=", $id)->first();
        $comments = Comment::with('user')
            ->where('product_id', $id)
            ->orderBy('created_at', 'DESC')
            ->paginate(config('auth.comment_page'));

        return view('user.products.details', compact('categories', 'product', 'comments'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
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

    public function showByCategory(Request $request)
    {
        $categories = Category::all();
        $products = Product::with('images')
            ->select('products.*')
            ->where('products.category_id', "=", $request->id)
            ->orderBy('created_at', 'ASC')
            ->paginate(config('product.limit'));

        return view('user.products.productbycategory', compact('products', 'categories'));
    }

    public function search(Request $request)
    {
        $categories = Category::all();
        $products = Product::where('name', 'like', '%'.$request->key.'%')
            ->paginate(config('product.limit'))
            ->withQueryString();
        $key_search = $request->key;

        return view('user.products.search', compact('categories', 'products', 'key_search'));
    }
    
    public function comment(CommentRequest $request)
    {
        Comment::create([
            'user_id' => Auth::user()->id,
            'product_id' => $request->product_id,
            'content' => $request->content,
        ]);

        return redirect()->back();
    }
}
