<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index($slug = null)
    {
        return view('frontend.shop.index', compact('slug'));
    }

    public function tag($slug)
    {
        return view('frontend.shop.tag', compact('slug'));
    }

    public function search(Request $request)
    {
        $data = Product::select('slug', 'name')
            ->where('name', 'LIKE', '%'.$request->productName. '%')
            ->take(5)
            ->get();

        return response()->json($data);
    }
}
