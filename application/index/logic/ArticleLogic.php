<?php
/**
 * Created by PhpStorm.
 * User: GUO
 * Date: 2017/7/20
 * Time: 17:26
 */

namespace app\index\logic;

use app\common\model\Articles;

class ArticleLogic
{

    /**
     * @param $id
     * 浏览次数加 1
     */
    public function addVist($id)
    {
        model('Articles')->where(array('id' => $id))->setInc('visit','1');
    }

    /**
     * @return array
     * 文章按年份分组
     */
    public function archives()
    {
        $artModel = new Articles();
        $lists = $artModel->getList();
        $count = count($lists);
        $timemap = array();
        //按年份分组
        foreach ($lists as $k => $item) {
            $lists[$k]['year'] = date('Y', $item['add_time']);//把时间戳格式化
            $timemap[$lists[$k]['year']][] = $lists[$k];//分组
        }

        return array('timemap'=>$timemap, 'count'=>$count);
    }
}