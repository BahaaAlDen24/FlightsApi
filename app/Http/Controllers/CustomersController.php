<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use mysql_xdevapi\Exception;

class CustomersController extends Controller
{
    public function BookedFlightsIndex(Request $request){
        try {
            $AccessToken = $request->header('Authorization', '');
            $UserInfo = Cache::get($AccessToken);
            if ($UserInfo == null) {
                $UserInfo = response()->json(request()->user())->content();
                $UserInfo = json_decode($UserInfo,true);
                $UserInfo = Cache::put($AccessToken,$UserInfo,3600);
            }
            if ($AccessToken != null) {
                $data = DB::table('flights')
                    ->join('bookedflights', 'bookedflights.FLIGHTID', '=', 'flights.id')
                    ->leftJoin('canceledflights', 'bookedflights.id', '=', 'canceledflights.BOOKEDFLIGHTID')
                    ->join('airports as AirportFrom', 'flights.FROMID', '=', 'AirportFrom.id')
                    ->join('airports as AirportTo', 'flights.TOID', '=', 'AirportTo.id')
                    ->join('airlines', 'flights.AIRLINEID', '=', 'airlines.id')
                    ->join('airplanes', 'flights.AIRPLANEID', '=', 'airplanes.id')
                    ->join('cities as CityFrom', 'AirportFrom.CITYID', '=', 'CityFrom.id')
                    ->join('cities as CityTo', 'AirportTo.CITYID', '=', 'CityTo.id')
                    ->join('flighttypes', 'flights.FLIGHTTYPEID', '=', 'flighttypes.id')
                    ->leftjoin('flightoffers', 'flightoffers.FLIGHTID', '=', 'flights.id')
                    ->leftjoin('offers', 'flightoffers.OFFERID', '=', 'offers.id')
                    ->whereNull('canceledflights.id')
                    ->where('bookedflights.USERID',$UserInfo['id'])
                    ->select('flights.*',
                        'AirportFrom.id as FROMID','AirportFrom.ENAME as FromName',
                        'AirportTo.id as TOID','AirportTo.ENAME as ToName',
                        'airlines.id as AIRPLANEID','airlines.ENAME as AirlineName',
                        'CityFrom.id as CityFromID','CityFrom.ENAME as CityFromName',
                        'CityTo.id as CityTOID','CityTo.ENAME as CityToName',
                        'airplanes.id as AIRPLANEID','airplanes.ENAME as AirplaneName',
                        'flightoffers.OFFERID as OFFERID','offers.ENAME as OfferName','offers.DISCOUNTRATE as OfferDISCOUNTRATE',
                        'flighttypes.id as FLIGHTTYPEID','flighttypes.ENAME as FlightTypeName','bookedflights.CREATED_AT as BookingDate','bookedflights.id as BookingFlightID')
                    ->get();
                    return response($data,201)->header('Content-Type','text-plain') ;
            }else
            {
                return redirect()->route('login');
            }
        }catch (Exception $exception){
            throw $exception;
        }
    }

    public function CanceledFlightsIndex(Request $request){
        try {
            $AccessToken = $request->header('Authorization', '');
            $UserInfo = Cache::get($AccessToken);
            if ($UserInfo == null) {
                $UserInfo = response()->json(request()->user())->content();
                $UserInfo = json_decode($UserInfo,true);
                $UserInfo = Cache::put($AccessToken,$UserInfo,3600);
            }
            if ($AccessToken != null) {
                $data = DB::table('flights')
                    ->join('bookedflights', 'bookedflights.FLIGHTID', '=', 'flights.id')
                    ->join('canceledflights', 'bookedflights.id', '=', 'canceledflights.BOOKEDFLIGHTID')
                    ->join('airports as AirportFrom', 'flights.FROMID', '=', 'AirportFrom.id')
                    ->join('airports as AirportTo', 'flights.TOID', '=', 'AirportTo.id')
                    ->join('airlines', 'flights.AIRLINEID', '=', 'airlines.id')
                    ->join('airplanes', 'flights.AIRPLANEID', '=', 'airplanes.id')
                    ->join('cities as CityFrom', 'AirportFrom.CITYID', '=', 'CityFrom.id')
                    ->join('cities as CityTo', 'AirportTo.CITYID', '=', 'CityTo.id')
                    ->join('flighttypes', 'flights.FLIGHTTYPEID', '=', 'flighttypes.id')
                    ->leftjoin('flightoffers', 'flightoffers.FLIGHTID', '=', 'flights.id')
                    ->leftjoin('offers', 'flightoffers.OFFERID', '=', 'offers.id')
                    ->where('bookedflights.USERID',$UserInfo['id'])
                    ->select('flights.*',
                        'AirportFrom.id as FROMID','AirportFrom.ENAME as FromName',
                        'AirportTo.id as TOID','AirportTo.ENAME as ToName',
                        'airlines.id as AIRPLANEID','airlines.ENAME as AirlineName',
                        'CityFrom.id as CityFromID','CityFrom.ENAME as CityFromName',
                        'CityTo.id as CityTOID','CityTo.ENAME as CityToName',
                        'airplanes.id as AIRPLANEID','airplanes.ENAME as AirplaneName',
                        'canceledflights.CREATED_AT as CancelDate','canceledflights.EDESCRIPTION as CancelReason',
                        'flightoffers.OFFERID as OFFERID','offers.ENAME as OfferName','offers.DISCOUNTRATE as OfferDISCOUNTRATE',
                        'flighttypes.id as FLIGHTTYPEID','flighttypes.ENAME as FlightTypeName','bookedflights.CREATED_AT as BookingDate','bookedflights.id as BookingFlightID')
                    ->get();
                return response($data,201)->header('Content-Type','text-plain') ;
            }else
            {
                return redirect()->route('login');
            }
        }catch (Exception $exception){
            throw $exception;
        }
    }

    public function CountriesIndex(){}

    public function CitiesIndex(){}

    public function HotelsIndex(){}

    public function AirportsIndex(){}

    public function AirlinesIndex(){}

    public function AirplanesIndex(){}

    public function OffersIndex(){}

    public function ProfilePage(){}
}
