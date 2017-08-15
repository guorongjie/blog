<?php
/**
 * Created by PhpStorm.
 * User: GUO
 * Date: 2017/7/11
 * Time: 20:42
 */
namespace app\index\controller;

use app\common\model\Ip;
use think\Controller;

class Base extends Controller{
    public $_ipMode ;
    public function __construct()
    {
        parent::__construct();
        $this->_ipMode = new Ip();
        $this->addIp();//增加访客记录
        $this->assign('visit', $this->_ipMode->getAllVisit());//前台footer显示
    }

    /**
     *记录访客
     */
    public function addIp()
    {
        if (!cookie('ip')) {
            $ip = getIP();//获取ip地址
            $this->_ipMode->addOne(array('ip'=>$ip, 'add_time'=>time()));
            cookie('ip', $ip,3600);
        }
    }

    /**
     *
     * 获取tagsList
     */
    public function getTagsList()
    {
        return model('Tags')->select();
    }

    /**
     * @param $phone
     * @param $num
     * @return mixed
     * 发送手机短信--普通
     */
    public function sendMobileMessage2($phone, $num)
    {
        $url = "http://v.apistore.cn/api/v14/xsend";
        $arr = array('key'=>'f21e44a76040ba38d6733b4927780c37', 'mobile'=>$phone, 'tpl_id'=>91339, 'tpl_val'=>json_encode(array('code'=>$num)));
        return httpRequest($url,'post', $arr);
    }

    /**
     * @param $phone
     * @return mixed
     * 发送手机验证码--普通
     */
    public function sendMobileCode2($phone)
    {
        $num = getRandNum(6);
        session($phone . $num, $num);
        return $this->sendMobileMessage2($phone, $num);
    }

    /**
     * @param $phone
     * @param $num
     * @return boolean
     * 发送手机短信--阿里
     */
    public function sendMobileMessage($phone, $num)
    {
        $config = array(
            'accessKeyId' => '',
            'accessKeySecret' => '',
            'signName'=>'',
            'templateCode'=>'',
        );
        //生成验证码
        //发送短信
        $sms = new \aliyunsms\Sms($config);
        //测试模式
        return $sms->send_verify($phone, array('code'=>$num));
    }

    /**
     * @param $phone
     * @return mixed
     * 发送手机验证码--阿里
     */
    public function sendMobileCode($phone)
    {
        $num = getRandNum(6);
        session($phone . 'sms', $num);
        return $this->sendMobileMessage($phone, $num);
    }


}