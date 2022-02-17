<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slide extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function prevSlide()
	{
		return self::where('position', '<', $this->position)
			->orderBy('position', 'DESC')
			->first();
	}

	public function nextSlide()
	{
		return self::where('position', '>', $this->position)
			->orderBy('position', 'ASC')
			->first();
	}
}
