<?php

namespace App\Http\Controllers;

use App\Models\Bookedflights;
use Hamcrest\Core\IsNull;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use mysql_xdevapi\Exception;

class BookedFlightsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            $data = DB::table('bookedflights')
                ->leftJoin('canceledflights', 'bookedflights.id', '=', 'canceledflights.BOOKEDFLIGHTID')
                ->join('users', 'users.id', '=', 'bookedflights.USERID')
                ->join('flights', 'flights.id', '=', 'bookedflights.FLIGHTID')
                ->join('airports as AirportFrom', 'flights.FROMID', '=', 'AirportFrom.id')
                ->join('airports as AirportTo', 'flights.TOID', '=', 'AirportTo.id')
                ->join('cities as CityFrom', 'AirportFrom.CITYID', '=', 'CityFrom.id')
                ->join('cities as CityTo', 'AirportTo.CITYID', '=', 'CityTo.id')
                ->whereNull('canceledflights.id')
                ->select('bookedflights.*','users.name as UserName',DB::raw('CONCAT(AirportFrom.ENAME,"-",CityFrom.ENAME," ==> ",AirportTo.ENAME,"-",CityTo.ENAME) as FlightInfo'))
                ->get();
            return response($data,201)->header('Content-Type','text-plain') ;
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
        $Variables = $request->all();
        $MyObject = new BookedFlights();
        $MyObject->fill($Variables)->save() ;
        return response($MyObject,200)->header('Content-Type','text-plain') ;
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
            $data = DB::table('bookedflights')
                ->leftJoin('canceledflights', 'bookedflights.id', '=', 'canceledflights.BOOKEDFLIGHTID')
                ->join('users', 'users.id', '=', 'bookedflights.USERID')
                ->join('flights', 'flights.id', '=', 'bookedflights.FLIGHTID')
                ->join('airports as AirportFrom', 'flights.FROMID', '=', 'AirportFrom.id')
                ->join('airports as AirportTo', 'flights.TOID', '=', 'AirportTo.id')
                ->join('cities as CityFrom', 'AirportFrom.CITYID', '=', 'CityFrom.id')
                ->join('cities as CityTo', 'AirportTo.CITYID', '=', 'CityTo.id')
                ->select('bookedflights.*','users.name as UserName',DB::raw('CONCAT(AirportFrom.ENAME,"-",CityFrom.ENAME," ==> ",AirportTo.ENAME,"-",CityTo.ENAME) as FlightInfo'))
                ->where('bookedflights.id', $id)
                ->get();
            return response($data,201)->header('Content-Type','text-plain') ;

        }catch (Exception $exception){
            throw $exception;
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Lessonattendence  $lessonattendence
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $MyObject = BookedFlights::findOrFail($id);
        $Variables = $request->all();
        $MyObject->fill($Variables)->save() ;

        return response($MyObject,200)->header('Content-Type','text-plain') ;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Lessonattendence  $lessonattendence
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $MyObject = BookedFlights::findOrFail($id);
        $MyObject->delete() ;
        return response($MyObject,200)->header('Content-Type','text-plain') ;
    }
}
