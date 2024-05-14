<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\City;

class CityController extends Controller
{
    

    public function store(Request $request){

        $city= new City;

        $city->state_id=$request->state_id;
        $city->city_name=$request->city_name;
        $results=$city->save();

        if($results){
            return response()->json([
                'message'=>"data inserted succesfully",
                'code'=>200,
            ]);
        }
        else{
            return response()->json([
            'message'=>"Internal server Error",
            'code'=>500
          ]);
        }
    }

    public function index()
    {
        // dd('test');
        $cities=City::select('cities.id','cities.city_name','st.state_name','cities.status')->join('states as st','st.id','=','cities.state_id')->get();
// dd($cities);
        if($cities){
            return response()->json([
                'message'=>"Data found succesfully",
                'code'=>200,
                'cities'=>$cities,
            ]);
        }
        else{
            return response()->json([
            'message'=>"Internal server Error",
            'code'=>500
          ]);
        }
    }

    public function edit(Request $request)
    {
        // dd($request->all());
           $result=City::where('id',$request->id)->first();

           if($result){
            return response()->json([
                'message'=>"Data found succesfully",
                'code'=>200,
                'data'=>$result,
            ]);
        }
        else{
            return response()->json([
            'message'=>"Internal server Error",
            'code'=>500
          ]);
        }
    }

    public function update(Request $request)
    {
        //    dd($request->all());
 
        $result=City::where('id',$request->id)->update([
             "city_name"=>$request->edit_city_name,
             "state_id"=>$request->edit_state_id,
             "status"=>$request->edit_status
        ]);

        if($result){
            return response()->json([
                'message'=>"Data Updated succesfully",
                'code'=>200,
                'data'=>$result,
            ]);
        }
        else{
            return response()->json([
            'message'=>"Internal server Error",
            'code'=>500
          ]);
        }
    }

    public function destroy(Request $request){

        $result=City::where('id',$request->id)->delete();
        // $result=City::find($request->id);
        // $result->delete();

        if($result){
            return response()->json([
                'message'=>"Data deleted succesfully",
                'code'=>200,
                'data'=>$result,
            ]);
        }
        else{
            return response()->json([
            'message'=>"Internal server Error",
            'code'=>500
          ]);
        }
    }
}
