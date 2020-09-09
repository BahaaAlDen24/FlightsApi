<?php

namespace App\Http\Controllers;

use App\Models\Flightoffers;
use Illuminate\Http\Request;
use mysql_xdevapi\Exception;

class FlightOffersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            return response(Flightoffers::all(),201)->header('Content-Type','text-plain') ;
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
            $MyObject = new Flightoffers();
            $MyObject->fill($Variables['data']) ;
            $ImagesSRC[] = array() ;
            for ($i = 1 ; $i < 5 ;$i++){
                $ServerPath = "" ;
                if ($files = $request->file('IMGSRC' . $i)) {
                    request()->validate(['IMGSRC' . $i  => 'required|mimes:jpg,png|max:2048',]);

                    $files = $request->file('IMGSRC' . $i);

                    $destinationPath = 'FlightoffersFile/'; // upload path
                    $profilefile = date('YmdHis') . $files->getClientOriginalName();
                    $ServerPath = $files->move($destinationPath, $profilefile);

                }
                $ImagesSRC[$i] = $ServerPath ;
            }

            $MyObject->IMGSRC1 = $ImagesSRC[1] ;
            $MyObject->IMGSRC2 = $ImagesSRC[2] ;
            $MyObject->IMGSRC3 = $ImagesSRC[3] ;
            $MyObject->IMGSRC4 = $ImagesSRC[4] ;

            $MyObject->save();

            $MyObject = Flightoffers::findOrFail($MyObject->id);

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

            $MyObject = Flightoffers::findOrFail($id);

            return response( $MyObject, 200)->header('Content-Type', 'text-plain');

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

            $Variables = $request->all();
            $Variables2 = $request->getContent();
            $MyObject = Flightoffers::findOrFail($id);
            $MyObject->fill($Variables['data']) ;
            $ImagesSRC[] = array() ;
            for ($i = 1 ; $i < 5 ;$i++){
                $ServerPath = "" ;
                if ($files = $request->file('IMGSRC' . $i)) {
                    request()->validate(['IMGSRC' . $i  => 'required|mimes:jpg,png|max:2048',]);

                    $files = $request->file('IMGSRC' . $i);

                    $destinationPath = 'FlightoffersFile/'; // upload path
                    $profilefile = date('YmdHis') . $files->getClientOriginalName();
                    $ServerPath = $files->move($destinationPath, $profilefile);

                }
                $ImagesSRC[$i] = $ServerPath ;
            }

            $MyObject->IMGSRC1 = $ImagesSRC[1] ;
            $MyObject->IMGSRC2 = $ImagesSRC[2] ;
            $MyObject->IMGSRC3 = $ImagesSRC[3] ;
            $MyObject->IMGSRC4 = $ImagesSRC[4] ;

            $MyObject->save();

            $MyObject = Flightoffers::findOrFail($MyObject->id);

            return response($MyObject,200)->header('Content-Type','text-plain') ;

        }catch (Exception $exception){
            throw $exception ;
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

            $MyObject = Flightoffers::findOrFail($id);
            $MyObject->delete() ;

            return response($MyObject,200)->header('Content-Type','text-plain') ;

        }catch (Exception $exception){
            throw $exception;
        }
    }
}
