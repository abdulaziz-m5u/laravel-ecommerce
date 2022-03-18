<?php

namespace App\Http\Controllers\API;

use App\Models\Order;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Shipment;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController;

class OrderController extends BaseController
{
    public function checkout(Request $request){
        $params = $request->user()->toArray();
        $params = array_merge($params, $request->all());

        $sessionKey = $request->user()->id;

        $orders = \DB::transaction(
            function () use ($params, $sessionKey) {
                $destination = isset($params['ship_to']) ? $params['shipping_city_id'] : $params['city_id'];
            
                if ($sessionKey) {
                    \Cart::session($sessionKey)->isEmpty();
                } else {
                    \Cart::isEmpty();
                }
        
                $totalWeight = 0;
                if ($sessionKey) {
                    $items = \Cart::session($sessionKey)->getContent();
                } else {
                    $items = \Cart::getContent();
                }
        
                foreach ($items as $item) {
                    $totalWeight += ($item->quantity * $item->associatedModel->weight);
                }

                $param = [
                    'origin' => env('RAJAONGKIR_ORIGIN'),
                    'destination' => $destination,
                    'weight' => $totalWeight,
                ];
        
                $results = [];
                foreach ($this->couriers as $code => $courier) {
                    $param['courier'] = $code;
                    
                    $response = $this->rajaOngkirRequest('cost', $param, 'POST');
                    
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
                    'origin' => $param['origin'],
                    'destination' => $destination,
                    'weight' => $totalWeight,
                    'results' => $results,
                ];

                $shippingService = $params['shipping_service'];

                $selectedShipping = null;
                if ($shippingOptions['results']) {
                    foreach ($shippingOptions['results'] as $shippingOption) {
                        if (str_replace(' ', '', $shippingOption['service']) == $shippingService) {
                            $selectedShipping = $shippingOption;
                            break;
                        }
                    }
                }
                
                if ($sessionKey) {
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
                    $items = \Cart::session($sessionKey)->getContent();
                }
        
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
                $items = \Cart::getContent();

                $baseTotalPrice = 0;
                foreach ($items as $item) {
                    $baseTotalPrice += $item->getPriceSum();
                }
        
                if ($sessionKey) {
                    \Cart::session($sessionKey)->getSubTotal();
                }
        
                \Cart::getSubTotal();

                if ($sessionKey) {
                    $taxAmount = (float) \Cart::session($sessionKey)->getCondition('TAX 10%')->parsedRawValue;
                }
        
                $taxAmount = (float) \Cart::getCondition('TAX 10%')->parsedRawValue;

                if ($sessionKey) {
                    $taxPercent = (float) \Cart::session($sessionKey)->getCondition('TAX 10%')->getValue();
                }
        
                $taxPercent = (float) \Cart::getCondition('TAX 10%')->getValue();
        
                $shippingCost = $selectedShipping['cost'];
                $discountAmount = 0;
                $discountPercent = 0;
                $grandTotal = ($baseTotalPrice + $taxAmount + $shippingCost) - $discountAmount;
        
                $orderDate = date('Y-m-d H:i:s');
                $paymentDue = (new \DateTime($orderDate))->modify('+7 day')->format('Y-m-d H:i:s');
        
                $orderParams = [
                    'user_id' => auth()->user()->id,
                    'code' => Order::generateCode(),
                    'status' => Order::CREATED,
                    'order_date' => $orderDate,
                    'payment_due' => $paymentDue,
                    'payment_status' => Order::UNPAID,
                    'base_total_price' => $baseTotalPrice,
                    'tax_amount' => $taxAmount,
                    'tax_percent' => $taxPercent,
                    'discount_amount' => $discountAmount,
                    'discount_percent' => $discountPercent,
                    'shipping_cost' => $shippingCost,
                    'grand_total' => $grandTotal,
                    'note' => $params['note'],
                    'customer_first_name' => $params['first_name'],
                    'customer_last_name' => $params['last_name'],
                    'customer_address1' => $params['address1'],
                    'customer_address2' => $params['address2'],
                    'customer_phone' => $params['phone'],
                    'customer_email' => $params['email'],
                    'customer_city_id' => $params['city_id'],
                    'customer_province_id' => $params['province_id'],
                    'customer_postcode' => $params['postcode'],
                    'shipping_courier' => $selectedShipping['courier'],
                    'shipping_service_name' => $selectedShipping['service'],
                ];
        
                $order = Order::create($orderParams);
                
                if ($sessionKey) {
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
                    $cartItems = \Cart::session($sessionKey)->getContent();
                }
        
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
                $cartItems = \Cart::getContent();

                if ($order && $cartItems) {
                    foreach ($cartItems as $item) {
                        $itemTaxAmount = 0;
                        $itemTaxPercent = 0;
                        $itemDiscountAmount = 0;
                        $itemDiscountPercent = 0;
                        $itemBaseTotal = $item->quantity * $item->price;
                        $itemSubTotal = $itemBaseTotal + $itemTaxAmount - $itemDiscountAmount;

                        $product = isset($item->associatedModel->parent) ? $item->associatedModel->parent : $item->associatedModel;

                        $orderItemParams = [
                            'order_id' => $order->id,
                            'product_id' => $item->associatedModel->id,
                            'qty' => $item->quantity,
                            'base_price' => $item->price,
                            'base_total' => $itemBaseTotal,
                            'tax_amount' => $itemTaxAmount,
                            'tax_percent' => $itemTaxPercent,
                            'discount_amount' => $itemDiscountAmount,
                            'discount_percent' => $itemDiscountPercent,
                            'sub_total' => $itemSubTotal,
                            'type' => $product->type,
                            'name' => $item->name,
                            'weight' => $item->associatedModel->weight,
                        ];

                        $orderItem = OrderItem::create($orderItemParams);
                        
                        if ($orderItem) {
                            $product = Product::findOrFail($product->id);
                            $product->quantity -= $item->quantity;
                            $product->save();
                        }
                    }
                }
       
                $this->initPaymentGateway();

                $customerDetails = [
                    'first_name' => $order->customer_first_name,
                    'last_name' => $order->customer_last_name,
                    'email' => $order->customer_email,
                    'phone' => $order->customer_phone,
                ];
        
                $data_payment = [
                    'enable_payments' => Payment::PAYMENT_CHANNELS,
                    'transaction_details' => [
                        'order_id' => $order->code,
                        'gross_amount' => (int) $order->grand_total,
                    ],
                    'customer_details' => $customerDetails,
                    'expiry' => [
                        'start_time' => date('Y-m-d H:i:s T'),
                        'unit' => \App\Models\Payment::EXPIRY_UNIT,
                        'duration' => \App\Models\Payment::EXPIRY_DURATION,
                    ],
                ];
        
                $snap = \Midtrans\Snap::createTransaction($data_payment);
                
                if ($snap->token) {
                    $order->payment_token = $snap->token;
                    $order->payment_url = $snap->redirect_url;
                    $order->save();
                }

                $shippingFirstName = isset($params['ship_to']) ? $params['shipping_first_name'] : $params['first_name'];
                $shippingLastName = isset($params['ship_to']) ? $params['shipping_last_name'] : $params['last_name'];
                $shippingAddress1 = isset($params['ship_to']) ? $params['shipping_address1'] : $params['address1'];
                $shippingAddress2 = isset($params['ship_to']) ? $params['shipping_address2'] : $params['address2'];
                $shippingPhone = isset($params['ship_to']) ? $params['shipping_phone'] : $params['phone'];
                $shippingEmail = isset($params['ship_to']) ? $params['shipping_email'] : $params['email'];
                $shippingCityId = isset($params['ship_to']) ? $params['shipping_city_id'] : $params['city_id'];
                $shippingProvinceId = isset($params['ship_to']) ? $params['shipping_province_id'] : $params['province_id'];
                $shippingPostcode = isset($params['ship_to']) ? $params['shipping_postcode'] : $params['postcode'];

                $shipmentParams = [
                    'user_id' => auth()->user()->id,
                    'order_id' => $order->id,
                    'status' => Shipment::PENDING,
                    'total_qty' => \Cart::getTotalQuantity(),
                    'total_weight' => $totalWeight,
                    'first_name' => $shippingFirstName,
                    'last_name' => $shippingLastName,
                    'address1' => $shippingAddress1,
                    'address2' => $shippingAddress2,
                    'phone' => $shippingPhone,
                    'email' => $shippingEmail,
                    'city_id' => $shippingCityId,
                    'province_id' => $shippingProvinceId,
                    'postcode' => $shippingPostcode,
                ];

                Shipment::create($shipmentParams);
    
                return $order;
            }
        );
        
        if ($orders) {
            if ($sessionKey) {
                \Cart::session($sessionKey)->clearCartConditions();
                \Cart::session($sessionKey)->clear();
            }
    
            \Cart::clearCartConditions();
            \Cart::clear();

            return $this->responseOk($orders, 200, 'success');
        }

        return $this->responseError('Order process failed, 422');
    }
}
