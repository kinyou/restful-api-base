<?php
/**
 * Author: xingyuanwang
 * Email : kinyou_xy@126.com
 * Date: 2018/5/31-上午9:20
 */
namespace App\Service\Api;

use App\Repository\Api\UserRepository;
use Illuminate\Http\Request;

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

    /**
     * 用户注册
     *
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request)
    {
        $data = $request->only(['name','email','password']);
        $data['password'] = bcrypt($data['password']);

        return $this->userRepository->store($data);
    }

    /**
     * 更新用户信息
     *
     * @param Request $request
     * @param $id
     * @return bool
     */
    public function update(Request $request,$id)
    {
        $data = $request->all();
        isset($data['password']) ? ($data['password'] = bcrypt($data['password'])) : '';

        return $this->userRepository->update($data,$id);
    }

    /**
     * 删除用户
     *
     * @param int $id
     * @return bool
     */
    public function destroy(int $id)
    {
        return $this->userRepository->destroy($id);
    }

}