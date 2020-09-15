<?php

namespace App\Http\Controllers;

use App\Models\Flightoffers;
use App\Models\Flights;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
            $data = DB::table('flights')
                ->join('airports as AirportFrom', 'flights.FROMID', '=', 'AirportFrom.id')
                ->join('airports as AirportTo', 'flights.TOID', '=', 'AirportTo.id')
                ->join('airlines', 'flights.AIRLINEID', '=', 'airlines.id')
                ->join('airplanes', 'flights.AIRPLANEID', '=', 'airplanes.id')
                ->join('flighttypes', 'flights.FLIGHTTYPEID', '=', 'flighttypes.id')
                ->leftjoin('flightoffers', 'flightoffers.FLIGHTID', '=', 'flights.id')
                ->leftjoin('offers', 'flightoffers.OFFERID', '=', 'offers.id')
                ->select('flights.*',
                                  'AirportFrom.id as FROMID','AirportFrom.ENAME as FromName',
                                  'AirportTo.id as TOID','AirportTo.ENAME as ToName',
                                  'airlines.id as AIRPLANEID','airlines.ENAME as AirlineName',
                                  'airplanes.id as AIRPLANEID','airplanes.ENAME as AirplaneName',
                                  'flightoffers.OFFERID as OFFERID','offers.ENAME as OfferName','offers.DISCOUNTRATE as OfferDISCOUNTRATE',
                                  'flighttypes.id as FLIGHTTYPEID','flighttypes.ENAME as FlightTypeName')
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
        try{

            $Variables = $request->all();
            $MyObject = new Flights();
            $Variables['data']['ARRIVALTIME'] = date("Y-d-m H:i:s", strtotime(str_replace('- ', '', $Variables['data']['ARRIVALTIME']))) ;
            $Variables['data']['DEPATURETIME'] = date("Y-d-m H:i:s", strtotime(str_replace('- ', '', $Variables['data']['DEPATURETIME']))) ;
            $MyObject->fill($Variables['data']) ;
            $ImagesSRC[] = array() ;
            for ($i = 1 ; $i < 5 ;$i++){
                $ServerPath = "" ;
                if ($files = $request->file('IMGSRC' . $i)) {
                    request()->validate(['IMGSRC' . $i  => 'required|mimes:jpg,png|max:2048',]);

                    $files = $request->file('IMGSRC' . $i);

                    $destinationPath = 'FlightsFile/'; // upload path
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

            $MyObject = Flights::findOrFail($MyObject->id);

            if ($Variables['data']['OFFERID'] != null){
                $FlightOffer = new Flightoffers() ;
                $Variables2 = array() ;
                $Variables2['OFFERID']  = $Variables['data']['OFFERID'] ;
                $Variables2['FLIGHTID'] = $MyObject->id  ;
                $FlightOffer->fill($Variables2);
                $FlightOffer->save();
            }

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
            $data = DB::table('flights')
                ->join('airports as AirportFrom', 'flights.FROMID', '=', 'AirportFrom.id')
                ->join('airports as AirportTo', 'flights.TOID', '=', 'AirportTo.id')
                ->join('airlines', 'flights.AIRLINEID', '=', 'airlines.id')
                ->join('airplanes', 'flights.AIRPLANEID', '=', 'airplanes.id')
                ->join('flighttypes', 'flights.FLIGHTTYPEID', '=', 'flighttypes.id')
                ->leftjoin('flightoffers', 'flightoffers.FLIGHTID', '=', 'flights.id')
                ->leftjoin('offers', 'flightoffers.OFFERID', '=', 'offers.id')
                ->select('flights.*',
                                'AirportFrom.id as FROMID','AirportFrom.ENAME as FromName',
                                'AirportTo.id as TOID','AirportTo.ENAME as ToName',
                                'airlines.id as AIRPLANEID','airlines.ENAME as AirlineName',
                                'airplanes.id as AIRPLANEID','airplanes.ENAME as AirplaneName',
                                'flighttypes.id as FLIGHTTYPEID','flighttypes.ENAME as FlightTypeName',
                                'flightoffers.OFFERID as OFFERID','offers.ENAME as OfferName','offers.DISCOUNTRATE as OfferDISCOUNTRATE')
                ->where('flights.id', $id)
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
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        try {

            $Variables = $request->all();
            $Variables2 = $request->getContent();
            $MyObject = Flights::findOrFail($id);
            $MyObject->fill($Variables['data']) ;
            $ImagesSRC[] = array() ;
            for ($i = 1 ; $i < 5 ;$i++){
                $ServerPath = "" ;
                if ($files = $request->file('IMGSRC' . $i)) {
                    request()->validate(['IMGSRC' . $i  => 'required|mimes:jpg,png|max:2048',]);

                    $files = $request->file('IMGSRC' . $i);

                    $destinationPath = 'FlightsFile/'; // upload path
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

            $MyObject = Flights::findOrFail($MyObject->id);

            if ($Variables['data']['OFFERID'] != null){
                $FlightOffer = new Flightoffers() ;
                $Variables2 = array() ;
                DB::delete('DELETE FROM flightoffers WHERE FLIGHTID = ?', [$MyObject->id]);
                $Variables2['OFFERID']  = $Variables['data']['OFFERID'] ;
                $Variables2['FLIGHTID'] = $MyObject->id  ;
                $FlightOffer->fill($Variables2);
                $FlightOffer->save();
            }

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

            $MyObject = Flights::findOrFail($id);
            $MyObject->delete() ;

            return response($MyObject,200)->header('Content-Type','text-plain') ;

        }catch (Exception $exception){
            throw $exception;
        }
    }
}
