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

        return redirect()->back()->with('success', 'Service added successfully.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:20',  // Max length of 255 characters
            'duration' => 'required|string',      // Assuming it's a string in hh:mm format
            'price' => 'required|numeric|min:0',  // Minimum value of 0 to ensure positive price
            'description' => 'nullable|string|max:500', // Optional with max length of 500 characters
        ]);

        $service = Service::find($id);

        if (!$service) {
            return redirect()->back()->with('error', 'Service not found.');
        }

        $service->name = $request->input('name');
        $service->duration = $request->input('duration');
        $service->price = $request->input('price');
        $service->description = $request->input('description');

        $service->save();

        return redirect()->back()->with('success', 'Service updated successfully.');
    }

    public function destroy(Service $service)
    {
        $service->delete();
        return redirect()->back()->with('success', 'Service deleted successfully!');

    }




    public function index()
    {
        $services = auth()->user()->services;
        return view('services.index', compact('services'));
    }

}
