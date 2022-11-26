<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreStrands;
use App\Models\Strands;
use Illuminate\Http\Request;

class StrandsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $all_strands = Strands::withTrashed()->get();

        
        return view('admin.strand.index', ['allStrands'=>$all_strands]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.strand.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreStrands $request)
    {
        $validatedData = $request->validated();

        $new_strand = new Strands();
        $new_strand->create([
            'name' => $validatedData['strand'],
        ]);

        return redirect()->route('admin.strand.index')->with('status', "Strand {$new_strand->name} was successfully created");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Strands $strand)
    {
        return view('admin.strand.edit', ['strand'=>$strand]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreStrands $request, Strands $strand)
    {
        $validatedData = $request->validated();
        $strand->update([
            'name' => $validatedData['strand']
        ]);
        return redirect()->route('admin.strand.index')->with('status', "Strand {$strand->name} was successfully updated");
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Strands $strand)
    {
        $strand->delete();
        return redirect()->route('admin.strand.index')->with('status', "Strand {$strand->name} was successfully deleted");
    }

    public function restore($id){
        $strand = Strands::withTrashed()->findOrFail($id);
        $strand->restore();
        return redirect()->route('admin.strand.index')->with('status', "Strand {$strand->name} was successfully restored");
    }   


    public function forceDelete($id){
        $strand = Strands::withTrashed()->findOrFail($id);
        $strand->forceDelete();
        return redirect()->route('admin.strand.index')->with('status', "Strand {$strand->name} was deleted permanently");
    }
}
