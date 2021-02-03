<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;

class AuthorsController extends Controller
{
    public function create()
    {
        return view('authors.create');
    }

    public function store()
    {
        Author::create($this->validateRequest());
    }

    protected function validateRequest(): array
    {
        return request()->validate([
            'name' => 'required',
            'dob' => 'required'
        ]);
    }
}
