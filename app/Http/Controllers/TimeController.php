<?php

namespace App\Http\Controllers;
use App\Models\Time;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
class TimeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $id)
    {
        $user = auth()->user();
        $times = Time::where('user_id', $id)->get();
        $searchTerm = $request->input('search');
        $filteredUsers = User::filter(['search' => $searchTerm])->paginate(10);
        return view('time.index', compact('user','times','filteredUsers'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $searchTerm = $request->input('search');
        $filteredUsers = User::filter(['search' => $searchTerm])->paginate(10);
        return view('time.create',compact('filteredUsers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'monday-start' => 'required_if:monday-checkbox,on',
            'monday-end' => 'required_if:monday-checkbox,on',
            'tuesday-start' => 'required_if:tuesday-checkbox,on',
            'tuesday-end' => 'required_if:tuesday-checkbox,on',
            'wednesday-start' => 'required_if:wednesday-checkbox,on',
            'wednesday-end' => 'required_if:wednesday-checkbox,on',
            'thursday-start' => 'required_if:thursday-checkbox,on',
            'thursday-end' => 'required_if:thursday-checkbox,on',
            'friday-start' => 'required_if:friday-checkbox,on',
            'friday-end' => 'required_if:friday-checkbox,on',
            'saturday-start' => 'required_if:saturday-checkbox,on',
            'saturday-end' => 'required_if:saturday-checkbox,on',
            'sunday-start' => 'required_if:sunday-checkbox,on',
            'sunday-end' => 'required_if:sunday-checkbox,on',

        ];

        $messages = [
            'monday-start.required_if' => 'Please provide the start time for Monday.',
            'monday-end.required_if' => 'Please provide the end time for Monday.',
            'tuesday-start.required_if' => 'Please provide the start time for Tuesday.',
            'tuesday-end.required_if' => 'Please provide the end time for Tuesday.',
            'wednesday-start.required_if' => 'Please provide the start time for Wednesday.',
            'wednesday-end.required_if' => 'Please provide the end time for Wednesday.',
            'thursday-start.required_if' => 'Please provide the start time for Thursday.',
            'thursday-end.required_if' => 'Please provide the end time for Thursday.',
            'friday-start.required_if' => 'Please provide the start time for Friday.',
            'friday-end.required_if' => 'Please provide the end time for Friday.',
            'saturday-start.required_if' => 'Please provide the start time for Saturday.',
            'saturday-end.required_if' => 'Please provide the end time for Saturday.',
            'sunday-start.required_if' => 'Please provide the start time for Sunday.',
            'sunday-end.required_if' => 'Please provide the end time for Sunday.',
        ];

        $validator = Validator::make($request->except('_token'), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $validatedData = $validator->validated();
//
// Perform further actions with the validated data
        $validatedData['user_id'] = Auth::user()->id;
//        dd($validatedData);

        Time::create($validatedData);

        return redirect('/getTime/' . \auth()->user()->id)->with('success', 'Time saved successfully.');
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


}
