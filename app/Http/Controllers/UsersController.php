<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User as UserModel;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        return view('my-profile')->with('user', auth()->user());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // return $request->all();
        // $request->validate([
        //     'name' => 'required|string|max:255',
        //     'email' => 'required|string|email|max:255|unique:users,email,'.auth()->id(),
        //     'password' => 'sometimes|nullable|string|min:6|confirmed',
        // ]);

        // $user = auth()->user();
        // $input = $request->except('password', 'password_confirmation');

        // if (! $request->filled('password')) {
        //     $user->fill($input)->save();

        //     return back()->with('success_message', 'Profile updated successfully!');
        // }

        // $user->password = bcrypt($request->password);
        // $user->fill($input)->save();


        $email_counter = UserModel::where('email','!=',$request->input('get_email'))->where('email','=',$request->input('email'))->count();

        if ($email_counter > 0) 
        {
             return back()->with('success_message', 'Email Already Exist!');
        }

        if($request->input('password') != null)
        {
            if ($request->input('password') != $request->input('password_confirmation')) 
            {
               return back()->with('success_message', 'Password does not match!');
            }
        }


        if($request->input('password') == null)
        {
            $data = [
                'name' => $request->input('name'),
                'email' => $request->input('email'),
            ];
        }

        if ($request->input('password') != null && $request->input('password') != null) 
        {
            $data = [
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => $request->input('password'),
            ];
        }


        UserModel::where('id','=',$request->input('get_id'))->update($data);

        return back()->with('success_message', 'Profile (and password) updated successfully!');
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
