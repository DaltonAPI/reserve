<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Services\TwilioService;
use Twilio\Exceptions\TwilioException;
class ListingController extends Controller
{
    // Show all listings
    public function index(Request $request)
    {
        $user = auth()->user();
        $listings = $user->listings()->latest()->filter(request(['tag', 'search']))->paginate(6);
        $searchTerm = $request->input('search');
        $filteredUsers = User::filter(['search' => $searchTerm])->paginate(10);
        return view('listings.index', compact('user', 'listings','filteredUsers'));
    }

    public function allLisings()
    {

        $listings = Listing::latest()->filter(request(['tag', 'search']))->paginate(6);
        return view('listings.allListings', compact( 'listings'));
    }




    //Show single listing
    public function show(Listing $listing) {
        return view('listings.show', [
            'listing' => $listing
        ]);
    }

    // Show Create Form
    public function create(Request $request, $id)
    {
        // Get the currently authenticated user
        $user = Auth::user();

        // Retrieve the client based on the provided ID
        $client = User::findOrFail($id);

        // Retrieve the filtered users for the sidebar
        $searchTerm = $request->input('search');
        $filteredUsers = User::filter(['search' => $searchTerm])->paginate(10);

        return view('listings.create', compact('user', 'filteredUsers', 'client'));
    }


    // Store Listing Data
    public function store(Request $request)
    {
        $formFields = $request->validate([
            'title' => 'required|string',
            'tags' => 'nullable',
            'email' => ['nullable', 'email'],
            'time' => 'required',
            'date' => 'required',
            'customer_name' => 'nullable|required',
            'customer_phone' => 'nullable|string',
            'description' => 'nullable|string',
            'status' => 'required',
            'logo' => 'image|mimes:jpeg,png,jpg,gif',
        ]);

        if ($request->hasFile('logo')) {
            $formFields['logo'] = $request->file('logo')->store('logos', 'public');
        }

        // Send SMS using Twilio


//        try {
//            $twilioSid = env('TWILIO_SID');
//            $twilioAuthToken = env('TWILIO_AUTH_TOKEN');
//            $twilioPhoneNumber = env('TWILIO_PHONE_NUMBER');
//            $customerPhoneNumber = $formFields['customer_phone'];
//
//            $client = new \Twilio\Rest\Client($twilioSid, $twilioAuthToken);
//            $messageBody = 'Hello ' . $formFields['customer_name'] . ',  looking forward to seeing you on ' . $formFields['date'] . ', at ' . $formFields['time']. ' '
//            . 'Sincerely ' . auth()->user()->name;
//
//            $client->messages->create(
//                $customerPhoneNumber,
//                [
//                    'from' => $twilioPhoneNumber,
//                    'body' => $messageBody
//                ]
//            );
//
//            // Message sent successfully
//            // ... your remaining code ...
//        } catch (TwilioException $e) {
//            // Exception occurred while sending SMS
//            // Handle the exception as per your requirements
//            $errorMessage = 'Failed to send SMS: ' . $e->getMessage();
//            return redirect()->back()->with('error', $errorMessage);
//        }


        $formFields['user_id'] = auth()->id();
        Listing::create($formFields);
        return redirect('/reservations')->with('message', 'Listing created successfully!');
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
            'title' => 'required|string',
            'tags' => 'nullable',
            'email' => ['nullable', 'email'],
            'time' => 'required',
            'date' => 'required',
            'customer_name' => 'nullable|required',
            'customer_phone' => 'nullable|string',
            'description' => 'nullable|string',
            'status' => 'required',
            'logo' => 'image|mimes:jpeg,png,jpg,gif',
        ]);


        if($request->hasFile('logo')) {
            $formFields['logo'] = $request->file('logo')->store('logos', 'public');
        }

        $listing->update($formFields);

        return back()->with('message', 'Listing updated successfully!');
    }

    // Delete Listing
    public function destroy(Listing $listing) {

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


}
