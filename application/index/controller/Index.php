<?php
namespace app\index\controller;
use app\common\model\Articles;
use app\common\model\Works;
use app\index\logic\ArticleLogic;
use app\index\logic\UsersLogic;
use think\Request;
use org\Verify;

class Index extends Base
{
    public function test()
    {
        $url = "https://hwid1.vmall.com/CAS/ajaxHandler/getSMSAuthCode?reflushCode=0.48269979445645872";
        $data = array(
            'userAccount' => '15088132360',
            'smsReqType' => 4,
            'reqClientType' => 26,
            'accountType' => 2,
            'siteID' => 1,
            'languageCode' => 'zh-cn',
            'operType'=>6
        );
        $result = httpRequest($url, 'post', $data);
        echo $result;
    }


    /**
     * @return mixed
     * 首页
     */
    public function index()
    {
        $articlesModel = new Articles();

        //列表
        $list = $articlesModel->getAll();
        $page = $list->render();
        $this->assign('lists', $list);
        $this->assign('page', $page);

        $this->assign('tags', $this->getTagsList());//标签
        $this->assign('hot', $articlesModel->hot());//热文

        return $this->fetch();
    }

    /**
     * @return mixed
     * 详情
     */
    public function detail()
    {
        $id = $this->request->param('id');
        if (!$id) {
            $this->index();
        }

        //阅读量加一
        $articleLogic = new ArticleLogic();
        $articleLogic->addVist($id);

        $articleModel = new Articles();
        $info = $articleModel->getOne($id);
        $this->assign('info', $info);
        return $this->fetch();
    }



    /**
     * @return
     * 首页点赞
     */
    public function onclick()
    {
        $id = $this->request->param('id');
        $type = $this->request->param('type');

        if (!$id || !$type) {
            return ajaxReturn(400, '参数错误');
        }
        switch ($type) {
            case '1':
                $field = 'up';
                break;
            case '2':
                $field = 'down';
                break;
        }
        $result = model('Articles')->where(array('id' => $id))->setInc($field, '1');
        if (!$result) {
            return ajaxReturn(400, '服务器繁忙');
        }
        return ajaxReturn(200, 'OK');

    }

    /**
     * @return mixed
     * 登录
     */
    public function login()
    {
        if ($this->request->isAjax()) {
            $data = $this->request->post();

            $verify = new Verify();
            if (!$verify->check($this->request->param('verify'))) {
                return ajaxReturn(400, '随机验证码错误');
            }
            $userLogic = new  UsersLogic();
            $result = $userLogic->login($data['user_name'], $data['password']);
            if (!$result) {
                return ajaxReturn(400, '密码错误');
            }
            return ajaxReturn(200, '登陆成功');
        }
        return $this->fetch();
    }
    /**
     * 获取验证码
     */
    public function getVerify()
    {
        $verify = new Verify();
        $verify->imageH = 32;
        $verify->imageW = 100;
        $verify->length = 4;
        $verify->useNoise = false;
        $verify->fontSize = 14;
        return $verify->entry();
    }

    /**
     * 时间线
     */
    public function archives()
    {
        $archivesLogic = new  ArticleLogic();
        $lists = $archivesLogic->archives();
        $this->assign('lists', $lists['timemap']);
        $this->assign('count', $lists['count']);
        return $this->fetch();
    }

    /**
     * @return mixed
     * 关于
     */
    public function about()
    {
        return $this->fetch();
    }

    /**
     * @return mixed
     * 简历
     */
    public function resume()
    {
        return $this->fetch();
    }

    /**
     * @return mixed
     * 作品
     */
    public function works()
    {
        $articlesModel = new Articles();

        $wordsModel = new Works();
        $list = $wordsModel->getAll();
        $page = $list->render();

        $this->assign('lists', $list);
        $this->assign('page', $page);

        $this->assign('tags', $this->getTagsList());//标签
        $this->assign('hot', $articlesModel->hot());//热文

        return $this->fetch();
    }
}
