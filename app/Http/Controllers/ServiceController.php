<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;
class ServiceController extends Controller
{


    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:50',
            'duration' => 'required|string',
            'price' => 'required|numeric',
            'description' => 'nullable|string|max:100',
        ]);



        // Add the user_id to the data array
        $data['user_id'] = auth()->id();
//        dd($data);
        $service = Service::create($data); // Assuming you've a Service model

        return redirect('/services');
    }





    public function index()
    {
        $services = auth()->user()->services;
        return view('services.index', compact('services'));
    }

}
