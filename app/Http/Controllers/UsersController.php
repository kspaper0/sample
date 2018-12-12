<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\User;
use Auth;
use Mail;

class UsersController extends Controller
{
    public function __construct() {
        $this->middleware('auth', [
            'except' => ['show', 'create', 'store', 'index', 'confirmEmail']
        ]);
            //Auth represents Login
            //除了此处指定的动作以外，所有其他动作都必须登录用户才能访问

        $this->middleware('guest', [
            'only' => ['create']
            ]);
    }

    public function index() {
        $users = User::paginate(10);
        return view('users.index', compact('users'));
    }

    public function create() {
        return view('users.create');
    }

    public function show(User $user) {

        $statuses = $user->statuses()
                           ->orderBy('created_at', 'desc')
                           ->paginate(30);
        return view('users.show', compact('user','statuses'));
    }

    public function store(Request $request){
        $this->validate($request, [
            'name' => 'required|max:50',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|confirmed|min:6'
    ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        $this->sendEmailConfirmationTo($user);
        session()->flash('success', 'The activation Email has been sent to your mail box. Please check ');
        return redirect('/');

        // Auth::login($user);
        // session()->flash('success', 'Thanks for your joining');
        // return redirect()->route('users.show', [$user]);
    }

    public function edit(User $user) {
        $this->authorize('update', $user);
        return view('users.edit', compact('user'));
    }

    public function update(User $user, Request $request) {
        $this->validate($request, [
            'name' => 'required|max:50',
            'password' => 'nullable|confirmed|min:6'
        ]);

        $this->authorize('update', $user);

        $data = [];
        $data['name'] = $request->name;

        if ($request->password) {
            $data['password'] = bcrypt($request->password);
        }

        $user->update($data);

        session()->flash('success', 'Updated Successfully');

        return redirect()->route('users.show', $user->id);

    }

    public function destroy(User $user)
    {
        $this->authorize('destroy', $user);
        $user->delete();
        session()->flash('success', 'Deleted Successfully');
        return back();
    }

    protected function sendEmailConfirmationTo($user)
    {
        $view = 'emails.confirm';
        $data = compact('user');
        $from = 'sean@test.com';
        $name = 'Sean';
        $to = $user->email;
        $subject = "Thanks for registering with us. Please check your mail box";

        Mail::send($view, $data, function ($message) use ($from, $name, $to, $subject) {
            $message->from($from, $name)->to($to)->subject($subject);
        });

    }

    public function confirmEmail($token)
    {
        $user = User::where('activation_token', $token)->firstOrFail();
        //即，注册成功后，把数据库的token和当前的对比，如果一样

        //进入激活状态，并为空，重新保存
        $user->activated = true;
        $user->activation_token = null;
        $user->save();

        Auth::login($user);
        session()->flash('success', 'Thanks for your joining');
        return redirect()->route('users.show', [$user]);
    }
}
