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

    /**
     * 创建用户
     *
     * @param array $data
     * @return mixed
     */
    public function store(array $data)
    {
        return $this->user->create($data);
    }

    /**
     * 更新用户信息
     *
     * @param array $data
     * @param int $id
     * @return bool
     */
    public function update(array $data,int $id)
    {
        $this->user->findOrFail($id);

        $fillable = $this->user->getFillable();

        $filll = [];

        foreach($fillable as $field) {
            if (array_key_exists($field,$data)) $filll[$field] = $data[$field];
        }
        
        return $this->user->where(['id'=>$id])->update($filll);
    }

    /**
     * 删除用户
     *
     * @param int $id
     * @return bool
     */
    public function destroy(int $id)
    {
        $this->user->findOrFail($id);

        return $this->user->destroy($id);

    }


}