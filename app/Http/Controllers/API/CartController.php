<?php

namespace App\Http\Controllers\API;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\API\BaseController;

use App\Http\Resources\Item as ItemResource;
use App\Models\Review;
use GuzzleHttp\Exception\GuzzleException;
use PhpParser\Node\Stmt\TryCatch;

class CartController extends BaseController
{
    public function index(Request $request,$sessionKey = null)
    {
        if ($sessionKey = $request->user()->id) {
            $cart = \Cart::session($sessionKey)->getContent();
        }else{
            $cart = \Cart::getContent();
        }

        if ($sessionKey) {
            $shipping_cost = \Cart::session($sessionKey)->getCondition('shipping_cost');
        }

        $shipping_cost = \Cart::getCondition('shipping_cost');

        $condition = new \Darryldecode\Cart\CartCondition(
            [
                'name' => 'TAX 10%',
                'type' => 'tax',
                'target' => 'subtotal',
                'value' => '10%',
            ]
        );

        if ($sessionKey) {
            \Cart::session($sessionKey)->removeConditionsByType('tax');
            \Cart::session($sessionKey)->condition($condition);
        } else {
            \Cart::removeConditionsByType('tax');
            \Cart::condition($condition);
        }

        if ($sessionKey) {
            $tax = \Cart::session($sessionKey)->getCondition('TAX 10%');
        }

        $tax = \Cart::getCondition('TAX 10%');

        if ($sessionKey) {
            $subTotal =  \Cart::session($sessionKey)->getSubTotal();
        }

        $subTotal =  \Cart::getSubTotal();

        if ($sessionKey) {
            $total =  \Cart::session($sessionKey)->getTotal();
        }

        $total =  \Cart::getTotal();

        $carts = [
            'item' => ItemResource::collection($cart),
            'shipping_cost' => $shipping_cost,
            'tax' => $tax,
            'sub_total' => $subTotal,
            'total' => $total,
        ];

        return $this->responseOk($carts,200,'success');
    }

    public function store(Request $request, $sessionKey = 0)
    {
        $validator = Validator::make($request->all(), [
            'slug' => 'required',
            'qty' => 'required'
        ]);

        if($validator->fails()){
            return $this->responseError('add item failed !', 422, $validator->errors());
        }

        $params = $request->all();
        $product = Product::where('slug',$params['slug'])->firstOrFail();
        
        $carts = \Cart::getContent();
		$itemQuantity = 0;
		if ($carts) {
			foreach ($carts as $cart) {
				if ($cart->id == $product->id) {
					$itemQuantity = $cart->quantity;
					break;
				}
			}
        }

        $itemQuantity +=  $request->qty;

        if ($product->quantity < $itemQuantity) {
			// throw new \App\Exceptions\OutOfStockException('The product '. $product->sku .' is out of stock');
		}
		
		$item = [
			'id' => md5($product->id),
			'name' => $product->name,
			'price' => $product->price,
			'quantity' => $request->qty,
			'associatedModel' => $product,
        ];
        
        if ($sessionKey = $request->user()->id) {
            \Cart::session($sessionKey)->add($item);
            $carts = \Cart::getContent();
            return $this->responseOk(true,200,'success');
        }else{
            \Cart::add($item);
            return $this->responseOk(true, 200,'success');
        }

        return $this->responseError('add item failed !', 422);
    }

    public function update(Request $request, $id)
    {
        $params = $request->all();
        $validator = Validator::make($params, [
            'quantity' => 'required|numeric'
        ]);

        if($validator->fails()){
            return $this->responseError('update failed !', 422,$validator->errors());
        }

        $sessionKey = $request->user()->id;

        if ($sessionKey) {
            $carts = \Cart::session($sessionKey)->getContent();
        }else{
            $carts = \Cart::getContent();
        }

        $item = !(empty($carts[$id])) ? $carts[$id] : null;
        if(!$item){
            return $this->responseError('item not found !', 404);
        }

        if ($item->quantity < $params['quantity'] ) {
            // throw new \App\Exceptions\OutOfStockException('The product '. $carts[$cartId]->associatedModel->sku .' is out of stock');
        }

        $cartUpdate = \Cart::update($id,[
            'quantity' => [
                'relative' => false,
                'value' => $params['quantity'],
            ],
        ]);
        
        return $this->responseOk($cartUpdate, 200,'the item has been updated !');
    }

    public function destroy(Request $request, $id)
    {
        $sessionKey = $request->user()->id;

        if ($sessionKey) {
            $carts = \Cart::session($sessionKey)->getContent();
        }else{
            $carts = \Cart::getContent();
        }

        $item = !(empty($carts[$id])) ? $carts[$id] : null;
        if(!$item){
            return $this->responseError('item not found !', 404);
        }

        if ($sessionKey) {
            $cartDelete = \Cart::session($sessionKey)->remove($id);
            return  $this->responseOk($cartDelete, 200,'the item has been deleted !');
        }else {
            $cartDelete = \Cart::remove($id);
            return  $this->responseOk($cartDelete, 200,'the item has been deleted !');
        }

        $this->responseError('deleted item failed !', 400);
    }

    public function clear(Request $request){

        $sessionKey = $request->user()->id;

        if ($sessionKey) {
            $cartDestroy = \Cart::session($sessionKey)->clear();
        }

        $cartDestroy = \Cart::clear();

        if($cartDestroy){
            return $this->responseOk($cartDestroy, 200, 'the item has been cleared !');
        }

        return $this->responseError('clear cart item failed !', 400);
        
    }

    public function shippingOptions(Request $request)
    {
        $parameter = $request->all();

        $validator = Validator::make($parameter, [
            'city_id' => 'required|numeric'
        ]);

        $sessionKey = $request->user()->id;

        if($validator->fails()){
            return $this->responseError('get shipping options failed !', 422, $validator->errors());
        }

        if ($sessionKey) {
            \Cart::session($sessionKey)->isEmpty();
        } else {
            \Cart::isEmpty();
        }

    try {

        $totalWeight = 0;
        if ($sessionKey) {
            $items = \Cart::session($sessionKey)->getContent();
        } else {
            $items = \Cart::getContent();
        }

        foreach ($items as $item) {
            $totalWeight += ($item->quantity * $item->associatedModel->weight);
        }

        $params = [
            'origin' => env('RAJAONGKIR_ORIGIN'),
            'destination' => $parameter['city_id'],
            'weight' => $totalWeight,
        ];

        $results = [];
        foreach ($this->couriers as $code => $courier) {
            $params['courier'] = $code;
            
            $response = $this->rajaOngkirRequest('cost', $params, 'POST');
            
            if (!empty($response['rajaongkir']['results'])) {
                foreach ($response['rajaongkir']['results'] as $cost) {
                    if (!empty($cost['costs'])) {
                        foreach ($cost['costs'] as $costDetail) {
                            $serviceName = strtoupper($cost['code']) .' - '. $costDetail['service'];
                            $costAmount = $costDetail['cost'][0]['value'];
                            $etd = $costDetail['cost'][0]['etd'];

                            $result = [
                                'service' => $serviceName,
                                'cost' => $costAmount,
                                'etd' => $etd,
                                'courier' => $code,
                            ];

                            $results[] = $result;
                        }
                    }
                }
            }
        }

        $response = [
            'origin' => $params['origin'],
            'destination' => $params ['destination'],
            'weight' => $totalWeight,
            'results' => $results,
        ];
      
        return $this->responseOk($response, 200,'success !');

    } catch (\GuzzleHttp\Exception\RequestException $err) {
        return $this->responseError($err->getMessage(), 400);
    }
    return $this->responseError('get shipping options failed !', 400);

    }

    public function setShipping(Request $request)
    {
        $params = $request->all();
        $validator = Validator::make($params, [
            'city_id' => ['required', 'numeric'],
            'shipping_service' => ['required', 'string'],
        ]);

        if ($validator->fails()) {
            return $this->responseError('Set shipping failed', 422, $validator->errors());
        }

        $sessionKey = $request->user()->id;

        if ($sessionKey) {
            \Cart::session($sessionKey)->removeConditionsByType('shipping');
        }

        \Cart::removeConditionsByType('shipping');

        $shippingService = $request->get('shipping_service');
        $destination = $request->get('city_id');

        $totalWeight = 0;
        if ($sessionKey) {
            $items = \Cart::session($sessionKey)->getContent();
        } else {
            $items = \Cart::getContent();
        }

        foreach ($items as $item) {
            $totalWeight += ($item->quantity * $item->associatedModel->weight);
        }

        $params = [
            'origin' => env('RAJAONGKIR_ORIGIN'),
            'destination' => $destination,
            'weight' => $totalWeight,
        ];

        $results = [];
        foreach ($this->couriers as $code => $courier) {
            $params['courier'] = $code;
            
            $response = $this->rajaOngkirRequest('cost', $params, 'POST');
            
            if (!empty($response['rajaongkir']['results'])) {
                foreach ($response['rajaongkir']['results'] as $cost) {
                    if (!empty($cost['costs'])) {
                        foreach ($cost['costs'] as $costDetail) {
                            $serviceName = strtoupper($cost['code']) .' - '. $costDetail['service'];
                            $costAmount = $costDetail['cost'][0]['value'];
                            $etd = $costDetail['cost'][0]['etd'];

                            $result = [
                                'service' => $serviceName,
                                'cost' => $costAmount,
                                'etd' => $etd,
                                'courier' => $code,
                            ];

                            $results[] = $result;
                        }
                    }
                }
            }
        }

        $shippingOptions = [
            'origin' => $params['origin'],
            'destination' => $destination,
            'weight' => $totalWeight,
            'results' => $results,
        ];

        $selectedShipping = null;
        if ($shippingOptions['results']) {
            foreach ($shippingOptions['results'] as $shippingOption) {
                if (str_replace(' ', '', $shippingOption['service']) == $shippingService) {
                    $selectedShipping = $shippingOption;
                    break;
                }
            }
        }

        $status = null;
        $message = null;
        $data = [];

        if ($selectedShipping) {
            $status = 200;
            $message = 'Success set shipping cost';

            $condition = new \Darryldecode\Cart\CartCondition(
                [
                    'name' => 'shipping_cost',
                    'type' => 'shipping',
                    'target' => 'total',
                    'value' => '+'. $selectedShipping['cost'],
                ]
            );
    
            \Cart::condition($condition);

            if ($sessionKey) {
                $carts=  \Cart::session($sessionKey)->getTotal();
            }
    
            $carts = \Cart::getTotal();

            $data['total'] = number_format($carts);

            return $this->responseOk($data, 200, 'success');
        }

        return $this->responseError('Failed to set shipping cost', 400);

    }
}
