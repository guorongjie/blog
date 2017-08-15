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

class Articles extends Model
{

    public function getAll($limit = 10)
    {
        $list = $this->alias('a')
            ->join('__TAGS__ t', 't.id = a.tags_id')
            ->field('a.*, t.name as tag_name')
            ->paginate($limit);
        return $list;
    }

    public function getOne($id)
    {
        $info = $this->alias('a')
            ->join('__TAGS__ t', 't.id = a.tags_id')
            ->where(array('a.id'=>$id))
            ->field('a.*, t.name as tag_name')
            ->find();
        return $info;
    }

    public function getList()
    {
        return $this->select();
    }

    /**
     * @return mixed
     * 热文
     */
    public function hot()
    {
        return $this->order('visit desc')->limit(5)->select();
    }
}