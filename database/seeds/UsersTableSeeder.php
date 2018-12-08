<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = factory(User::class)->times(50)->make();
        User::insert($users->makeVisible(['password', 'remember_token'])->toArray());

        //insert 方法来将生成假用户列表数据批量插入到数据库中
        //makeVisible 方法临时显示 User 模型里指定的隐藏属性
        //Because password and remember_token in $hidden, mass assignment will ignore them

        $user = User::find(1);
        $user->name = 'Sean';
        $user->email = 'sean@test.com';
        $user->password = bcrypt('password');
        $user->is_admin = true;
        $user->save();
    }
}
