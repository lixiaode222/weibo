<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Auth;

class UsersController extends Controller
{
    //用户创建页面
    public function create(){
        return view('users.create');
    }

    //用户注册逻辑
    public function store(UserRequest $request){
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        Auth::login($user);
        session()->flash('success','欢迎，您将在这里开启一段新的旅程~');
        return redirect()->route('users.show',[$user]);
    }

    //用户个人信息展示页面
    public function show(User $user){
        return view('users.show',compact('user'));
    }

}
