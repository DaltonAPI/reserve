<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

class ListingController extends Controller
{
    // Show all listings
    public function index()
    {
        $user = auth()->user();
        $listings = $user->listings()->latest()->filter(request(['tag', 'search']))->paginate(6);
        return view('listings.index', compact('user', 'listings'));
    }




    //Show single listing
    public function show(Listing $listing) {
        return view('listings.show', [
            'listing' => $listing
        ]);
    }

    // Show Create Form
    public function create() {
        return view('listings.create');
    }

    // Store Listing Data
    public function store(Request $request)
    {
        $formFields = $request->validate([
            'title' => 'required',
            'tags' => 'required',
            'email' => ['required', 'email'],
            'time' => 'required',
            'date' => 'required',
            'customer_name' => 'required',
            'customer_phone' => 'required',
            'description' => 'required',
            'status' => 'required',
        ]);

        if ($request->hasFile('logo')) {
            $formFields['logo'] = $request->file('logo')->store('logos', 'public');
        }

        $formFields['user_id'] = auth()->id();

        Listing::create($formFields);

        return redirect('/')->with('message', 'Listing created successfully!');
    }


    // Show Edit Form
    public function edit(Listing $listing) {
        return view('listings.edit', ['listing' => $listing]);
    }

    // Update Listing Data
    public function update(Request $request, Listing $listing) {
        // Make sure logged in user is owner
        if($listing->user_id != auth()->id()) {
            abort(403, 'Unauthorized Action');
        }

        $formFields = $request->validate([
            'title' => 'required',
            'tags' => 'required',
            'email' => ['required', 'email'],
            'time' => 'required',
            'date' => 'required',
            'customer_name' => 'required',
            'customer_phone' => 'required',
            'description' => 'required',
            'status' => 'required',
        ]);


        if($request->hasFile('logo')) {
            $formFields['logo'] = $request->file('logo')->store('logos', 'public');
        }

        $listing->update($formFields);

        return back()->with('message', 'Listing updated successfully!');
    }

    // Delete Listing
    public function destroy(Listing $listing) {
        // Make sure logged in user is owner
        if($listing->user_id != auth()->id()) {
            abort(403, 'Unauthorized Action');
        }

        if($listing->logo && Storage::disk('public')->exists($listing->logo)) {
            Storage::disk('public')->delete($listing->logo);
        }
        $listing->delete();
        return redirect('/')->with('message', 'Listing deleted successfully');
    }

    // Manage Listings
    public function manage() {
        return view('listings.manage', ['listings' => auth()->user()->listings()->get()]);
    }

    public function cancelReservation($reservationId)
    {
        $reservation = Listing::findOrFail($reservationId);

        // Check if the reservation belongs to the authenticated user
        if ($reservation->user_id === auth()->user()->id) {
            // Update the reservation status to indicate cancellation
            $reservation->status = 'cancelled';

            // Save the updated reservation record
            $reservation->save();

            // Perform additional actions (e.g., send notifications, update availability, etc.)

            // Redirect or return a response based on your application's needs
            return redirect()->back()->with('success', 'Reservation canceled successfully.');
        } else {
            // Redirect or return a response indicating unauthorized access to the reservation
            return redirect()->back()->with('error', 'You are not authorized to cancel this reservation.');
        }
    }

    public function calendar()
    {
        $user = auth()->user();
        $reservationData = $user->listings()->latest()->filter(request(['tag', 'search']))->paginate(6);
        return view('listings.calendar', compact('user', 'reservationData'));
    }

    public function test(Request $request){
        dd($request->all());
    }
}
