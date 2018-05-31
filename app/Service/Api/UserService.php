<?php
/**
 * Author: xingyuanwang
 * Email : kinyou_xy@126.com
 * Date: 2018/5/31-上午9:20
 */
namespace App\Service\Api;

use App\Repository\Api\UserRepository;

class UserService {

    protected $userRepository;

    /**
     * UserService constructor.
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * 返回所有的用户
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function user()
    {
        return $this->userRepository->user();
    }

    /**
     * 根据用户id查询用户
     *
     * @param $id
     * @return mixed
     */
    public function userById($id)
    {
        return $this->userRepository->userById($id);
    }

}