<?php

namespace App\Http\Controllers\API;

use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Resources\Product as ProductResource;
use App\Http\Controllers\API\BaseController;

class ProductController extends BaseController
{
    private $paginate = 2;

    public function index(Request $request)
    {
        if((int)$request->req_page && (int)$request->req_page < 10){
            $this->paginate = $request->req_page;
        }

        $products = Product::paginate($this->paginate);

        if ($q = $request->query('q')) {
            $products = Product::where('name','LIKE', '%'. $request->query('q'). '%')
                ->orWhere('description', 'LIKE', '%' . $request->query('q') . '%')    
                ->paginate($this->paginate);            
		}

        $meta = [
            'paginate' => $this->paginate,
            'current_page' => $products->currentPage(),
            'total_pages' => $products->lastPage()
        ];

        return $this->responseOk(ProductResource::collection($products),200,'success', $meta);
    }

    public function show(Request $request){
        $product = Product::with('media', 'category', 'tags')
            ->where('slug', $request->slug)
            ->withCount('media','approvedReviews')
            ->withAvg('approvedReviews', 'rating')
            ->active()
            ->hasQuantity()
            ->firstOrFail();

            return $this->responseOk(new ProductResource($product),200,'success');
    }
}
