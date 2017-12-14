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

        $code =new Code;
        $response=$code->search(new Github,$request);
        return response()->json($response, 200, [], JSON_PRETTY_PRINT);

    }



    public function validate(Request $request, array $rules, array $messages = [], array $customAttributes = [])
    {

        $validator = $this->getValidationFactory()->make($request->all(), $rules, $messages, $customAttributes);

        if ($validator->fails()) {
            $response = [
                'status' => 0,
                'errors' => $validator->errors()
            ];

            response()->json($response, 400, [], JSON_PRETTY_PRINT)->send();
            die();

        }

        return true;
    }
}

?>