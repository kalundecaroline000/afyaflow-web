<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ward;
use Illuminate\Http\Request;

class WardController extends Controller
{
    public function index()
    {
        $wards = Ward::all();
        return view('admin.wards.index', ['wards' => $wards]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'total_beds' => ['required', 'integer', 'min:1'],
        ]);

        Ward::create([
            'name' => $request->name,
            'total_beds' => $request->total_beds,
            'occupied_beds' => 0,
        ]);

        return back()->with('success', 'Ward created successfully.');
    }

    public function destroy($id)
    {
        Ward::findOrFail($id)->delete();
        return back()->with('success', 'Ward deleted.');
    }
}