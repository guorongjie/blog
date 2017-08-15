<?php
// +----------------------------------------------------------------------
// | guo
// +----------------------------------------------------------------------
// | Copyright (c) 2016~2022 http://baiyf.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: NickBai <1902822973@qq.com>
// +----------------------------------------------------------------------
namespace app\common\model;

use think\Model;

class Works extends Model
{

    public function getAll($order='', $limit = 10)
    {
        $list = $this
            ->order($order)
            ->paginate($limit);
        return $list;
    }



    public function getList()
    {
        return $this->select();
    }

}