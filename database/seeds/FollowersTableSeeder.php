<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class FollowersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::all();
        $user = $users->first();
        $user_id = $user->id;

        //获取去掉ID为1的所有用户ID数组
        $followers = $users->slice(1);
        $follower_ids = $followers->pluck('id')->toArray();

        //让ID为1的用户关注其他所有用户
        $user->follow($follower_ids);

        //其他用户也都来关注1号用户
        foreach ($followers as $follower){
            $follower->follow($user_id);
        }
    }
}
