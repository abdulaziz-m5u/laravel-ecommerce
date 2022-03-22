<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Exceptions\OutOfStockException;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $carts = \Cart::getContent();

        return view('frontend.cart.index', compact('carts'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {		
        $product = Product::findOrFail($request->product_id);
        
        $carts = \Cart::getContent();
		$itemQuantity = 0;
		if ($carts) {
			foreach ($carts as $cart) {
				if ($cart->name == $product->name) {
					$itemQuantity = $cart->quantity;
					break;
				}
			}
        }

        $itemQuantity +=  $request->qty;

        try {
            if ($product->quantity < $itemQuantity) {
                throw new OutOfStockException('produk '. $product->name .' kosong !');
            }
        } catch (\App\Exceptions\OutOfStockException $exception) {
            return redirect()->back()->with([
                    'message' => $exception->getMessage(),
                    'alert-type' => 'danger',
                ]);
        }
		
		$item = [
			'id' => md5($product->id),
			'name' => $product->name,
			'price' => $product->price,
			'quantity' => $request->qty,
			'associatedModel' => $product,
		];

        \Cart::add($item);
        
		return redirect()->back()->with([
            'message' => 'success added to cart !',
            'alert-type' => 'success',
            ]);;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $params = $request->except('_token');

        if($items = $params['items']){
            foreach($items as $cartId => $item){
                $carts = \Cart::getContent();

                try {
                    if ($carts[$cartId]->associatedModel->quantity < $item['quantity']) {
                        throw new OutOfStockException('produk '. $carts[$cartId]->associatedModel->name .' tersisa ' . $carts[$cartId]->associatedModel->quantity);
                    }
                } catch (\App\Exceptions\OutOfStockException $exception) {
                    return redirect()->back()->with([
                            'message' => $exception->getMessage(),
                            'alert-type' => 'danger',
                        ]);
                }

                \Cart::update($cartId,[
                    'quantity' => [
                        'relative' => false,
                        'value' => $item['quantity'],
                    ],
                ]);
            }

            return redirect()->back()->with([
                'message' => 'success updated !',
                'alert-type' => 'info'
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($cartId)
    {
        \Cart::remove($cartId);

        return redirect()->back()->with([
            'message' => 'success deleted !',
            'alert-type' => 'danger'
        ]);;
    }
}
