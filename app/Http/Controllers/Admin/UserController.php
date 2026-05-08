<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index(Request $request){
        $select = $request->role;
        if($select == 2){
            $users = User::where('role', 'customer')->get();
        } else if($select == 3){
            $users = User::where('role', 'admin')->get();
        } else if ($select == 2){
            $users = User::where('role', 'driver')->get();
        }else {
            $users = User::all();
        }
        return view('Admin.User.index', compact('users'));
    }
}
