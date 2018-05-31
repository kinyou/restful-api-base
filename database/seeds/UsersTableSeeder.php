<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\User::class,50)->create();

        //修改第一个用户名为demo
        $user = \App\User::find(1);
        $user->name = 'demo';
        $user->save();
    }
}
