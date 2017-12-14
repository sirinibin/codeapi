<?php

namespace App\Http\Controllers;

use App\Code;
use App\Github;
use Illuminate\Http\Request;


class CodeController extends Controller
{
    public function __construct()
    {
    }

    public function search(Request $request)
    {

        $code = new Code;
        $response = $code->search(new Github, $request);
        return response()->json($response, 200, [], JSON_PRETTY_PRINT);

    }
}

?>