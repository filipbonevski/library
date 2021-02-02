<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;

class AuthorsController extends Controller
{
    public function store()
    {
        Author::create(request()->only([
            'name','dob'
        ]));
    }

//    protected function validateRequest(): array
//    {
//        return request()->validate([
//            'author' => 'required',
//            'dob' => 'required'
//        ]);
//    }
}
