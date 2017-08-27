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

    public function getAll($map=[], $field='*', $order='', $limit = 10)
    {
        $list = $this
            ->where($map)
            ->field($field)
            ->order($order)
            ->paginate($limit);
        return $list;
    }

    public function getList()
    {
        return $this->select();
    }

}