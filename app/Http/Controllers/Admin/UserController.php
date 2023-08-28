<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class UserController extends Controller
{
    //
    public function index(){
        //Danh sach user

        // $user = [1, 2, 3, 4, 5];
        // $text = 'bbbb';
        $users = DB::select('select * from users');//learn: MySQL


        return view('admin.pages.user.list', ['users' => $users]);

        // return view('admin.pages.user.list')
        // ->with('users', $users)
        // ->with('test', 'aaaaaaaa');


        //return view('admin.pages.user.list', compact('users', 'test'));
    }
}
