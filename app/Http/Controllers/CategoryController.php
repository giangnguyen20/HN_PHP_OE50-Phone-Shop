<?php

namespace App\Http\Controllers;

use App\Http\Requests\Category\CreateCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;
use App\Repositories\Category\CategoryRepositoryInterface;

class CategoryController extends Controller
{
    const PAGINATION_NUMBER = 5;
    protected $categoryRepo;

    public function __construct(CategoryRepositoryInterface $categoryRepo)
    {
        $this->categoryRepo = $categoryRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $category =  $this->categoryRepo->getAllCategory();
        
        return view('admin.quanlydanhmuc.category', compact('category'));
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
    public function store(CreateCategoryRequest $request)
    {
        $this->categoryRepo->create($request->all());

        return redirect()->route('admin.categories.index')->with('message', __('create_success'));
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCategoryRequest $request, $id)
    {
        if ($this->categoryRepo->getCategoryById($id)) {
            $category = $this->categoryRepo->getCategoryById($id);
            $options['name'] = $request->name;
            $options['slug'] = slugHelper($options['name']);
            $category->update($options);
            
            return redirect()->route('admin.categories.index')->with('message', __('update_success'));
        }

        return redirect()->route('admin.categories.index')->with('error', __('Update Fail'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if ($this->categoryRepo->getCategoryById($id)) {
            $this->categoryRepo->delete($id);

            return redirect()->route('admin.categories.index')->with('message', __('delete_success'));
        }
        
        return redirect()->route('admin.categories.index')->with('error', __('category.not_found'));
    }
}
