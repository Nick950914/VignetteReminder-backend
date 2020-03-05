<?php

namespace App\Http\Controllers;

use App\Reminder;
use Validator;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;

class RemindersController extends Controller
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
        if (Auth::User()->vehicles->contains('id', $request->vehicle_id)) {

            $v = Validator::make($request->all(), [
                'title' => 'required|min:3|regex:/(^[\pL0-9 ]+)$/u',
                'changed_on' => 'required|date|before:tomorrow',
                'due_change_date' => 'required|date|after:today',
            ]);

            if ($v->fails())
            {
                return response()->json([
                    'status' => 'error',
                    'errors' => $v->errors()
                ], 422);
            }

            $reminder = new Reminder();
            $reminder->user_id = Auth::user()->id;
            $reminder->vehicle_id = $request->vehicle_id;
            $reminder->title = $request->title;
            $reminder->changed_on = $request->changed_on;
            $reminder->due_change_date = $request->due_change_date;
            $reminder->note = $request->note;
            $reminder->save();

            return response()->json(['status' => 'success'], 200);
        } else {
            abort(401);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Reminder  $reminder
     * @return \Illuminate\Http\Response
     */
    public function show(Reminder $reminder)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Reminder  $reminder
     * @return \Illuminate\Http\Response
     */
    public function edit(Reminder $reminder)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Reminder  $reminder
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Reminder $reminder)
    {
        //
        if (Auth::User()->vehicles->contains('id', $request->vehicle_id)) {

            $new_date = Carbon::parse($request->changed_on)->addDays(3);
            $new_date->toDateString();

            $v = Validator::make($request->all(), [
                'title' => 'required|min:3|regex:/(^[\pL0-9 ]+)$/u',
                'changed_on' => 'required|date|before:tomorrow',
                'due_change_date' => 'required|date|after:' . $new_date,
            ]);

            if ($v->fails())
            {
                return response()->json([
                    'status' => 'error',
                    'errors' => $v->errors()
                ], 422);
            }

            $reminder->title = $request->title;
            $reminder->changed_on = $request->changed_on;
            $reminder->due_change_date = $request->due_change_date;
            $reminder->note = $request->note;
            $reminder->save();

            return response()->json(['status' => 'success'], 200);
        } else {
            abort(401);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Reminder  $reminder
     * @return \Illuminate\Http\Response
     */
    public function destroy(Reminder $reminder)
    {
        //
        if (Auth::User()->vehicles->contains('id', $reminder->vehicle_id)) {
            $reminder->delete();
        } else {
            abort(401);
        }
    }
}
