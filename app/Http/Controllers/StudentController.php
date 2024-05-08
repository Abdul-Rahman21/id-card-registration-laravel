<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\organisation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $filter_org = $filter_std = $filter_sec= '';
        // $list = Student::where('id','!=', '')->get();
        $filter_org = $request->input('org');
        $filter_std = $request->input('standard');
        $filter_sec = $request->input('section');
        $list = Student::query();
        if($filter_std){
            $list->where('standard', '=', $filter_std);
        }
        if($filter_sec){
            $list->where('section', '=', $filter_sec);
        }
        if($filter_org){
            $list->where('organisation', '=', $filter_org);
        }
        $list = $list->get();

        $standard_list = DB::select('select id,standard from standards');
        $section_list = DB::select('select id,sections from sections');
        $org_list = DB::select('select id,organisation_name from organisations');
        return view('student-list',compact('list','org_list','filter_org','standard_list','filter_std','section_list','filter_sec'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        if($id){
            $find_data = Student::where('id',$id)->first();
            // dd($find_data);
            $org_type = $find_data->organisation_type;
            if($org_type == 'college')
            {
                $standard_list = DB::select('select id,standard from standards where organisation_type = ?', [$org_type]);
                $section_list = DB::select('select id,sections from sections where organisation_type = ?', [$org_type]);
            }elseif($org_type == 'school'){
                $standard_list = DB::select('select id,standard from standards where organisation_type = ?', [$org_type]);
                $section_list = DB::select('select id,sections from sections where organisation_type = ?', [$org_type]);
            }
            return view('student-edit',compact('find_data','standard_list','section_list'));
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'name' => 'required',
            'contact_no' => 'required',
            'standard' => "required",
            'section' => 'required',
            'address' => 'required|min:10|max:500',
            'photo' => 'required|max:2048|mimes:pdf,jpg,png,jpeg|image',
        ]);

        if ($image = $request->file('photo')) {
            $destinationPath = 'image/';
            $profileImage = time() . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $profileImage);
            $imageName = "$profileImage";
        }

        $data = [
            'name' => $request->name,
            'contact_no' => $request->contact_no,
            'standard' => $request->standard,
            'section' => $request->section,
            'address' => $request->address,
            'photo' => $imageName,
        ];

        if($request->id)
        {
            Student::where('id',$request->id)->update($data);
        }
        return redirect('student-list')->withMessage('Data Updated Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($link)
    {
        $find_data = organisation::where('link',$link)->first();
        if($find_data == null)
        {
            return redirect('error');
        }

        $org_type = $find_data->organisation_type;
        $standard_list = DB::table('standards')->select('id', 'standard')->where('organisation_type',$org_type)->whereIn('id', explode(',',$find_data->standard))->get();
        $section_list = DB::table('sections')->select('id', 'sections')->where('organisation_type',$org_type)->whereIn('id', explode(',',$find_data->sections))->get();

        return view('student_register',compact('find_data','standard_list','section_list'));
    }

    public function do_register(Request $request)
    {

        $request->validate([
            'name' => 'required',
            'contact_no' => 'required',
            'standard' => "required",
            'section' => 'required',
            'address' => 'required|min:10|max:500',
            'photo' => 'required|max:2048|mimes:pdf,jpg,png,jpeg|image',
        ]);

        if ($image = $request->file('photo')) {
            $destinationPath = 'image/';
            $profileImage = time() . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $profileImage);
            $imageName = "$profileImage";
        }

        $data = [
            'name' => $request->name,
            'contact_no' => $request->contact_no,
            'standard' => $request->standard,
            'section' => $request->section,
            'address' => $request->address,
            'photo' => $imageName,
            'organisation_type' => $request->organisation_type,
            'organisation' => $request->organisation,
        ];

        Student::create($data);
        return Redirect::back()->withMessage('Created Successfully');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $delete_id = $request->id;
        $result = Student::where('id',$delete_id)->delete();
        // return redirect('manage-expenses')->withMessage('Expense Deleted Succesfully');
        $response = 'null';
        if($result)
        {
            $response = 'success';
        }
        echo $response;
        die;
    }
}
