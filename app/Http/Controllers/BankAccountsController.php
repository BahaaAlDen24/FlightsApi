<?php

namespace App\Http\Controllers;

use App\Models\Bankaccounts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use mysql_xdevapi\Exception;

class BankAccountsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            $data = DB::table('users')
                ->join('bankaccounts', 'users.id', '=', 'bankaccounts.USERID')
                ->join('banks', 'banks.id', '=', 'bankaccounts.BANKID')
                ->select('bankaccounts.*','users.id as USERID','users.name as User','banks.id as BANKID','banks.ENAME as Bank')
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
        $MyObject = new Bankaccounts();
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
            $data = DB::table('users')
                ->join('bankaccounts', 'users.id', '=', 'bankaccounts.USERID')
                ->join('banks', 'banks.id', '=', 'bankaccounts.BANKID')
                ->select('bankaccounts.*','users.id as USERID','users.name as User','banks.id as BANKID','banks.ENAME as Bank')
                ->where('bankaccounts.id', $id)
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
        $MyObject = Bankaccounts::findOrFail($id);
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
        $MyObject = Bankaccounts::findOrFail($id);
        $MyObject->delete() ;
        return response($MyObject,200)->header('Content-Type','text-plain') ;
    }
}
