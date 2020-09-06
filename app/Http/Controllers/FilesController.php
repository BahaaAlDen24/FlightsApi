<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FilesController extends Controller
{
    function FileDownload(Request  $request)
    {
        $Variables = $request->all();
        $Path = $Variables['ServerPath'] ;
        return response()->download(public_path($Path));
    }
}
