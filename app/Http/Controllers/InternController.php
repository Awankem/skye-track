<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateInternRequest;
use App\Models\Intern;
use Illuminate\Http\Request;

class InternController extends Controller
{
    // index
    public function index(){
        $interns = Intern::all();
        return view('intern.intern',['interns'=>$interns]);
    }

    // store
    public function store(CreateInternRequest $request){
        Intern::create($request->validated());
        return redirect()->route('intern.index')->with('success', 'Intern created successfully.');
    }
}


