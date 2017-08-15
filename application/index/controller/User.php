<?php
/**
 * Created by PhpStorm.
 * User: GUO
 * Date: 2017/7/18
 * Time: 19:44
 */
namespace app\index\controller;
use think\Request;

class User extends UsersBase{

    public function index()
    {
        return $this->fetch();
    }

    /**
     * @return mixed|
     * 发布文章
     */
    public function publish()
    {
        if ($this->request->isAjax()) {
            $data['img']= $this->request->param('imgurl');
            $data['tags_id'] = $this->request->param('tags_id');
            $data['title'] = $this->request->param('title');
            $data['content'] = $this->request->param('content');

            if($data['img'] == '' || $data['tags_id'] =='' || $data['title'] == '' || $data['content'] == ''){
                return ajaxReturn(400, '参数错误');
            }

            if (!model('articles')->data($data)->save()) {
                return ajaxReturn(400, '发布失败');
            }
            return ajaxReturn(200, 'OK');

        }
        $tagsList = model('tags')->select();
        $this->assign('tags', $tagsList);
        return $this->fetch();
    }

    /**
     * @return array
     * 上传题图
     */
    public function uploadTitleImg()
    {
        $imgpath = input('post.uploadPath', 'default');

        $maxSize = 2 * 1024 * 1024; // 单位B
        $exts = 'gif,png,jpg,jpeg,bmp';


        // 获取表单上传文件 例如上传了001.jpg
        $file = request()->file('title_img');

        $info = $file->validate(['size' => $maxSize, 'ext' => $exts])->move(ROOT_PATH.DS.'public'.DS.'upload'. DS. $imgpath);
        if ($info) {
            $picUrl =  $info->getSaveName();

            $data['status'] = "success";
            $data['message'] = '上传成功';
            $data['picurl'] = Request::instance()->domain() . DS . 'upload' . DS . $imgpath . DS  . $picUrl;
            $data['picurl'] = str_replace(DS, '/', $data['picurl']);
        } else {
            // 上传失败获取错误信息
            $data['message'] = $file->getError();
        }
        return array('code' => 200, 'msg' => $data);
    }
}