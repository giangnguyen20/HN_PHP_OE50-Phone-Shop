<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Products\UpdateProductRequest;
use App\Repositories\Category\CategoryRepositoryInterface;
use App\Repositories\Image\ImageRepositoryInterface;
use App\Repositories\Product\ProductRepositoryInterface;

class ProductController extends Controller
{
    protected $productRepo;
    protected $categoryRepo;
    protected $imageRepo;
    
    public function __construct(
        ProductRepositoryInterface $productRepo,
        CategoryRepositoryInterface $categoryRepo,
        ImageRepositoryInterface $imageRepo
    ) {
        $this->productRepo = $productRepo;
        $this->categoryRepo = $categoryRepo;
        $this->imageRepo = $imageRepo;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = $this->productRepo->getProductWithImages();

        return view('admin.product.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = $this->categoryRepo->getAll();

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
            $this->productRepo->create([
                'name' => $request->name,
                'slug' => slugHelper($request->name),
                'price' => $request->price,
                'description' => $request->description,
                'accessories' => $request->accessories,
                'warranty' => $request->warranty,
                'quantity' => $request->quantity,
                'color' => $request->color,
                'category_id' => $request->category_id,
            ]);

            $product = $this->productRepo->getProductByName($request->name);

            foreach ($files as $key => $file) {
                $imageName = slugHelper($product->name) . '-' . time() . '.' . $file->extension();
                $file->move(public_path('images'), $imageName);
                $data[$key] = [
                    'product_id' => $product->id,
                    'name' => $imageName,
                ];
            }

            $this->imageRepo->insertImage($data);
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
        $product = $this->productRepo->getProductById($id);
        $categories = $this->categoryRepo->getAll();

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
        $product = $this->productRepo->getProductById($id);
        $product->update([
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
        if ($request->hasFile("images")) {
            foreach ($files as $key => $file) {
                $imageName = slugHelper($product->name) . '-' . time() . '.' . $file->extension();
                $file->move(public_path('images'), $imageName);
                $data[$key] = [
                    'product_id' => $product->id,
                    'name' => $imageName,
                ];
            }

            $this->imageRepo->insertImage($data);
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
        $product = $this->productRepo->getProductById($id);
        $product->delete();

        return redirect()->route('admin.products.index')->with('messages', __('delete_success'));
    }
}
