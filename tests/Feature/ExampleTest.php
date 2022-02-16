<?php

namespace Tests\Feature;

use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_manage_categories() : void
    {
        $category = $this->post('admin/categories', [
            'name' => 'category name',
            'slug' => 'category-name',
            'category_id' => null,
            'cover' => '1.jpg'
        ]);

        $category->assertRedirect('admin/categories/index');

        // $response = $this->get('admin/categories/'. $category->id .'/edit');
        // $response->assertStatus(200);

        // $categoryId = Category::where('name', 'category name')->first()->id;
        // $this->assertNotNull($categoryId);
    }
}
