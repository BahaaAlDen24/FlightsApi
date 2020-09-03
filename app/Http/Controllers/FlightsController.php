<?php

namespace App\Http\Controllers;

use App\Models\Flights;
use Illuminate\Http\Request;
use mysql_xdevapi\Exception;

class FlightsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            return response(Flights::all(),201)->header('Content-Type','text-plain') ;
        }catch (Exception $exception){
            throw $exception ;
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
        try{

            $Variables = $request->all();
            $MyObject = new Flights();
            $MyObject->fill($Variables)->save() ;

            return response($MyObject,200)->header('Content-Type','text-plain') ;

        }catch (Exception $exception){
            throw $exception ;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Flighttypes  $flighttypes
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {

            $MyObject = Flights::findOrFail($id);

            return response($MyObject, 200)->header('Content-Type', 'text-plain');

        }catch (Exception $exception){
            throw $exception;
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        try {

            $MyObject = Flights::findOrFail($id);
            $Variables = $request->all();
            $MyObject->fill($Variables)->save() ;

            return response($MyObject,200)->header('Content-Type','text-plain') ;

        }catch (Exception $exception){
            throw $exception;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Flighttypes  $flighttypes
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {

            $MyObject = Flights::findOrFail($id);
            $MyObject->delete() ;

            return response($MyObject,200)->header('Content-Type','text-plain') ;

        }catch (Exception $exception){
            throw $exception;
        }
    }
}
