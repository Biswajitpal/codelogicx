<?php

namespace App\Http\Controllers\Api;
use SoftDeletes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VisitorLog;
use App\Models\VisitorMaster;
use Validator;

class VisitorLogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(VisitorLog::get());
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
        $validated = $this->validateVisitor($request);
        $visitorLog = VisitorLog::where('phone_number',$data['phone_number'])->first();
        if($visitorLog){
            $validated['log_id'] = $visitorLog['log_id'];
        }else{
            $validated['log_id'] = uniqid();
            VisitorMaster::create(['log_id' => $validated['log_id']]);
        }
        if(VisitorLog::create($validated))
            return response()->json(['success'=>true , 'msg'=>$validated]);
        else
            return response()->json(['success'=>false]);
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
        $validator = Validator::make($request->all(), [ 
            'first_name' => 'required',
            'last_name' => 'required',
            'phone_number' => 'required',
            'in_time' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['error'=> $validator->errors()]);
        }
        $data=[];
        $input=[];
        $data = $request->all();
        if(isset($data['first_name'])){
            $input['first_name']=$data['first_name'];
        }
        if(isset($data['last_name'])){
            $input['last_name']=$data['last_name'];
        }
        if(isset($data['phone_number'])){
            $input['phone_number']=$data['phone_number'];
        }
        if(isset($data['in_time'])){
            $input['in_time']=$data['in_time'];
        }
        if(isset($data['out_time'])){
            $input['out_time']=$data['out_time'];
        }
        if(VisitorLog::where('id',$id)->update($input))
            return response()->json(['success'=>true]);
        else
            return response()->json(['success'=>false]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(VisitorLog::where('id',$id)->delete())
            return response()->json(['success'=>true]);
        else
            return response()->json(['success'=>false]);
    }

    public function exit(Request $request, $exit_visitor_id){
        $data = [];
        $data = $request->all();
        if(VisitorLog::where('id',$exit_visitor_id)->update(['out_time' => $data['out_time']]))
            return response()->json(['success'=>true]);
        else
            return response()->json(['success'=>false]);
    }

    public function search(Request $request){
        $getdata = VisitorLog::query();
        $data = [];
        $data = $request->all();
        if (!empty($data['from_date']) && !empty($data['to_date'])) {
            //$from_date = strtotime($data['from_date']);
            //$to_date = strtotime($data['to_date']);
            $getdata = $getdata->whereBetween('in_time', [$data['from_date'], $data['to_date']])
                            ->orWhereBetween('out_time', [$data['from_date'], $data['to_date']]);                            
        }
        if (isset($data['phno'])) {
            $getdata = $getdata->where('phone_number', $data['phno']);
        }
        return response()->json($getdata->get());
    }

    public function validateVisitor($request){
        return $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'phone_number' => 'required',
            'in_time' => 'required'
        ]);
    }
}
