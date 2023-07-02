<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
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
        if ($request->has('social_media')) {
            $socialMedia = json_encode($request->input('social_media'));
        } else {
            $socialMedia = null;
        }

        $password = bcrypt($request->input('password'));

        // Validation rules for business fields
        $businessFields = [
            'name' => ['required', 'min:3',Rule::unique('users', 'name')],
            'account_type' => 'required',
            'email' => ['required', 'email', Rule::unique('users', 'email')],
            'password' => 'required|min:6',
            'bio' => 'nullable|string|min:10|max:60',
            'contact_info' => 'required|min:10|numeric',
            'social_media' => 'nullable',
            'Facebook_links' => 'nullable|url',
            'Instagram_links' => 'nullable|url',
            'Twitter_links' => 'nullable|url',
            'serviceList' => ['required', 'min:3'],
            'location' => 'required|string',
            'photos' => 'nullable|mimes:jpeg,png,gif'
        ];

        // Validation rules for client fields
        $clientFields = [
            'client-name' => ['required', 'min:3',Rule::unique('users', 'name')],
            'email' => ['required', 'email', Rule::unique('users', 'email')],
            'account_type' => 'required',
            'password' => 'required|min:6',
            'contact_info' => 'required|numeric|min:10',
            'Facebook_links' => 'nullable|url',
            'Instagram_links' => 'nullable|url',
            'Twitter_links' => 'nullable|url',
            'photos' => 'nullable|mimes:jpeg,png,gif'
        ];

        try {
            if ($request->input('account_type') === 'Business') {
                // Validate business data
                $businessValidator = Validator::make($request->all(), $businessFields);

                if ($businessValidator->fails()) {
                    return redirect()->back()->withErrors($businessValidator)->withInput();
                }

                // Save business fields
                $businessData = $request->only(array_keys($businessFields));
                $businessData['social_media'] = $socialMedia;
                $businessData['password'] = $password;
                $businessData['serviceList'] = $request->input('serviceList');

                if ($request->hasFile('photos')) {
                    $logoFile = $request->file('photos');
                    $filename = uniqid() . '_' . $logoFile->getClientOriginalName();
                    $businessData['photos'] = $logoFile->storeAs('logos', $filename, 'public');
                }

                $user = User::create($businessData);
            } elseif ($request->input('account_type') === 'Client') {
                // Validate client data
                $clientValidator = Validator::make($request->all(), $clientFields);

                if ($clientValidator->fails()) {
                    return redirect()->back()->withErrors($clientValidator)->withInput();
                }

                // Save client fields
                $clientData = $request->only(array_keys($clientFields));
                $clientData['social_media'] = $socialMedia;
                $clientData['password'] = $password;
                if ($request->hasFile('photos')) {
                    $logoFile = $request->file('photos');
                    $filename = uniqid() . '_' . $logoFile->getClientOriginalName();
                    $clientData['photos'] = $logoFile->storeAs('logos', $filename, 'public');
                }
                // Save client data to the database

                $user = User::create($clientData);
            }

            auth()->login($user);
            return redirect('/landing')->with('message', 'User created and logged in');
        } catch (\Illuminate\Database\QueryException $e) {
            $errorCode = $e->errorInfo[1];

            if ($errorCode === 1062) { // Duplicate entry error code
                return redirect()->back()->withErrors(['email' => 'The email address is already taken.'])->withInput();
            }

            // Handle other database exceptions or rethrow the exception
            throw $e;
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

        return redirect('/landing')->with('success', 'User deleted successfully.');
    }


}
