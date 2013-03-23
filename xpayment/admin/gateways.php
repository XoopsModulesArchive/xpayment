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
echo $adminMenu->addNavigation('gateways.php');	
switch($_REQUEST['op']) 
{		
	case "list":
	default:
		$gateways_handler =& xoops_getmodulehandler('gateways', 'xpayment');
		$gateway = $gateways_handler->get($_REQUEST['gid']);
		if (is_object($gateway)) 
			include_once($GLOBALS['xoops']->path('/modules/xpayment/class/gateway/'.$gateway->getVar('class').'/language/'.$GLOBALS['xoopsConfig']['language'].'/'.$gateway->getVar('class').'.php'));
		
		$ttl = $gateways_handler->getCount(NULL);
		$limit = !empty($_REQUEST['limit'])?intval($_REQUEST['limit']):30;
		$start = !empty($_REQUEST['start'])?intval($_REQUEST['start']):0;
		$order = !empty($_REQUEST['order'])?$_REQUEST['order']:'DESC';
		$sort = !empty($_REQUEST['sort'])?$_REQUEST['sort']:'name';
		
		$pagenav = new XoopsPageNav($ttl, $limit, $start, 'start', 'limit='.$limit.'&sort='.$sort.'&order='.$order.'&op='.$_REQUEST['op'].'&fct='.$_REQUEST['fct']);
		$GLOBALS['xoopsTpl']->assign('pagenav', $pagenav->renderNav());

		foreach (array(	'name','description','author','testmode') as $id => $key) {
			$GLOBALS['xoopsTpl']->assign(strtolower($key.'_th'), '<a href="'.$_SERVER['PHP_SELF'].'?start='.$start.'&limit='.$limit.'&sort='.$key.'&order='.(($key==$sort)?($order=='ASC'?'DESC':'ASC'):$order).'&op='.$_REQUEST['op'].'&fct='.$_REQUEST['fct'].'">'.(defined('_XPY_AM_TH_'.strtoupper($key))?constant('_XPY_AM_TH_'.strtoupper($key)):'_XPY_AM_TH_'.strtoupper($key)).'</a>');
		}
		
		$criteria = new Criteria('1','1');
		$criteria->setStart($start);
		$criteria->setLimit($limit);
		$criteria->setSort('`'.$sort.'`');
		$criteria->setOrder($order);
		
		$gateways = $gateways_handler->getObjects($criteria, true);
		foreach($gateways as $gid => $gateway) {
			
			xoops_loadLanguage($gateway->getVar('class'), 'xpayment');
			
			$ret = $gateway->toArray();
			$ret['name'] = (defined($ret['name'])?constant($ret['name']):$ret['name']);
			$ret['description'] = (defined($ret['description'])?constant($ret['description']):$ret['description']);
			$ret['author'] = (defined($ret['author'])?constant($ret['author']):$ret['author']);
			$GLOBALS['xoopsTpl']->append('gateways', $ret);
			$installed[$gateway->getVar('class')] = $gateway->getVar('class');
		}
		
		xoops_load('XoopsLists');
		$gateways = XoopsLists::getDirListAsArray($GLOBALS['xoops']->path('/modules/xpayment/class/gateway/'));
				
		foreach($gateways as $class) {
			if (!in_array($class, $installed)) {
				include($GLOBALS['xoops']->path('/modules/xpayment/class/gateway/'.$class.'/gateway_info.php'));
				if (!empty($gateway)) {
					$ret = $gateway;
					$ret['name'] = (defined($ret['name'])?constant($ret['name']):$ret['name']);
					$ret['description'] = (defined($ret['description'])?constant($ret['description']):$ret['description']);
					$ret['author'] = (defined($ret['author'])?constant($ret['author']):$ret['author']);
					$GLOBALS['xoopsTpl']->append('uninstalled', $ret);
				}
			}
		}			
		$GLOBALS['xoopsTpl']->display('db:xpayment_cpanel_gateways_list.html');
	break;

	case "options":
		$gateways_options_handler =& xoops_getmodulehandler('gateways_options', 'xpayment');
		$gateways_handler =& xoops_getmodulehandler('gateways', 'xpayment');
		$gateway = $gateways_handler->get($_GET['gid']);
		
		xoops_loadLanguage($gateway->getVar('class'), 'xpayment');
		
		$criteria = new Criteria('gid',$_GET['gid']);
		
		$options = $gateways_options_handler->getObjects($criteria, true);
		foreach($options as $goid => $option) {
			$ret=$option->toArray();
			$ret['name'] = (defined($ret['name'])?constant($ret['name']):$ret['name']);
			$GLOBALS['xoopsTpl']->append('options', $ret);
		}
		loadModuleAdminMenu(3);
		$GLOBALS['xoopsTpl']->display('db:xpayment_cpanel_gateways_options.html');
		break;
		
	case 'settestmode':
		$gateways_handler =& xoops_getmodulehandler('gateways', 'xpayment');
		$gateways = $gateways_handler->getObjects(NULL, true);
		
		foreach($gateways as $gid => $gateway) {
			$gateway->setVar('testmode', ($_POST['testmode'][$gid]==true?true:false));
			$gateways_handler->insert($gateway);
		}
		redirect_header($_SERVER['PHP_SELF'].'?op=gateways&fct=list', 3, _XPY_MSG_TESTMODES_SAVED);
		exit(0);
		break;
	case 'setoptions':
		$gateways_options_handler =& xoops_getmodulehandler('gateways_options', 'xpayment');
		foreach($_POST['value'] as $goid => $value) {
			$option =$gateways_options_handler->get($goid);
			$option->setVar('value', $value);
			$gateways_options_handler->insert($option);
		}
		redirect_header($_SERVER['PHP_SELF'].'?op=gateways&fct=list', 3, _XPY_MSG_OPTIONS_SAVED);
		exit(0);
		break;
	case 'update':
		xpayment_update_gateway($_GET['class']);
		redirect_header($_SERVER['PHP_SELF'].'?op=gateways&fct=list', 3, _XPY_MSG_GATEWAY_UPDATED);
		exit(0);
		break;
	case 'install':
		xpayment_install_gateway($_GET['class']);
		redirect_header($_SERVER['PHP_SELF'].'?op=gateways&fct=list', 3, _XPY_MSG_GATEWAY_INSTALL);
		exit(0);
	break;
}
xoops_cp_footer();