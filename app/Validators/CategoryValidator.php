<?php


namespace App\Validators;


use App\Model\Category;
use Illuminate\Support\Facades\Validator;

class CategoryValidator
{

    private function __construct()
    {
    }


    /**
     * @param Category $category It is the category to valid.
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public static function valid(array $parameters) {
        return Validator::make($parameters, [
            "name" => "required"
        ]);
    }

}