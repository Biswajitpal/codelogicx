<?php

namespace App\Http\Controllers\users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Employees;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employee = Employees::get();
        if(isset($employee))
            return response()->json(['data'=>$employee,'success'=>true]);
        else
            return response()->json(['data'=>"Empty list",'success'=>false]);
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
        //echo "send form data";
        $data = $request->all();
        
       // $input['skil'] = uniqid();
       //dd();
       //Employees::create();
       //Employees::truncate();
        //return Employees::create(["name"=>"sanjoy"])->toSql();
        $employee = Employees::create($data['content']);
        if(isset($employee))
            return response()->json(['data'=>$employee,'success'=>true]);
        else
            return response()->json(['data'=>$employee,'success'=>false]);
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
        $data=[];
        $input=[];
        $data = $request->all();
        $data = $data['content'];
        if(isset($data['name'])){
            $input['name']=$data['name'];
        }
        if(isset($data['email'])){
            $input['email']=$data['email'];
        }
        if(isset($data['exprience'])){
            $input['exprience']=$data['exprience'];
        }
        if(isset($data['interests'])){
            $input['interests']=$data['interests'];
        }
        if(isset($data['skil'])){
            $input['skil']=$data['skil'];
        }
        $employee = Employees::where('id',$id)->update($input);
        if($employee )
            return response()->json(['data'=>$employee, 'success'=>true]);
        else
            return response()->json(['data'=>$employee, 'success'=>false]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       // echo "delete";
        
        return response()->json(['data'=>Employees::where('id',$id)->delete(),'success'=>true]);
    }
}
