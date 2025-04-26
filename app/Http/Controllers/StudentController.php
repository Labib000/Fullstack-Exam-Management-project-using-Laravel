<?php

namespace App\Http\Controllers;

use App\Models\Student; 
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function create()
    {
        
        return view('admin.form');
    }

    public function store(Request $request)
    {
       
        $validated = $request->validate([
            'name'              => 'required|string|max:255',
            'email'             => 'required|email|unique:students,email',
            'phone'             => 'required|string|max:20',
            'password'          =>'required|string|max:20',
            'alt_phone'         => 'nullable|string|max:20',
            'whatsapp'          => 'nullable|string|max:20',
            'dob'               => 'nullable|date',
            'birth_place'       => 'nullable|string|max:255',
            'region'            => 'nullable|string|max:255',
            'caste'             => 'nullable|string|max:255',
            'blood_group'       => 'nullable|string|max:3',
            'identity_details'  => 'nullable|string|max:500',
            'current_address'   => 'nullable|string|max:500',
            'permanent_address' => 'nullable|string|max:500',
            'qualification'     => 'nullable|string|max:255',
            'passing_year'      => 'nullable|digits:4|integer|min:1900|max:' . date('Y'),
            'percentage'        => 'nullable|numeric|min:0|max:100',
            'institution'       => 'nullable|string|max:255',
        ]);

       
        Student::create($request->all());

      
        return redirect()->route('students.create')->with('success', 'Student registered successfully!');
    }

    public function table(){
        return view('table');
    }

    public function edit($id)
    {
        $student = Student::findOrFail($id);
        return view('admin.edit', compact('student'));
    }
}
