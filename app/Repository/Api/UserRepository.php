<?php
/**
 * Author: xingyuanwang
 * Email : kinyou_xy@126.com
 * Date: 2018/5/31-上午9:08
 */
namespace App\Repository\Api;


use App\User;

class UserRepository {

    protected $user;

    /**
     * UserRepository constructor.
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * 返回所有用户
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function user()
    {
        return $this->user->all();
    }

    /**
     * 根据用户id查询用户
     *
     * @param $id
     * @return mixed
     */
    public function userById($id)
    {
        return $this->user->findOrFail($id);
    }


}