<?php

namespace App\Http\Controllers;

use App\Vehicle;
use Illuminate\Http\Request;
use App\User;
use Auth;
use Validator;

class VehiclesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        // $vehicles = Vehicle::latest()->where('user_id', Auth::User()->id)->get();
        // return $vehicles;
        return Auth::User()->vehicles;
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
        if (isset(Auth::user()->id)) {

            $v = Validator::make($request->all(), [
                'name' => 'required|min:3|regex:/(^[\pL0-9 ]+)$/u',
                'vehicle_reg_no' => 'required|min:8|regex:/(^[\pL0-9 ]+)$/u',
//                'vignette_reg_no' => 'regex:/(^[\pL0-9 ]+)$/u',
                'frame_no' => 'regex:/(^[\pL0-9 ]+)$/u',
                'sticker_no' => 'regex:/(^[\pL0-9 ]+)$/u',
            ]);

            if ($v->fails())
            {
                return response()->json([
                    'status' => 'error',
                    'errors' => $v->errors()
                ], 422);
            }
            $vehicle = new Vehicle();
            $vehicle->user_id = Auth::user()->id;
            $vehicle->name = $request->name;
            $vehicle->vehicle_reg_no = $request->vehicle_reg_no;
//            $vehicle->vignette_reg_no = $request->vignette_reg_no;
            $vehicle->frame_no = $request->frame_no;
            $vehicle->sticker_no = $request->sticker_no;
            $vehicle->save();

            return response()->json(['status' => 'success', 'id' => $vehicle->id], 200);
        } else {
            abort(401);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Vehicle  $vehicle
     * @return \Illuminate\Http\Response
     */
    public function show(Vehicle $vehicle)
    {
        //
        if ($vehicle->user_id === Auth::User()->id) {
          return $vehicle;
        } else {
            abort(404);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Vehicle  $vehicle
     * @return \Illuminate\Http\Response
     */
    public function showVehicleReminders(Vehicle $vehicle)
    {
        //
        if ($vehicle->user_id === Auth::User()->id) {
          return $vehicle->reminders;
        } else {
            abort(404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Vehicle  $vehicle
     * @return \Illuminate\Http\Response
     */
    public function edit(Vehicle $vehicle)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Vehicle  $vehicle
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Vehicle $vehicle)
    {
        //
        if ($vehicle->user_id === Auth::User()->id) {

            $v = Validator::make($request->all(), [
                'name' => 'required|min:3|regex:/(^[\pL0-9 ]+)$/u',
                'vehicle_reg_no' => 'required|min:8|regex:/(^[\pL0-9 ]+)$/u',
//                'vignette_reg_no' => 'regex:/(^[\pL0-9 ]+)$/u',
                'frame_no' => 'regex:/(^[\pL0-9 ]+)$/u',
                'sticker_no' => 'regex:/(^[\pL0-9 ]+)$/u',
            ]);

            if ($v->fails())
            {
                return response()->json([
                    'status' => 'error',
                    'errors' => $v->errors()
                ], 422);
            }

            $vehicle->name = $request->name;
            $vehicle->vehicle_reg_no = $request->vehicle_reg_no;
//            $vehicle->vignette_reg_no = $request->vignette_reg_no;
            $vehicle->frame_no = $request->frame_no;
            $vehicle->sticker_no = $request->sticker_no;
            $vehicle->save();

            return response()->json(['status' => 'success'], 200);
        } else {
            abort(401);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Vehicle  $vehicle
     * @return \Illuminate\Http\Response
     */
    public function destroy(Vehicle $vehicle)
    {
        //
        if ($vehicle->user_id === Auth::User()->id) {
            $vehicle->delete();
        } else {
            abort(401);
        }
    }

}
