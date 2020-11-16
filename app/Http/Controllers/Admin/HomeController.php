<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Time;
use App\User;

class HomeController extends Controller
{
     public function index()
     {
         $users = User::all();

         return view('admin.edit', compact('users'));
     }
}
