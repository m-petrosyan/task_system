<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;

class AuthController
{
    public function __invoke(): View
    {
        return view('welcome');
    }
}