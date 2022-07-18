<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Category\CreateCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Repositories\Category\CategoryRepositoryInterface;

class CategoryAPIController extends Controller
{
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
        try {
            $categories = $this->categoryRepo->getAllCategory();

            return response()->json([
                'status' => 'success',
                'data' => CategoryResource::collection($categories),
            ], 200);
        } catch (\Exception $error) {
            return response()->json([
                'status' => 'error',
                'message' => $error->getMessage(),
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateCategoryRequest $request)
    {
        try {
            if ($request->validator->fails()) {
                return response([
                    'status' => 'error',
                    'error' => $request->validator->errors(),
                ], 422);
            }

            $data = $request->except('_token');
            $data['slug'] = slugHelper($data['name']);
            $category = $this->categoryRepo->create($data);

            return response()->json([
                'message' => __('Add Success'),
                'category' => new CategoryResource($category),
            ], 200);
        } catch (\Exception $error) {
            return response()->json([
                'status' => 'error',
                'message' => $error->getMessage(),
            ], 500);
        }
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
        try {
            if ($request->validator->fails()) {
                return response([
                    'status' => 'error',
                    'error' => $request->validator->errors(),
                ], 422);
            }

            $data = $request->except('_token');
            $data['slug'] = slugHelper($data['name']);
            $category = $this->categoryRepo->update($id, $data);

            return response()->json([
                'message' => __('Update success'),
                'category' => new CategoryResource($category),
            ], 200);
        } catch (\Exception $error) {
            return response()->json([
                'status' => 'error',
                'message' => $error->getMessage(),
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $this->categoryRepo->delete($id);

            return response()->json([
                'message' => __('Delete success'),
            ], 200);
        } catch (\Exception $error) {
            return response()->json([
                'status' => 'error',
                'message' => $error->getMessage(),
            ], 500);
        }
    }
}
