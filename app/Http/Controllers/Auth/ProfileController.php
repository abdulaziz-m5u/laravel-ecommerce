<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileRequest;

class ProfileController extends Controller
{
    public function index()
	{
		$provinces = $this->getProvinces();
		$cities = isset(auth()->user()->province_id) ? $this->getCities(auth()->user()->province_id) : [];
		$user = auth()->user();

		return view('frontend.users.profile', compact('provinces', 'cities','user'));
	}
	
	public function update(ProfileRequest $request){		
        $user = auth()->user();

        $user->update($request->validated());

		return redirect()->route('profile.index')->with(['message' => 'success updated']);
	}
}
