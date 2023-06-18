<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAntrianRequest;
use App\Http\Requests\UpdateAntrianRequest;
use App\Models\Antrian;

class AntrianController extends Controller
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
     * @param  \App\Http\Requests\StoreAntrianRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAntrianRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Antrian  $antrian
     * @return \Illuminate\Http\Response
     */
    public function show(Antrian $antrian)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Antrian  $antrian
     * @return \Illuminate\Http\Response
     */
    public function edit(Antrian $antrian)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateAntrianRequest  $request
     * @param  \App\Models\Antrian  $antrian
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAntrianRequest $request, Antrian $antrian)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Antrian  $antrian
     * @return \Illuminate\Http\Response
     */
    public function destroy(Antrian $antrian)
    {
        //
    }
}
