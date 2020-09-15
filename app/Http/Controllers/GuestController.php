<?php

namespace App\Http\Controllers;

use App\Models\Bankaccounts;
use App\Models\Bookedflights;
use App\Models\Flights;
use BankAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use mysql_xdevapi\Exception;

class GuestController extends Controller
{
    function Search(Request $request){
        try{
            $SearchCreteria = $request->all() ;
            $SearchCreteria['DEPATURETIME'] = date("Y-d-m H:i:s", strtotime(str_replace('- ', '', $SearchCreteria['DEPATURETIME']))) ;
            $data = DB::table('flights')
                ->join('airports as AirportFrom', 'flights.FROMID', '=', 'AirportFrom.id')
                ->join('airports as AirportTo', 'flights.TOID', '=', 'AirportTo.id')
                ->join('airlines', 'flights.AIRLINEID', '=', 'airlines.id')
                ->join('airplanes', 'flights.AIRPLANEID', '=', 'airplanes.id')
                ->join('flighttypes', 'flights.FLIGHTTYPEID', '=', 'flighttypes.id')
                ->join('cities as CityFrom', 'AirportFrom.CITYID', '=', 'CityFrom.id')
                ->join('cities as CityTo', 'AirportTo.CITYID', '=', 'CityTo.id')
                ->leftjoin('flightoffers', 'flightoffers.FLIGHTID', '=', 'flights.id')
                ->leftjoin('offers', 'flightoffers.OFFERID', '=', 'offers.id')
                ->select('flights.*',
                    'AirportFrom.id as FROMID','AirportFrom.ENAME as FromName',
                    'AirportTo.id as TOID','AirportTo.ENAME as ToName',
                    'airlines.id as AIRPLANEID','airlines.ENAME as AirlineName',
                    'airplanes.id as AIRPLANEID','airplanes.ENAME as AirplaneName',
                    'CityFrom.id as CityFromID','CityFrom.ENAME as CityFromName',
                    'CityTo.id as CityTOID','CityTo.ENAME as CityToName',
                    'offers.ENAME as OfferName','offers.DISCOUNTRATE as OfferDISCOUNTRATE',
                    'flighttypes.id as FLIGHTTYPEID','flighttypes.ENAME as FlightTypeName')
                ->where([
                    ['CityFrom.id', '=', $SearchCreteria['CITYFROM']],
                    ['CityTo.id', '=', $SearchCreteria['CITYTO']],
                    ['flights.DEPATURETIME', '>=', $SearchCreteria['DEPATURETIME']],
                    ['flights.FLIGHTTYPEID', '=', $SearchCreteria['Type']],
                    ['flights.AVAILABLESEATNUMBER', '>', 0 ],
                ])
                ->orderBy('flights.PRICE')
                ->get();
            return response($data,201)->header('Content-Type','text-plain') ;
        }catch (Exception $exception){
            throw $exception ;
        }
    }

    function UserInfo(Request $request)
    {
        try {
            $AccessToken = $request->header('Authorization', '');
            $UserInfo = Cache::get($AccessToken);
            if ($UserInfo == null) {
                $UserInfo = response()->json(request()->user())->content();
                $UserInfo = json_decode($UserInfo,true);
                $UserInfo = Cache::put($AccessToken,$UserInfo,3600);
            }

            $data = DB::table('users')
                ->leftJoin('bankaccounts', 'users.id', '=', 'bankaccounts.USERID')
                ->leftJoin('banks', 'banks.id', '=', 'bankaccounts.BANKID')
                ->select('bankaccounts.*','users.id as USERID','users.name as User','users.email as Email','banks.id as BANKID','banks.ENAME as Bank','bankaccounts.id as AccountID')
                ->where('users.id', $UserInfo['id'])
                ->get();

            return response($data,201)->header('Content-Type','text-plain') ;

        } catch (Exception $exception) {
            throw $exception;
        }
    }

    function BookFlight(Request $request,$FlightID,$UserAccountID)
    {
        try {
            $AccessToken = $request->header('Authorization', '');
            $UserInfo = Cache::get($AccessToken);
            if ($UserInfo == null) {
                $UserInfo = response()->json(request()->user())->content();
                $UserInfo = json_decode($UserInfo,true);
                $UserInfo = Cache::put($AccessToken,$UserInfo,3600);
            }

            $Flight = Flights::findOrFail($FlightID);
            $BankAccount = Bankaccounts::findOrFail($UserAccountID);

            $NewBookedFlight = new Bookedflights() ;
            $NewBookedFlight->FLIGHTID = $FlightID ;
            $NewBookedFlight->USERID = $UserInfo['id'] ;
            $NewBookedFlight->NUMOFSEAT = 1 ;
            $NewBookedFlight->TOTALPRICE = $Flight->PRICE  ;

            $Flight->AVAILABLESEATNUMBER = $Flight->AVAILABLESEATNUMBER - 1 ;

            if ($Flight->OfferDISCOUNTRATE != null) {
                $BankAccount->FUNDS = $BankAccount->FUNDS - ($Flight->OfferDISCOUNTRATE * $Flight->PRICE / 100);
            }else {
                $BankAccount->FUNDS = $BankAccount->FUNDS - $Flight->PRICE ;
            }

            $NewBookedFlight->save();
            $Flight->save();
            $BankAccount->save();

            $NewBookedFlight = Bookedflights::findOrFail($NewBookedFlight->id);

            return response($NewBookedFlight,201)->header('Content-Type','text-plain') ;

        } catch (Exception $exception) {
            throw $exception;
        }
    }
}
