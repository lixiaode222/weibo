<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class SessionsController extends Controller
{
    public function __construct() {
        $this->middleware('guest',[
            'only' => ['create']
        ]);
    }

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
        if(Auth::attempt($credentials,$request->has('remember'))){
            session()->flash('success','欢迎回来！~');
            $fallback = route('users.show', Auth::user());
            return redirect()->intended($fallback);
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
