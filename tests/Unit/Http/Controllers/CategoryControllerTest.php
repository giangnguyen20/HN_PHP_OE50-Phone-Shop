<?php

namespace Tests\Unit\Http\Controllers;

use Mockery;
use Mockery as m;
use App\Models\Category;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Tests\TestCase;
use App\Http\Controllers\CategoryController;
use App\Http\Requests\Category\CreateCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;
use App\Repositories\Category\CategoryRepositoryInterface;
use Illuminate\Http\RedirectResponse;

class CategoryTest extends TestCase
{
    protected $categories;
    protected $category;
    protected $categoryRepo;
    protected $controller;
    protected $categoryMock;

    public function setUp(): void
    {
        parent::setUp();
        $this->categories = Category::factory()->count(5)->make();
        $this->request = m::mock(Request::class);
        $this->categoryRepo = m::mock(CategoryRepositoryInterface::class)->makePartial();
        $this->controller = new CategoryController($this->categoryRepo);
        $this->categoryMock = m::mock(Category::class, [
            'id' => 1,
            'name' => 'itel one',
            'slug' => 'itel-one',
        ])->makePartial();
    }

    public function tearDown() : void
    {
        Mockery::close();
        unset($this->controller);
        parent::tearDown();
    }

    public function testIndex()
    {
        $this->categoryRepo->shouldReceive('getAllCategory')->andReturn($this->categories);

        $view = $this->controller->index();

        $this->assertInstanceOf(View::class, $view);
        $this->assertEquals('admin.quanlydanhmuc.category', $view->getName());
        $this->assertArrayHasKey('category', $view->getData());
    }

    public function testStore()
    {
        $data = [
            'name' => 'abc 123',
        ];

        $request = new CreateCategoryRequest($data);

        $this->category = Category::factory()->make([
            'name' => $data['name'],
            'slug' => slugHelper($data['name']),
        ]);
        $this->categoryRepo->shouldReceive('create')
            ->andReturn($this->category);

        $response = $this->controller->store($request);

        $this->assertEquals(302, $response->getStatusCode());
        $this->assertArrayHasKey('message', session()->all());
    }

    public function testUpdateSuccess()
    {
        $id = 1;
        $data = [
            'name' => 'abc 123',
        ];

        $request = new UpdateCategoryRequest($data);
        $this->category = Category::factory()->make([
            'id' => 1,
            'name' => 'abc 1',
            'slug' => 'abc-1',
        ]);

        $options = [
            'name' => $data['name'],
            'slug' => slugHelper($data['name']),
        ];

        $this->categoryRepo->shouldReceive('getCategoryById')->with($id)
            ->andReturn($this->category);

        $this->categoryMock->shouldReceive('update')->with($options)
            ->andReturn(true);
        
        $response = $this->controller->update($request, $id);

        $this->assertEquals(302, $response->getStatusCode());
        $this->assertArrayHasKey('message', session()->all());
    }

    public function testUpdateFail()
    {
        $id = 1;
        $data = [
            'name' => 'abc 123',
        ];

        $request = new UpdateCategoryRequest($data);
        $this->categoryRepo->shouldReceive('getCategoryById')->with($id)
            ->andReturn(false);
        
        $response = $this->controller->update($request, $id);
        $this->assertEquals(302, $response->getStatusCode());
        $this->assertArrayHasKey('error', session()->all());
    }

    public function testDestroy()
    {
        $id = 1;

        $this->categoryRepo->shouldReceive('getCategoryById')->with($id)
            ->andReturn($this->categoryMock);
            $this->categoryRepo->shouldReceive('delete')->with($id)
            ->andReturn(true);
        $response = $this->controller->destroy($id);

        $this->assertEquals(302, $response->getStatusCode());
        $this->assertArrayHasKey('message', session()->all());
    }

    public function testDestroyFail()
    {
        $id = 1;

        $this->categoryRepo->shouldReceive('getCategoryById')->with($id)
            ->andReturn(null);

        $response = $this->controller->destroy($id);

        $this->assertEquals(302, $response->getStatusCode());
        $this->assertArrayHasKey('error', session()->all());
    }
}
