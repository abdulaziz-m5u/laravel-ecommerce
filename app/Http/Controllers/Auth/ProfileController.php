<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index()
	{
		$provinces = $this->getProvinces();
		$cities = isset(auth()->user()->province_id) ? $this->getCities(auth()->user()->province_id) : [];
		$user = auth()->user();

		return view('frontend.users.profile', compact('provinces', 'cities','user'));
	}
	
	public function update(Request $request){
		$params = $request->except('_token');
		
        $user = auth()->user();

        $user->update($params);

		return redirect()->route('profile.index');
	}
}
