<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class confirmController extends Controller
{
    function create(){
        return view('editUser');
    }
}
