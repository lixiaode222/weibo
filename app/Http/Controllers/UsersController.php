<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    //用户创建页面
    public function create(){
        return view('users.create');
    }

    //用户注册逻辑
    public function store(UserRequest $request){
        return;
    }

    //用户个人信息展示页面
    public function show(User $user){
        return view('users.show',compact('user'));
    }

}
