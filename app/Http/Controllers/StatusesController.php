<?php

namespace App\Http\Controllers;

use App\Http\Requests\StatusRequest;
use Illuminate\Http\Request;
use Auth;
use App\Models\Status;

class StatusesController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function store(StatusRequest $request) {

        Auth::user()->statuses()->create([
            'content' => $request['content'],
        ]);
        session()->flash('success','微博发布成功！');
        return redirect()->back();
    }

    public function destroy(Status $status){

        $this->authorize('destroy',$status);
        $status->delete();
        session()->flash('success','微博已被删除。');
        return redirect()->back();
    }
}
