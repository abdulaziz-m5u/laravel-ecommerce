<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Favorite;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $favorites = Favorite::where('user_id', auth()->id())
			->paginate(10);

		return view('frontend.favorites.index', compact('favorites'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      if(!auth()->check()){
        return response('kamu harus login dulu !',200);
      }
        $request->validate(
			[
				'product_slug' => 'required',
			]
		);

		$product = Product::where('slug', $request->get('product_slug'))->firstOrFail();
		
		$favorite = Favorite::where('user_id', auth()->id())
			->where('product_id', $product->id)
			->first();
		if ($favorite) {
			return response('You have added this product to your favorite before', 422);
		}

		Favorite::create(
			[
				'user_id' => auth()->id(),
				'product_id' => $product->id,
			]
		);

		return response('The product has been added to your favorite', 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Favorite $favorite)
	{
		$favorite->delete();
		
		return redirect()->back();
	}
}
