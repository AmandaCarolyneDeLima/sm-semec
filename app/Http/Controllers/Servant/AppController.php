<?php

namespace App\Http\Controllers\Servant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AppController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:servant')->except('logout');
    }
}
