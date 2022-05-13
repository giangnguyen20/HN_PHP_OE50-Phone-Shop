<?php

namespace App\Http\Controllers;

use App\Http\Requests\Products\UpdateProductRequest;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Image;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::with('images')
            ->select('products.*')
            ->orderBy('products.created_at', 'DESC')
            ->paginate(config('product.PAGINATION_NUMBER'));

        return view('admin.product.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();

        return view('admin.product.addproduct', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = [];
        $files = $request->file('images');
        if ($request->hasFile("images")) {
            Product::create([
                'name' => $request->name,
                'slug' => slugHelper($request->name),
                'price' => $request->price,
                'description' => $request->description,
                'accessories' => $request->accessories,
                'warranty' => $request->warranty,
                'color' => $request->color,
                'quantity' => $request->quantity,
                'category_id' => $request->category_id,
            ]);

            $product = Product::select('id', 'name')->where('name', '=', $request->name)->first();

            foreach ($files as $key => $file) {
                $imageName = slugHelper($product->name). '-' .time(). '.' .$file->extension();
                $file->move(public_path('images'), $imageName);
                $data[$key] = [
                    'product_id' => $product->id,
                    'name' => $imageName,
                ];
            }

            Image::insert($data);
        }

        return redirect()->back()->with('messages', __('create_success'));
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
        $product = Product::findOrFail($id);
        $categories = Category::all();

        return view('admin.product.editproduct', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProductRequest $request, $id)
    {
        $data = [];
        $files = $request->file('images');
        $product = Product::findOrFail($id);
        $product->update([
            'name' => $request->name,
            'slug' => slugHelper($request->name),
            'price' => $request->price,
            'description' => $request->description,
            'accessories' => $request->accessories,
            'warranty' => $request->warranty,
            'color' => $request->color,
            'status' => $request->status,
            'category_id' => $request->category_id,
        ]);
        if ($request->hasFile("images")) {
            foreach ($files as $key => $file) {
                $imageName = slugHelper($product->name). '-' .time(). '.' .$file->extension();
                $file->move(public_path('images'), $imageName);
                $data[$key] = [
                    'product_id' => $product->id,
                    'name' => $imageName,
                ];
            }

            Image::insert($data);
        }

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
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->route('admin.products.index')->with('message', __('delete_success'));
    }
}
