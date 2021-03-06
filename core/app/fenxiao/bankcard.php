<?php
/**
 * @author Fm453(方少)
 * @DACMS https://api.hiluker.com
 * @site https://www.hiluker.com
 * @url http://s.we7.cc/index.php?c=home&a=author&do=index&uid=662
 * @email fm453@lukegzs.com
 * @QQ 393213759
 * @wechat 393213759
*/

/*
 * @remark 补充银行卡信息
 */
defined('IN_IA') or exit('Access Denied');
global $_GPC;
global $_W;
global $_FM;
load()->func('tpl');
fm_load()->fm_func('share');//链接分享管理
fm_load()->fm_model('shopcart'); //购物车模块
fm_load()->fm_func('view'); 	//浏览量处理
fm_load()->fm_func('wechat');//微信定义管理

//加载风格模板及资源路径
$appstyle = empty($settings['appstyle']) ? FM_APPSTYLE : $settings['appstyle'];
$appsrc =MODULE_URL.'template/mobile/'.$appstyle.'453/';
$htmlsrc =MODULE_URL.'template/mobile/'.$appstyle;
$fm453resource = FM_RESOURCE;
//入口判断
$do= $_GPC['do'];
$ac=$_GPC['ac'];
$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'index';
//开始操作管理
$shopname=$settings['brands']['shopname'];
$shopname = !empty($shopname) ? $shopname :FM_NAME_CN;
$pagename = '绑定银行卡';
//$pagename .='|'.$_W['account']['name'];

$uniacid=$_W['uniacid'];
$plattype=$settings['plattype'];
$platids = fmFunc_getPlatids();//获取平台模式关联的公众号商户ID参数
$platid=$_W['uniacid'];
$oauthid=$platids['oauthid'];
$fendianids=$platids['fendianids'];
$supplydianids=$platids['supplydianids'];
$blackids=$platids['blackids'];

//平台模式处理
require_once FM_PUBLIC.'plat.php';
$supplydians=explode(',',$supplydianids);//字符串转数组
$supplydians=array_filter($supplydians);//数组去空

//按平台模式前置筛选条件
$condition=' WHERE ';
$params=array();
require_once FM_PUBLIC.'forsearch.php';

$share_user=$_GPC['share_user'];
$shareid = intval($_GPC['shareid']);
$lastid = intval($_GPC['lastid']);
$currentid = intval($_W['member']['uid']);
$fromplatid = intval($_GPC['fromplatid']);
$from_user = $_W['openid'];
$url_condition="";
$direct_url = fm_murl($do,$ac,$operation,array());

//自定义微信分享内容
$_share = array();
$_share['title'] = $pagename;
$_share['link'] = fm_murl($do,$ac,$operation,array('isshare'=>1));
$_share['link'] = $_share['link'].$url_condition;
$_share['imgUrl'] = tomedia($settings['brands']['logo']);
$_share['desc'] = $_share['desc'] = $settings['brands']['share_des'];

$resultmember = fmMod_member_query($currentid);
$FM_member=$resultmember['data'];

$op = $_GPC['op']?$_GPC['op']:'display';
$rule = pdo_fetch('SELECT * FROM '.tablename('fm453_shopping_rule')." WHERE `uniacid` = :uniacid ",array(':uniacid' => $_W['uniacid']));
if(empty($from_user)){
	message('你想知道怎么加入么?',$rule['gzurl'],'sucessr');
	exit();
}

		$profile= pdo_fetch('SELECT * FROM '.tablename('fm453_shopping_member')." WHERE  uniacid = :uniacid  AND from_user = :from_user" , array(':uniacid' => $_W['uniacid'],':from_user' => $from_user));
		if(intval($profile['id']) && $profile['status']==0){
			include $this->template($appstyle.'forbidden');
			exit();
		}
		if(empty($profile)){
			message('请先注册',$this->fm_murl('member','register','index',array()),'error');
			exit();
		}
		if($op=='edit'){

			$data=array(
				'bankcard'=>$_GPC['bankcard'],
				'banktype'=>$_GPC['banktype'],
				'alipay'=>$_GPC['alipay'],
				'wxhao'=>$_GPC['wxhao']
			);
			if(!empty($data['bankcard']) && !empty($data['banktype'])){
				pdo_update('fm453_shopping_member',$data,array('from_user' => $from_user));
				if($_GPC['opp']=='complated'){
					echo 3;
					exit();
				}
				echo 1;

			}else{
				echo 0;
			}

			exit();
		}


		//include $this->template($appstyle.$do.'/453');
		include $this->template($appstyle.$do.'/old_'.$ac.'/index');
