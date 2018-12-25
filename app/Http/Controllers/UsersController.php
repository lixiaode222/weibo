<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Auth;

class UsersController extends Controller
{
    //权限过滤
    public function __construct() {
        $this->middleware('auth',[
            'except' => ['show','create','store','index']
        ]);

        $this->middleware('guest',[
            'only' => ['create']
        ]);
    }

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

    //用户信息修改页面
    public function edit(User $user){
        $this->authorize('update',$user);
        return view('users.edit',compact('user'));
    }

    //用户信息修改逻辑
    public function update(User $user,UserRequest $request){
        $this->authorize('update',$user);
        $user->update([
            'name' => $request->name,
            'password' => bcrypt($request->password),
        ]);

        $data = [];
        $data['name'] = $request->name;
        if($request->password){
            $data['password'] = bcrypt($request->password);
        }

        $user->update($data);

        session()->flash('success','个人资料更新成功！');

        return redirect()->route('users.show',$user);
    }

    //用户个人信息展示页面
    public function show(User $user){
        return view('users.show',compact('user'));
    }

    //用户列表页面
    public function index(){
        $users = User::paginate(8);
        return view('users.index',compact('users'));
    }

    //用户删除逻辑
    public function destroy(User $user){
        $this->authorize('destroy', $user);
        $user->delete();
        session()->flash('success','成功删除用户！');
        return back();
    }
}

