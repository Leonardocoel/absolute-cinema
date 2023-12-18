<?php

namespace App\Http\Controllers\CinemaAdmin;

use App\Models\UserAccount;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserAccountRequest;
use App\Http\Requests\UpdateUserAccountRequest;

class UserAccountController extends Controller
{


    public function __construct()
    {
        $this->authorizeResource(UserAccount::class, 'userAccount');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserAccountRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(UserAccount $userAccount)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(UserAccount $userAccount)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserAccountRequest $request, UserAccount $userAccount)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UserAccount $userAccount)
    {
        //
    }
}
