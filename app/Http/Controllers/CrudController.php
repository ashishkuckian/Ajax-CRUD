<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\ChatModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CrudController extends Controller
{
    //here we will perform crud operations..

    public function showAllCars(){
        $allcars = Car::all();
        // create the view to display all cars
        return view('allcars',compact('allcars'));
    }

    public function addCar(Request $request){
        // perform form validation here
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'manufacture_year' => 'required',
            'engine_capacity' => 'required',
            'fuel_type' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['msg' => $validator->errors()->toArray()]);
        }else{
            try {
                $addCar = new Car;
                $addCar->name = $request->name;
                $addCar->manufacture_year = $request->manufacture_year;
                $addCar->engine_capacity = $request->engine_capacity;
                $addCar->fuel_type = $request->fuel_type;
                $addCar->save();
                return response()->json(['success' => true, 'msg' => 'car added successfully']);
                
            } catch (\Exception $e) {
                return response()->json(['success' => false, 'msg' => $e->getMessage()]);
            }
        }

    }

    // delete functionality
    public function deleteCar($car_id)
    {
        $car = Car::find($car_id);
        if (!$car) {
            return response()->json(['success' => false, 'msg' => 'Car not found.']);
        }
        $car->delete();
        return response()->json(['success' => true, 'msg' => 'Car deleted successfully.']);
    }



    // edit car functionality
    public function editCar(Request $request){
        // validate form
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'manufacture_year' => 'required',
            'engine_capacity' => 'required',
            'fuel_type' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['msg' => $validator->errors()->toArray()]);
        }else{
            // perform edit functionality here
            try {
                // so the car was not updated because of naming of id field input from form
                Car::where('id',$request->car_id)->update([
                    'name' => $request->name,
                    'manufacture_year' => $request->manufacture_year,
                    'engine_capacity' => $request->engine_capacity,
                    'fuel_type' => $request->fuel_type,
                ]);

                return response()->json(['success' => true, 'msg' => 'car updated successfully']);

            } catch (\Exception $e) {
                return response()->json(['success' => false, 'msg' => $e->getMessage()]);

            }
            
        }

    }
    
}