<?php

namespace App\Http\Controllers;

use App\Exports\InternsExport;
use App\Http\Requests\CreateInternRequest;
use App\Http\Requests\UpdateInternRequest;
use App\Models\Attendance;
use App\Models\Intern;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class InternController extends Controller
{
    // index
    public function index(){
        return view('intern.interns');

    }

    // store
    public function store(CreateInternRequest $request){
        Intern::create($request->validated());
        return redirect()->route('intern.index')->with('success', 'Intern created successfully.');
    }

    // show individual intern
    public function show($id)
    {
        $intern = Intern::findOrFail($id);
        return view('intern.intern', compact('intern'));
    }

    

    // edit
    public function edit($id){
        $intern = Intern::findOrFail($id);
        return view('intern.edit-intern', compact('intern'));
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



    // export interns
     public function export() 
    {
        return Excel::download(new InternsExport(), 'interns.csv', \Maatwebsite\Excel\Excel::CSV, ['Content-Type' => 'text/csv']);
    }


     public function exportPdf() 
    {
        return Excel::download(new InternsExport(), 'interns.pdf', \Maatwebsite\Excel\Excel::MPDF, ['Content-Type' => 'application/pdf']);
    }
}