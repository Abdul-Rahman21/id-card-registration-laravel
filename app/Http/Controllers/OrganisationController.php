<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use App\Models\organisation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrganisationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $list = organisation::all();
        return view('organisations-list',['list' => $list]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($org_type,$id='')
    {
        $org_type = Str::lower($org_type);
        $find_data = '';
        if($id){
            $find_data = organisation::where('id',$id)->where('organisation_type',$org_type)->first();
            // dd($find_data);
            if($find_data == '')
            {   // if changing url manual need to check and redirect
                return redirect('organisation-list')->withMessage('Something Went Wrong');
            }
        }

        if($org_type == 'college')
        {
            $name = "College Name";
            $standard = "Department";
            $section = "Year";
            $standard_list = DB::select('select id,standard from standards where organisation_type = ?', [$org_type]);
            $section_list = DB::select('select id,sections from sections where organisation_type = ?', [$org_type]);
        }elseif($org_type == 'school'){
            $name = "School Name";
            $standard = "Standard";
            $section = "Section";
            $standard_list = DB::select('select id,standard from standards where organisation_type = ?', [$org_type]);
            $section_list = DB::select('select id,sections from sections where organisation_type = ?', [$org_type]);
        }else{
            return redirect('organisation-list')->withMessage('Something Went Wrong');
        }
        return view('add-organisations',compact('name','standard','section','standard_list','section_list','org_type'))->with('find_data',$find_data);
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
            'org_type' => 'required',
            'organisation_name' => 'required',
            'contact_no' => 'required',
            'standard' => "required|array|min:1",
            "standard.*"  => "required|distinct",
            'section' => 'required|array|min:1',
            'section.*' => 'required|distinct',
            'address' => 'required|min:10|max:500'
        ]);

        $data = [
            'organisation_type' => $request->org_type,
            'organisation_name' => $request->organisation_name,
            'contact_no' => $request->contact_no,
            'standard' => implode(',',$request->standard),
            'sections' => implode(',',$request->section),
            'location' => $request->address,
            'link' => Str::random('10')
        ];

        if($request->id)
        {
            unset($data['link']);
            organisation::where('id',$request->id)->update($data);
            return redirect('organisation-list')->withMessage('Data Updated Successfully');
        }else{
            organisation::insert($data);
            return redirect('organisation-list')->withMessage('Data Added Successfully');
        }

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
        $result = organisation::where('id',$delete_id)->delete();
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
