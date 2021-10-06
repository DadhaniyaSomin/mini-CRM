<?php

namespace App\Http\Controllers;

use App\Models\company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class companyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {


        if ($request->ajax()) {
            $data = company::get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {

                    $btn = '<div class="form-group">
                            <a href="' . route('companyview.show', $row->id) . '" class="link btn btn-outline-warning"><i class="fa fa-eye"></i></a>
                            <a href="' . route('company.edit', $row->id) . '" class="link btn btn-outline-success"><i class="fa fa-edit"></i></a>
                            <button type="button" class="btn btn-danger product_delete" data-toggle="modal" data-target="#modalConfirmDelete" data-id="' . $row->id . '" ><i class="fa fa-trash"></i></button></div>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('company.index');
    }

    /**
     * Show the form for creatings a new resource.
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
        
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:20',
            'email' => 'required',
            'website' => 'required|url ',
            'icon' => 'required| mimes:jpeg,bmp,png',
        ]);
        if (!$validator->passes()) {
            return response()->json(['error'=>$validator->errors()->all()]);
        } else {
            if ($request->has('icon')) {
                // dd($request->has('image'));
                $file = $request->file('icon');
                $filename = time() . '.' . $file->getClientOriginalExtension();
                $path = "/icon";
                $dd = $file->move(public_path($path), $filename);
            }
            $company = new company();
            $company->name = $request->name;
            $company->email = $request->email;
            $company->website = $request->website;
            $company->logo = isset($filename) ? $filename : "";
            // dd($products);

            $save = $company->save();
            if ($save) {
                
                return redirect()->route('company.index');
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\company  $company
     * @return \Illuminate\Http\Response
     */
    public function show(company $company)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\company  $company
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $company1 = company::where('id', $id)->first();
        //dd($company1);
        return view('company.edit', compact('company1'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\company  $company
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {


        $company = company::find($id)->first();
        $company->name = $request->name;
        $company->email = $request->email;
        $company->website = $request->website;
        // dd($products);

        $save = $company->save();
        if ($save) {
            return redirect()->route('company.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\company  $company
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        company::find($id)->delete();
        return redirect()->route('company.index');
    }
}
