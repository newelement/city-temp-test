<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Carbon\Carbon;
use App\Models\Location;

class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $locations = Location::
                    orderBy('temperature_date', 'desc')
                    ->orderBy('city')
                    ->paginate(20);

        return view('index', ['locations' => $locations]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Yes I'm aware I can add custom request classes to handle validation.
        // Keeping it short and sweet for this. -- Don
        $request->validate([
           'country' => 'required|max:255',
           'city' => ['required', 'max:255', Rule::unique('locations')->where(function ($query) use ($request) {
               return $query->where('city', $request->city)
                     ->whereDate('temperature_date', Carbon::create($request->temperature_date));
           })
           ],
           'temperature' => 'required|max:3',
           'temperature_scale' => 'required',
           'temperature_date' => 'required'
        ]);

        try {
            $location = new location();
            $location->country = $request->country;
            $location->city = $request->city;
            $location->temperature = (int) $request->temperature;
            $location->temperature_scale = $request->temperature_scale;
            $location->temperature_date = $request->temperature_date;
            $location->save();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'There was a problem adding location. '.$e->getMessage());
        }

        return redirect()->back()->with('success', 'Location added.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $location = Location::findOrFail($id);
        return view('edit', ['location' => $location]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        // Yes I'm aware I can add custom request classes to handle validation.
        // Keeping it short and sweet for this. -- Don
        $request->validate([
           'country' => 'required|max:255',
           'city' => ['required', 'max:255', Rule::unique('locations')->where(function ($query) use ($request, $id) {
               return $query->where('city', $request->city)
                     ->whereDate('temperature_date', Carbon::create($request->temperature_date))
                     ->where('id', '<>', $id);
           })
           ],
           'temperature' => 'required|max:3',
           'temperature_scale' => 'required',
           'temperature_date' => 'required'
        ]);

        try {
            $location = Location::findOrFail($id);
            $location->country = $request->country;
            $location->city = $request->city;
            $location->temperature = (int) $request->temperature;
            $location->temperature_scale = $request->temperature_scale;
            $location->temperature_date = $request->temperature_date;
            $location->save();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'There was a problem updating location. '.$e->getMessage());
        }

        return redirect('/')->with('success', 'Location updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $location = Location::findOrFail($id);
        $location->delete();

        return redirect()->back()->with('success', 'Location deleted.');
    }
}
