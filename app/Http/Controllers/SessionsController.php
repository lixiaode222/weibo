<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class SessionsController extends Controller
{
    //用户登陆页面
    public function create(){
        return view('sessions.create');
    }

    //用户登陆逻辑
    public function store(Request $request){
        $credentials = $this->validate($request,[
            'email' => 'required|email|max:255',
            'password' => 'required'
        ]);

        //判断密码与邮箱是否匹配
        if(Auth::attempt($credentials)){
            session()->flash('success','欢迎回来！~');
            return redirect()->route('users.show',[Auth::user()]);
        }else{
            session()->flash('danger','很抱歉，您的邮箱和密码不匹配');
            return redirect()->back()->withInput();
        }
    }

    //用户退出逻辑
    public function destroy(){
        Auth::logout();
        session()->flash('success','您已成功退出！');
        return redirect('login');
    }
}
