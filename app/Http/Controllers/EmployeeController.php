<?php

namespace App\Http\Controllers;

use App\Models\employee;
use Illuminate\Http\Request;
use Illuminate\Contracts\Validation\Validator;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        
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
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|max:20',
            'last_name' => 'required|max:20',
            'email' => 'required',
            'phone' => 'required|',
            // 'icon' => 'required| mimes:jpeg,bmp,png',
        ]);
        if (!$validator->passes()) {
            return response()->json(['error'=>$validator->errors()->all()]);
        } else {
            
            $employee = new employee();
            $employee->first_name = $request->first_name;
            $employee->last_name = $request->last_name;
            $employee->email = $request->email;
            $employee->company_id = $request->cid;
            $employee->phone = $request->phone;
            
    
            $save = $employee->save();
        }
     
     
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function show(employee $employee)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $employee = employee::find($id);
        return view('employess.edit',compact('employee'));
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        
        $request->validate([
            'first_name' => 'required|max:s20',
            'last_name' => 'required|max:255',
            'email' => 'required|email ',
            'phone' => 'required',
        ]);
        $employee = employee::find($id);
        $employee->first_name = $request->first_name;
        $employee->last_name = $request->last_name;
        $employee->email = $request->email;
        $employee->company_id = $request->cid;
        $employee->phone = $request->phone;
       
      
        $save = $employee->save();

         return redirect()->route('companyview.show', $request->cid);
       
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function destroy(employee $employee)
    {
        //
    }
}
