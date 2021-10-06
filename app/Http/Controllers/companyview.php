<?php

namespace App\Http\Controllers;

use App\Models\company;
use App\Models\employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class companyview extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view('companyview.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        //dd($id);
        $company = company::find($id);
        
        //dd($company);
        if ($request->ajax()) {
            $data =  company::find($id)->employee;

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                   
                    $btn = '<div class="form-group">
                    <a href="'.route('employee.edit', $row->id).'" class="link btn btn-outline-success"><i class="fa fa-edit"></i></a>
                    <button type="button" class="btn btn-danger product_delete" data-toggle="modal" data-target="#modalConfirmDelete" data-id="' . $row->id . '" ><i class="fa fa-trash"></i></button></div>';
                    return $btn;
                })
        ->rawColumns(['action'])
                ->make(true);
        }
        return view('companyview.show',compact('company'));
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
    public function destroy($id)
    {
        //
    }
}
