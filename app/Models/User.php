<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    //在生成用户的同时生成激活令牌
    public static function boot() {
        parent::boot();

        static::creating(function ($user){
              $user->activation_token = str_random(30);
        });
    }

    //得到用户的Gravatar头像
    public function gravatar($size = '100'){
        $hash = md5(strtolower(trim($this->attributes['email'])));
        return "http://www.gravatar.com/avatar/$hash?s=$size";
    }

    //关联关系 用户关联微博
    public function statuses(){
        return $this->hasMany(Status::class);
    }

    //得到当前用户发布的微博并按时间顺序倒序排序
    public function feed()
    {
        $user_ids = $this->followings->pluck('id')->toArray();
        array_push($user_ids, $this->id);
        return Status::whereIn('user_id', $user_ids)
            ->with('user')
            ->orderBy('created_at', 'desc');
    }

    //模型关联 粉丝关系
    public function followers(){
        return $this->belongsToMany(User::class,'followers','user_id','follower_id');
    }

    //模型关联 关注关系
    public function followings(){
        return $this->belongsToMany(User::class,'followers','follower_id','user_id');
    }

    //关注逻辑
    public function follow($user_ids){
        if (!is_array($user_ids)){
            $user_ids = compact('user_ids');
        }

        $this->followings()->sync($user_ids,false);
    }

    //取消关注逻辑
    public function unfollow($user_ids){
        if (!is_array($user_ids)){
            $user_ids = compact('user_ids');
        }

        $this->followings()->detach($user_ids);
    }

    //判断是否关注
    public function isFollowing($user_id)
    {
        return $this->followings->contains($user_id);
    }
}
