<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Http\Response;


class UserController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        return view('layout/user/profile');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     * @return Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param User $user
     * @return Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function update(Request $request)
    {
        $request->validate([
            'first_name' => 'string|max:255|nullable',
            'last_name' => 'string|max:255|nullable',
            'phone_number' => 'regex:/^([0-9\s\-\+\(\)]*)$/|min:10|nullable',
            'email' => 'required|email|max:255',
            'street' => 'string|max:255|nullable',
            'descriptive_number' => 'string|max:255|nullable',
            'city' => 'string|max:255|nullable',
            'country' => 'string|max:255|nullable',
        ]);

        User::find(Auth()->user()->id)->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'phone_number' => $request->phone_number,
            'email' => $request->email,
            'street' => $request->street,
            'descriptive_number' => $request->descriptive_number,
            'city' => $request->city,
            'country' => $request->country,
        ]);

        $request->session()->flash('message', 'Zmeny boli úspešne uložené.');

        return redirect('profile');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @return Response
     */
    public function destroy(User $user)
    {
        //
    }
}
