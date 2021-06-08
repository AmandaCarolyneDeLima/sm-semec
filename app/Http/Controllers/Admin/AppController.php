<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\FilterDateTimeFormatter;

class AppController extends Controller
{
    use FilterDateTimeFormatter;

    public function __construct()
    {
        $this->middleware('auth');
    }
}
