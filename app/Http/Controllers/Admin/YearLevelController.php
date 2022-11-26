<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreYearLevel;
use App\Models\Section;
use App\Models\YearLevel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class YearLevelController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('user_access:admin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $allYearLevel = Cache::remember('allYearLevel', 60, function(){
            // return YearLevel::withTrashed()->get();
            return DB::table('year_levels')->select(['*'])->get();
        });

        // dd($allYearLevel);

        return view('admin.year_level.index', ['allYearLevel'=>$allYearLevel]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.year_level.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreYearLevel $request)
    {
        $validatedData = $request->validated();

        $yL = new YearLevel();
        $yL->level = $validatedData['level'];
        $yL->save();

        return redirect()->route('admin.year.index')->with('status', "Grade level $yL->level was successfully added ");
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $yL = YearLevel::findOrFail($id);

        return view('admin.year_level.edit', ['year'=>$yL]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreYearLevel $request, $id)
    {

        $yL = YearLevel::findOrFail($id);

        $validatedData = $request->validated();

        $yL->fill($validatedData);
        $yL->save();

        return redirect()->route('admin.year.index')->with('status', "Grade level $yL->level was successfully updated ");

        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $yL = YearLevel::findOrFail($id);
        $yL->delete();
        
        
        
        return redirect()->route('admin.year.index')->with('status', "Grade level was successfully deleted ");

    }

    /**
     * Restore the specified resource
     * 
     * @param int $d
     * @return \Illuminate\Http\Response
     */
    public function restore($id){        
        $yL = YearLevel::withTrashed()->findOrFail($id);
        $yL->restore();
        
        return redirect()->route('admin.year.index')->with('status', "Grade level was successfully restored ");
    }

    /**
     * Force delete the specified resource
     * 
     * @param int $id
     * @return \Illuminate\Http\Respone
     * 
     */
    public function forceDelete($id){
        
        $yL = YearLevel::withTrashed()->findOrFail($id);
        

        // $section = $yL->sections()->withTrashed()->get();
        // $section->each(function($item){
        //     $student = $item->students()->withTrashed()->get();
        //     $student->each(function($st){
        //         Storage::disk('public')->delete($st->qr_code->path);
        //     });
        // });
        
        $yL->forceDelete();

        // YearLevel::where('id', $id)->withTrashed()->forceDelete();
        
        return redirect()->route('admin.year.index')->with('status', "Grade level was deleted permanently ");
    }

    /**
     * GET THE SECTION UNDER THE LEVELS
     * 
     * @param int @id
     * @return \Illuminate\Http\Response
     */
    public function getSection($level,$strand){

        // $levels_section = YearLevel::with('sections')->findOrFail($level);

        // // return $levels_section;
        // $section = $levels_section->sections()->get();

        $section = Section::where('year_level_id', '=', $level)
                                ->where('strands_id', '=', $strand)->get();
        

        if(count($section) > 0 ){
            return response()->json($section);
            
        }

    }
}
