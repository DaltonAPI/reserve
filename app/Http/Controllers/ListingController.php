<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use App\Models\Notifications\ReservationCreatedNotification;
use App\Models\Service;
use App\Models\Time;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Twilio\Exceptions\TwilioException;

class ListingController extends Controller
{
    // Show all listings
    public function index(Request $request)
    {
        $user = auth()->user();
        $listings = Listing::query();

        if ($user->account_type === 'Client' || $user->account_type === 'Business') {
            $listings->where(function ($query) use ($user) {
                $query->where('user_id', $user->id)
                    ->orWhere('client_id', $user->id)
                    ->orWhere('business_id', $user->id);
            });
        }
        $currentDate = date('Y-m-d');


        $listings = $listings->latest()->filter(request(['tag', 'search']))->paginate(30);
        $upcomingListings = $listings->where('date', '>=', date('Y-m-d', strtotime($currentDate)))->count();
        $pastListings = $listings->where('date', '<', date('Y-m-d', strtotime($currentDate)))->count();
        $searchTerm = $request->input('search');
        $filteredUsers = User::filter(['search' => $searchTerm])->paginate(30);

        return view('listings.index', compact('user', 'listings', 'filteredUsers','upcomingListings','pastListings'));
    }






    public function allLisings(Request $request)
    {
        $searchTerm = $request->input('search');
        $filteredUsers = User::filter(['search' => $searchTerm])->paginate(30);
        $listings = Listing::latest()->filter(request(['tag', 'search']))->paginate(30);
        return view('listings.allListings', compact( 'listings','filteredUsers'));
    }




    //Show single listing
    public function show(Listing $listing) {

        return view('listings.show', [
            'listing' => $listing
        ]);
    }

    // Show Create Form
    public function create(Request $request, $clientId = null, $businessId = null)
    {
        // If only one parameter is provided in the URL, assume it's the businessId
        if ($businessId === null && $clientId !== null) {
            $businessId = $clientId;
            $clientId = null; // Set $clientId to null after $businessId gets its value
        }

        // Get the selected date from the query parameter
        $selectedDate = $request->query('date');

        // Get the currently authenticated user
        $user = $request->user();

        // Retrieve the client based on the provided ID if it exists
        $client = $clientId ? User::findOrFail($clientId) : null;

        // Retrieve the filtered users for the sidebar
        $searchTerm = $request->input('search');
        $filteredUsers = User::filter(['search' => $searchTerm])->paginate(30);
        $reservationData =  Listing::where('user_id', $businessId)->get();
        $times = Time::where('user_id', $businessId)->get();
        $business = User::find($businessId);

        return view('listings.create', compact('user', 'reservationData', 'times', 'business', 'filteredUsers', 'client', 'clientId', 'businessId', 'selectedDate'));
    }

    public function createRandom(Request $request)
    {
        $user = $request->user();
        $searchTerm = $request->input('search');
        $filteredUsers = User::filter(['search' => $searchTerm])->paginate(30);
        if (\auth()->user()->account_type = 'Business'){
            $services = Service::where('user_id', \auth()->user()->id)->get();
        }

        return view('listings.random', compact('user' ,'filteredUsers','services'));
    }



    // Store Listing Data
    public function store(Request $request)
    {

        $formFields = $request->validate([
            'title' => 'nullable|required',
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




        if ($formFields['customer_phone']) {
            $twilioSid = env('TWILIO_SID');
            $twilioAuthToken = env('TWILIO_AUTH_TOKEN');
            $twilioPhoneNumber = env('TWILIO_PHONE_NUMBER');

            $reservationDateTime = new \DateTime($formFields['date'] . ' ' . $formFields['time']);

            $formattedDate = $reservationDateTime->format('F j, Y');
            $formattedTime = $reservationDateTime->format('g:i a');
            $client = new \Twilio\Rest\Client($twilioSid, $twilioAuthToken);

            // Check the account_type of the logged-in user
            $accountType = auth()->user()->account_type;

            if ($accountType == 'Client') {
                // If a client made the reservation, send the message to the Business

                // Retrieve the business details using the provided business_id from the request
                $business = User::find($request->input('business_id'));

                if (!$business) {
                    // Handle error - Business not found
                    return redirect()->back()->with('error', 'Business not found');
                }

                $messageBody = 'Dear ' . $business->name . ', ' . $formFields['customer_name'] . ' has made a reservation for ' . $formattedDate . ' at ' . $formattedTime;

                $recipientPhoneNumber = $business->contact_info;
            } elseif ($accountType == 'Business') {
                $messageBody = 'Hello ' . $formFields['customer_name'] . ', looking forward to seeing you on ' . $formattedDate . ', at ' . $formattedTime . '. Sincerely, ' . auth()->user()->name;

                $recipientPhoneNumber = $formFields['customer_phone'];
            } else {
                $messageBody = 'Default message...';
                $recipientPhoneNumber = $formFields['customer_phone'];
            }

            try {

                $client->messages->create(
                    $recipientPhoneNumber,
                    [
                        'from' => $twilioPhoneNumber,
                        'body' => $messageBody
                    ]
                );

            } catch (TwilioException $e) {
                // Exception occurred while sending SMS
                $errorMessage = 'Failed to send SMS: ' . $e->getMessage();
                return redirect()->back()->with('error', $errorMessage);
            }
        }



        $formFields['user_id'] = auth()->id();
        if( $request->input('client_id'))
        {
            $formFields['client_id'] = $request->input('client_id');
        }
        if($request->input('business_id'))
        {
            $formFields['business_id'] = $request->input('business_id');
        }
        $client = Listing::find($formFields['user_id']);
        if ($client && $client->email) {
            $client->notify(new ReservationCreatedNotification());
        }
//        dd(\request()->all());
         dd($formFields);
//        Listing::create($formFields);
        return redirect('/landing')->with('message', 'Listing created successfully!');
    }


    // Show Edit Form
    public function edit(Request $request, Listing $listing) {
        $searchTerm = $request->input('search');
        $filteredUsers = User::filter(['search' => $searchTerm])->paginate(10);



        return view('listings.edit', compact('listing', 'filteredUsers'));

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
        return redirect('/landing')->with('message', 'Listing deleted successfully');
    }

    // Manage Listings
    public function manage(Request $request)
    {
        $user = Auth::user();
        $searchTerm = $request->input('search');
        $filteredUsers = User::filter(['search' => $searchTerm])->paginate(10);
        $listings = Listing::where('user_id', $user->id)->get();

        return view('listings.manage', compact('listings', 'filteredUsers'));
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


    public function calendar(Request $request, $clientId = null, $businessId = null)
    {
        if ($businessId === null) {
            $businessId = $clientId;
        }
//        dd($businessId);
        $searchTerm = $request->input('search');
        $filteredUsers = User::filter(['search' => $searchTerm])->paginate(10);
        $user = User::where('id', $businessId)->first();

        $listings = Listing::query();
        $reservationData = $listings->where('user_id', $businessId);


        $reservationData = $listings->latest()->get();



        $times = Time::where('user_id', $businessId)->get();

        $business = User::find($businessId);
        $transformedServices = Service::where('user_id', $businessId)->get();
        $services = $transformedServices->map(function ($service) {
            return [
                'name' => $service->name,
                'duration' => $service->duration,
                'price' => $service->price
            ];
        });

        return view('listings.calendar', compact('user', 'reservationData','filteredUsers','times','business','clientId','businessId','services'));
    }


}
