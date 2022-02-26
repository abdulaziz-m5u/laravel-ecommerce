<?php

namespace App\Http\Livewire\Shop;

use App\Models\Order;
use App\Models\Review;
use Illuminate\Http\Request;
use Livewire\Component;


class SingleProductReviewComponent extends Component
{
    public $showForm = true;
    public $canRate = false;
    public $product;
    public $content;
    public $rating;
    public $checkProduct;
    public $currentRatingId;

    protected $listeners = [
        'update_rating' => 'mount',
    ];

    public function mount()
    {
        $this->checkProduct = Order::whereHas('orderItems', function ($query) {
            $query->where('product_id', $this->product->id);
        })->where('user_id', auth()->id())->where('status', Order::COMPLETED)->first();
   
        if ($this->checkProduct) {
            $this->canRate = true;
        }

        if(auth()->user()){
            $rating = Review::where('user_id', auth()->id())->where('product_id', $this->product->id)->first();

            if (!empty($rating)) {
                $this->rating  = $rating->rating;
                $this->content = $rating->content;
                $this->currentRatingId = $rating->id;
            }
        }
    }

    public function rules()
    {
        return [
            'rating' => ['required'],
            'content' => ['required', 'string']
        ];
    }

    public function rate(Request $request)
    {
        if (!$this->checkProduct){
            $this->alert('error', 'You must buy this item first');
            return false;
        }

        $rating = Review::where('user_id', auth()->id())->where('product_id', $this->product->id)->first();
        $this->validate();

        if (empty($rating)) {
            $rating = new Review();
            $rating->user_id = auth()->id();
            $rating->product_id = $this->product->id;
            $rating->rating = $this->rating;
            $rating->content = $this->content;
            $rating->status = 1;
            $rating->save();
        } else {
            if ($rating->status == 'Inactive'){
                $this->alert('error', 'already rating this item');
                return false;
            }
            $rating->user_id = auth()->id();
            $rating->product_id = $this->product->id;
            $rating->rating = $this->rating;
            $rating->content = $this->content;
            $rating->ip_address = $request->ip();
            $rating->status = 1;
            $rating->update();
        }

        $this->showForm = false;
        $this->emit('update_rating');
    }

    public function delete($id)
    {
        $rating = Review::where('id', $id)->first();
        if ($rating && ($rating->user_id == auth()->id())) {
            $rating->delete();
        }
        if ($this->currentRatingId) {
            $this->currentRatingId = '';
            $this->rating  = '';
            $this->content = '';
        }
        $this->emit('update_rating');
        $this->showForm = true;
    }


    public function render()
    {
        return view('livewire.shop.single-product-review-component');
    }
}
