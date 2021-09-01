<?php

namespace App\Command;

class Operation
{
    function add($val1,$val2)
    {
        $result = round($val1+$val2, 2);
        return $result;
    }

    function minus($val1,$val2)
    {
        $result = round($val1-$val2, 2);
        return $result;
    }

    function divide($val1,$val2)
    {
        $result = round($val1/$val2, 2);
        return $result;
    }

    function multiple($val1,$val2)
    {
        $result = round($val1*$val2, 2);
        return $result;
    }
}