<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\User;
use Auth;

class FollowersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    //User 负责在用户上面关注(Follow) 和 取消关注(Unfollow) 其用户
    //这个控制器负责其两个动作
    public function store(User $user)
    {
        //如果登录的用户是要被关注的用户，直接返回主页
        if (Auth::user()->id === $user->id) {
            return redirect('/');
        }

        //如果将要关注的用户没有被关注，则关注此用户
        if (!Auth::user()->isFollowing($user->id)) {
            Auth::user()->follow($user->id);
        }

        return redirect()->route('users.show', $user->id);
    }

    public function destroy(User $user)
    {
        if (Auth::user()->id === $user->id) {
            return redirect('/');
        }

        if (Auth::user()->isFollowing($user->id)) {
            Auth::user()->unfollow($user->id);
        }

        return redirect()->route('users.show', $user->id);

    }
}
