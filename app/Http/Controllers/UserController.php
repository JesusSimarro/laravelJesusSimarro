<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    //

    public function show(Request $request, $id) {
        $name = $request->name;
        return view ('usuario', compact('id'));
    }
}
