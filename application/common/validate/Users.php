<?php
/**
 * Created by PhpStorm.
 * User: GUO
 * Date: 2017/7/18
 * Time: 15:10
 */
namespace app\common\validate;
use think\Validate;
class Users extends Validate{
    protected $rule = [
        'user_name' => 'require|min:3',
        'password' => 'require|min:6',
    ];
    protected $message = [
        'user_name.require' => '用户名必须',
        'user_name.min' => '用户名必须大于3位数',
        'password.require' => '密码必须',
        'password.min' => '密码必须大于6位数',

    ];
}