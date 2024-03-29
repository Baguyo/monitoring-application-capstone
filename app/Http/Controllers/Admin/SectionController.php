<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSection;
use App\Models\Section;
use App\Models\Strands;
use App\Models\YearLevel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class SectionController extends Controller
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
        $all_sections = Cache::remember('allSections', 60, function(){
            // return Section::withTrashed()->with(['yearLevel'=> fn($q) => $q->withTrashed()])->get();
            return DB::table('sections')
                    ->join('year_levels', 'year_levels.id', 'sections.year_level_id')
                    ->join('strands', 'strands.id', 'sections.strands_id')
                    ->select('sections.id as section_id', 'sections.name', 'sections.created_at', 'sections.updated_at',
                            'sections.deleted_at',
                        'year_levels.level as year_level',
                        'strands.name as strand_name')->get();
        });

        // dd($all_sections);
        
        return view('admin.section.index', ['all_sections' => $all_sections]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $all_year_level = YearLevel::all();
        $all_strands = Strands::all();
        return view('admin.section.create', ['all_year_level'=>$all_year_level, 'all_strands'=>$all_strands]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSection $request)
    {
        $validatedData = $request->validated();

        $yL = YearLevel::findOrFail($validatedData['level']);
        $strand = Strands::findOrFail($validatedData['strand']);

        $section = new Section();

        $section->name = $validatedData['section'];

        $section->yearLevel()->associate($yL);
        $section->strands()->associate($strand)->save();
        

        return redirect()->route('admin.section.index')->with('status', "Section {$section->name} was successfully created");
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
        

        $section_to_edit = Section::with('yearLevel')->with('strands')->findOrFail($id);

        $yL = YearLevel::all()->except($section_to_edit->yearLevel->id);
        $strands = Strands::all()->except($section_to_edit->strands->id);

        // dd($yL);
        
        return view('admin.section.edit', ['all_year_level' => $yL, 'section_to_edit'=>$section_to_edit, 'strands'=>$strands]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreSection $request, Section $section)
    {
        
        $validatedData = $request->validated();

        $section->name = $validatedData['section'];
        $section->year_level_id = $validatedData['level'];
        $section->strands_id = $validatedData['strand'];

        $section->save();

        return redirect()->route('admin.section.index')->with('status', "Section {$section->name} was successfully updated"); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy( Section $section)
    {
        $section->delete();
        return redirect()->route('admin.section.index')->with('status', "Section {$section->name} was successfully deleted");
    }

    /**
     * Restore the specified resource from storage
     * 
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        $section = Section::withTrashed()->findOrFail($id);
        $section->restore();
        return redirect()->route('admin.section.index')->with('status', "Section was successfully restored");
    }

    /**
     * Delete permanently the specified resource from storage
     * 
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function forceDelete($id)
    {
        $section = Section::withTrashed()->findOrFail($id);
        $section->forceDelete();
        return redirect()->route('admin.section.index')->with('status', "Section was deleted permantly");   
    }

    public function getStudents($id){
        $section = Section::with('students')->findOrFail($id);

        // return $section;
        $students = $section->students()->with('user')->get();
        

        if(count($students) > 0 ){
            return response()->json($students);
            // return "pota";
        }
    }
}
