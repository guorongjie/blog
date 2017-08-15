<?php
/**
 * Created by PhpStorm.
 * User: GUO
 * Date: 2017/7/18
 * Time: 19:41
 */
namespace app\index\controller;
class UsersBase extends Base{

    public function __construct()
    {
        parent::__construct();
        if (!session('user')) {
            $this->redirect('Index/login');
        }
    }

}