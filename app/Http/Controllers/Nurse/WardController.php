<?php

namespace App\Http\Controllers\Nurse;

use App\Http\Controllers\Controller;
use App\Models\Ward;

class WardController extends Controller
{
    public function index()
    {
        $wards = Ward::all();
        return view('nurse.wards.index', ['wards' => $wards]);
    }

    public function admit($id)
    {
        $ward = Ward::findOrFail($id);

        if ($ward->occupied_beds >= $ward->total_beds) {
            return back()->with('error', 'Ward is full — no available beds.');
        }

        $ward->occupied_beds += 1;
        $ward->save();

        return back()->with('success', 'Patient admitted successfully.');
    }

    public function discharge($id)
    {
        $ward = Ward::findOrFail($id);

        if ($ward->occupied_beds <= 0) {
            return back()->with('error', 'No occupied beds to discharge.');
        }

        $ward->occupied_beds -= 1;
        $ward->save();

        return back()->with('success', 'Patient discharged successfully.');
    }
}