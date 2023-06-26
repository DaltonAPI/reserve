<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Arr;
class UserController extends Controller
{
    // Show Register/Create Form
    public function create() {
        return view('users.register');
    }



    public function store(Request $request)
    {
        $formFields = $request->except('_token', 'password_confirmation');
        $formFields['social_media'] = json_encode($formFields['social_media']);
        $formFields['password'] = bcrypt($formFields['password']);

        if ($request->hasFile('photos')) {
            $logoFile = $request->file('photos');
            $filename = uniqid() . '_' . $logoFile->getClientOriginalName();
            $formFields['photos'] = $logoFile->storeAs('logos', $filename, 'public');
        }

        if ($formFields['account_type'] === 'Business') {
            // Save business fields
            $businessFields = [
                'name' => ['required', 'min:3'],
                'account_type' => 'required',
                'email' => ['required', 'email', Rule::unique('users', 'email')],
                'password' => 'required|confirmed|min:6',
                'bio' => 'required|string|min:10|max:500',
                'contact_info' => ['required', 'numeric'],
                'social_media' => 'array',
                'Facebook_links' => 'required|url',
                'Instagram_links' => 'required|url',
                'Twitter_links' => 'required|url',
                'industry_category' => 'required',
                'servicesOffer'=> 'required|array',
                'location' => 'required'
            ];

            $businessData = Arr::only($formFields, array_keys($businessFields));

            $businessData['social_media'] = $formFields['social_media'];
            $businessData['photos'] = $formFields['photos'] ?? null;

            $user = User::create($businessData);
            auth()->login($user);
        return redirect('/landing')->with('message', 'User created and logged in');

        } elseif ($formFields['account_type'] === 'Client') {
            // Save client fields
            $clientFields = [
                'email' => ['required', 'email', Rule::unique('users', 'email')],
                'password' => 'required|confirmed|min:6',
                'bio' => 'required|string|min:10|max:500',
                'contact_info' => ['required', 'numeric'],
                'Facebook_links' => 'nullable|url',
                'Instagram_links' => 'nullable|url',
                'Twitter_links' => 'nullable|url',
                'client-name' => ['required', 'min:3'],
            ];

            $clientData = Arr::only($formFields, array_keys($clientFields));
            $clientData['social_media'] = $formFields['social_media'];
            $clientData['photos'] = $formFields['photos'] ?? null;
            dd($clientData);
            // Save client data to the database
            $user = User::create($clientData);
            auth()->login($user);
            return redirect('/landing')->with('message', 'User created and logged in');
        }

        // Redirect or perform any other actions
    }




    // Logout User
    public function logout(Request $request) {
        auth()->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/landing')->with('message', 'You have been logged out!');

    }

    // Show Login Form
    public function login() {
        return view('users.login');
    }

    // Authenticate User
    public function authenticate(Request $request) {
        $formFields = $request->validate([
            'email' => ['required', 'email'],
            'password' => 'required'
        ]);

        if(auth()->attempt($formFields)) {
            $request->session()->regenerate();

            return redirect('/landing')->with('message', 'You are now logged in!');
        }

        return back()->withErrors(['email' => 'Invalid Credentials'])->onlyInput('email');
    }

    public function show(Request $request)
    {
        $searchTerm = $request->input('search');
        $filteredUsers = User::filter(['search' => $searchTerm])->paginate(10);
//        dd($filteredUsers);

        return view('users.business', compact('filteredUsers'));
    }
    public function updateProfile(Request $request, $id)
    {

        $user = User::findOrFail($id);

        // Validate the form data
        $validatedData = $request->validate([
            'name' => 'required',
            'bio' => 'required',
            'email' => 'required|email',
            'contact_info' => 'required',
            'industry_category' => 'required',
            'location' => 'required',
        ]);

        if($request->hasFile('photos')) {
            $formFields['photos'] = $request->file('photos')->store('logos', 'public');
        }

        $user->update($validatedData);

        return back()->with('message', 'Listing updated successfully!');


    }

    public function destroy(User $user)
    {

        $user->delete();

        return redirect('/')->with('success', 'User deleted successfully.');
    }


}
