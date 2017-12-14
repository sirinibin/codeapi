<?php
namespace App;


use App\Interfaces\CodeInterface;


class Code
{

    public function search(CodeInterface $object, $request)
    {
        return $object->search($request);
    }
}