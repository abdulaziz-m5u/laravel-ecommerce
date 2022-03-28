<?php

namespace App\Http\Livewire\Shop;

use App\Models\Product;
use Livewire\Component;
use App\Models\Category;
use Livewire\WithPagination;

class ProductComponent extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    public $paginationLimit = 12;
    public $slug;
    public $sortingBy = 'default';

    public function render()
    {
        switch ($this->sortingBy) {
            case 'popularity':
                $sortField = 'id';
                $sortType = 'desc';
                break;
            case 'low-high':
                $sortField = 'price';
                $sortType = 'asc';
                break;
            case 'high-low':
                $sortField = 'price';
                $sortType = 'desc';
                break;
            default:
                $sortField = 'id';
                $sortType = 'asc';
        }


        $products = Product::with('firstMedia');

        if ($this->slug == '') {
            $products = $products;
        } else {
            $category = Category::whereSlug($this->slug)->first();
            
            if (is_null($category->category_id)) {
        
                $categoriesIds = Category::whereCategoryId($category->id)->pluck('id')->toArray();
                $categoriesIds[] = $category->id;
                $products = $products->whereHas('category', function ($query) use ($categoriesIds) {
                    $query->whereIn('id', $categoriesIds);
                });               

            } else {
                $products = $products->with('category')
                    ->whereHas('category', function ($query) {
                    $query->where([
                        'slug' => $this->slug,
                    ]);
                });

            }
        }

        $products = $products
            ->active()
            ->orderBy($sortField, $sortType)
            ->paginate($this->paginationLimit);
            
        return view('livewire.shop.product-component', compact('products'));
    }
}
