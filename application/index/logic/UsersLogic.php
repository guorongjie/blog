<?php
/**
 * Created by PhpStorm.
 * User: GUO
 * Date: 2017/7/20
 * Time: 17:26
 */
namespace app\index\logic;

class UsersLogic {

    /**
     * @param $user_name
     * @param $password
     * @return bool
     * 登陆
     */
    public function login($user_name, $password)
    {
        if (!$user_name || !$password) {
            return false;
        }
        $userInfo = model('Users')->where(array('user_name' => $user_name))->field('user_id, user_name, password')->find();
        if (!$userInfo) {
            return false;
        }
        if (md5($password) != $userInfo['password']) {
            return false;
        }
        session('user', array('user_id'=>$userInfo['user_id'], 'user_name'=>$userInfo['user_name']));
        return true;
    }

}