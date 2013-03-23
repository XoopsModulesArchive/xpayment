<?php
/**
 * Invoice Transaction Gateway with Modular Plugin set
 *
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * @copyright       Chronolabs Co-Op http://www.chronolabs.com.au/
 * @license         http://www.fsf.org/copyleft/gpl.html GNU public license
 * @package         xpayment
 * @since           2.5.5
 * @author          Simon Roberts <simon@chronolabs.com.au>
 * @translation     Erol Konik <aphex@aphexthemes.com>
 * @translation     Mariane <mariane_antoun@hotmail.com>
 * @translation     Voltan <voltan@xoops.ir>
 * @translation     Ezsky <ezskyyoung@gmail.com>
 * @translation     Richardo Costa <lusopoemas@gmail.com>
 * @translation     Kris_fr <kris@frxoops.org>
 * @version         $Id: permissions.php 11084 2013-02-23 15:44:20Z timgno $
 */	
include('header.php');
	
$GLOBALS['xoopsTpl']->assign('php_self', $_SERVER['PHP_SELF']);
	
xoops_loadLanguage('admin', 'xpayment');
echo $adminMenu->addNavigation('groups.php');	
switch($_REQUEST['op']) 
{	
	case "brokers":
	case "accounts":
	case "officers":	
		$groups_handler =& xoops_getmodulehandler('groups', 'xpayment');

		switch ($_REQUEST['fct'])
		{
			case "brokers":
				$criteria = new Criteria('mode', 'BROKERS');
				break;
			case "accounts":
				$criteria = new Criteria('mode', 'ACCOUNTS');
				break;
			case "officers":
				$criteria = new Criteria('mode', 'OFFICERS');
				break;
		}
		$ttl = $groups_handler->getCount($criteria);
		$limit = !empty($_REQUEST['limit'])?intval($_REQUEST['limit']):30;
		$start = !empty($_REQUEST['start'])?intval($_REQUEST['start']):0;
		$order = !empty($_REQUEST['order'])?$_REQUEST['order']:'DESC';
		$sort = !empty($_REQUEST['sort'])?$_REQUEST['sort']:'plugin';
		
		$pagenav = new XoopsPageNav($ttl, $limit, $start, 'start', 'limit='.$limit.'&sort='.$sort.'&order='.$order.'&op='.$_REQUEST['op'].'&fct='.$_REQUEST['fct']);
		$GLOBALS['xoopsTpl']->assign('pagenav', $pagenav->renderNav());

		foreach (array(	'rid','mode','plugin','uid','limit','maximum','minimum') as $id => $key) {
			$GLOBALS['xoopsTpl']->assign(strtolower($key.'_th'), '<a href="'.$_SERVER['PHP_SELF'].'?start='.$start.'&limit='.$limit.'&sort='.$key.'&order='.(($key==$sort)?($order=='ASC'?'DESC':'ASC'):$order).'&op='.$_REQUEST['op'].'&fct='.$_REQUEST['fct'].'">'.(defined('_XPY_AM_TH_'.strtoupper($key))?constant('_XPY_AM_TH_'.strtoupper($key)):'_XPY_AM_TH_'.strtoupper($key)).'</a>');
		}
		
		$criteria->setStart($start);
		$criteria->setLimit($limit);
		$criteria->setSort('`'.$sort.'`');
		$criteria->setOrder($order);
		
		$groups = $groups_handler->getObjects($criteria, true);
		foreach($groups as $rid => $group) {
			$GLOBALS['xoopsTpl']->append('groups', $group->toArray());
		}
				
		$module_handler =& xoops_gethandler('module');
		$config_handler =& xoops_gethandler('config');
		$xoMod = $module_handler->getByDirname('xpayment');
		$xoConfig = $config_handler->getConfigList($xoMod->getVar('mid'));			
		
		$GLOBALS['xoopsTpl']->assign('form', xpayment_adminrule(0, $xoConfig[$_REQUEST['fct']]));

		$opform = new XoopsSimpleForm(_XPY_AM_GROUP_FCT, 'actionform', 'index.php', "get");
		$op_select = new XoopsFormSelect("", 'fct', $_REQUEST['fct']);
		$op_select->setExtra('onchange="document.forms.actionform.submit()"');
		$op_select->addOptionArray(array(
			"brokers"=>_XPY_AM_GROUP_BROKERS, 
			"accounts"=>_XPY_AM_GROUP_ACCOUNTS,
			"officers"=>_XPY_AM_GROUP_OFFICERS
			));
		$opform->addElement($op_select);
		$opform->addElement(new XoopsFormHidden('op', 'groups'));
		$GLOBALS['xoopsTpl']->assign('selectform', $opform->render());

		$GLOBALS['xoopsTpl']->display('db:xpayment_cpanel_groups.html');
		break;
	case 'save':
		$groups_handler =& xoops_getmodulehandler('groups', 'xpayment');
		if ($_REQUEST['rid']==0)
			$group = $groups_handler->create();
		else 
			$group = $groups_handler->get($_REQUEST['rid']);

		$group->setVars($_POST);
		
		switch ($_REQUEST['action'])
		{
			case "brokers":
				$group->setVar('mode', 'BROKERS');
				$fct = $_REQUEST['action'];
				break;
			case "accounts":
				$group->setVar('mode', 'ACCOUNTS');
				$fct = $_REQUEST['action'];
				break;
			case "officers":
				$group->setVar('mode', 'OFFICERS');
				$fct = $_REQUEST['action'];
				break;
			default:
				$fct = 'brokers';
				break;
		}
		
		$groups_handler->insert($group, true);
		redirect_header($_SERVER['PHP_SELF'].'?op=groups&fct='.$fct, 3, _XPY_MSG_RULE_SAVED);
	break;
		
	case 'edit':
		$groups_handler =& xoops_getmodulehandler('groups', 'xpayment');
		if ($_REQUEST['rid']==0)
			$group = $groups_handler->create();
		else 
			$group = $groups_handler->get($_REQUEST['rid']);

		$module_handler =& xoops_gethandler('module');
		$config_handler =& xoops_gethandler('config');
		$xoMod = $module_handler->getByDirname('xpayment');
		$xoConfig = $config_handler->getConfigList($xoMod->getVar('mid'));			
			
		switch($group->getVar('mode')){
			case "BROKERS":
				$groupid = $xoConfig['brokers'];
				break;
			case "ACCOUNTS":
				$groupid = $xoConfig['accounts'];
				break;		
			case "OFFICERS":
				$groupid = $xoConfig['officers'];
				break;			
		}
		$GLOBALS['xoopsTpl']->assign('form', xpayment_adminrule($_REQUEST['rid'], $groupid));
		$GLOBALS['xoopsTpl']->display('db:xpayment_cpanel_groups_edit.html');
	break;
	
	case 'delete':
		if (!isset($_POST['confirm'])) {
			xoops_confirm(array('confirm'=>true,'op'=>$_REQUEST['op'],'fct'=>$_REQUEST['fct'],'rid'=>$_REQUEST['rid']), $_SERVER['PHP_SELF'], _XPY_MSG_CONFIRM_DELETE);
			xoops_cp_footer();
			exit(0);
		}
		$groups_handler =& xoops_getmodulehandler('groups', 'xpayment');
		$group = $groups_handler->get($_REQUEST['rid']);
		$groups_handler->delete($group);
		redirect_header($_SERVER['PHP_SELF'].'?op=groups&fct=brokers', 3, _XPY_MSG_RULE_DELETED);
		exit(0);
	break;
}
xoops_cp_footer();