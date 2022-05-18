<?php
namespace App\Validators;

use Illuminate\Http\Request;

class FizzBuzzValidator
{
    public static $rules = [
        'int1' => 'required|int|gt:0',
        'int2' => 'required|int|gt:0',
        'limit' => 'required|int|gt:1',
        'str1' => 'string',
        'str2' => 'string',
    ];
}
