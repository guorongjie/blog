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

class Tags extends Model
{
    public function getAll($map=[], $field='*', $order='', $limit='')
    {
        return $this->where($map)->field($field)->order($order)->limit($limit)->select();
    }
}