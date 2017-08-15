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

class Ip extends Model
{
    public function addOne($data=[])
    {
        return $this->save($data);
    }

    /**
     * @return array
     * 访客统计并且pv + 1
     */
    public function getAllVisit()
    {
        $list = $this->distinct(true)->field('ip')->cache(true)->select();
        $visitor = count($list);
//        $visit = $this->cache(true)->count();
        cache('visit', cache('visit')+1);
        return array('visitors'=>$visitor, 'visit'=>cache('visit'));
    }
}