<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateInternRequest;
use App\Http\Requests\UpdateInternRequest;
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

    // show individual intern
    public function show($id){
        $intern = Intern::findOrFail($id);
        return view('intern.show', compact('intern'));
    }

    // edit
    public function edit($id){
        $intern = Intern::findOrFail($id);
        return view('intern.edit-intern', ['intern' => $intern]);
    }

    // update
    public function update(UpdateInternRequest $request, $id){
        try {
            $intern = Intern::findOrFail($id);
            $intern->update($request->validated());
            
            return redirect()->route('intern.index')
                ->with('success', 'Intern updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to update intern. Please try again.');
        }
    }

    // delete
    public function destroy($id){
        try {
            $intern = Intern::findOrFail($id);
            $intern->delete();
            
            return redirect()->route('intern.index')
                ->with('success', 'Intern deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to delete intern. Please try again.');
        }
    }

    // create form
    public function create(){
        return view('intern.create');
    }
}