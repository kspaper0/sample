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

        //获取除 ID 为 1 的所有用户 ID 数组

        //去掉 ID 为 1 的用户，返回数组
        $followers = $users->slice(1);
        //得到 所有 ID
        $follower_ids = $followers->pluck('id')->toArray();

        //调用User Model 的 follow 方法
        //关注除了 1 号用户以外的所有用户
        $user->follow($follower_ids);

        //把去掉 1 以后的所有用户，关注1号用户
        foreach ($followers as $follower) {
            $follower->follow($user_id);
        }
    }
}
