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
echo $adminMenu->addNavigation('discounts.php');	
switch($_REQUEST['op']) 
{
	default:
	case "list":
		$discount_handler =& xoops_getmodulehandler('discounts', 'xpayment');
		
		$limit = !empty($_REQUEST['limit'])?intval($_REQUEST['limit']):30;
		$start = !empty($_REQUEST['start'])?intval($_REQUEST['start']):0;
		$order = !empty($_REQUEST['order'])?$_REQUEST['order']:'DESC';
		$sort = !empty($_REQUEST['sort'])?$_REQUEST['sort']:'created';
		$filter = !empty($_REQUEST['filter'])?$_REQUEST['filter']:'1,1';
		
		$criteria = $discount_handler->getFilterCriteria($filter);
		$ttl = $discount_handler->getCount($criteria);
		
		$pagenav = new XoopsPageNav($ttl, $limit, $start, 'start', 'limit='.$limit.'&sort='.$sort.'&order='.$order.'&filter='.$filter.'&op='.$_REQUEST['op'].'&fct='.$_REQUEST['fct']);
		$GLOBALS['xoopsTpl']->assign('pagenav', $pagenav->renderNav());

		foreach (array(	'did','uid','code','email','validtill','redeems','discount','redeemed',
						'iids','`created`','updated') as $id => $key) {
			$GLOBALS['xoopsTpl']->assign(strtolower($key.'_th'), '<a href="'.$_SERVER['PHP_SELF'].'?start='.$start.'&limit='.$limit.'&sort='.$key.'&order='.(($key==$sort)?($order=='ASC'?'DESC':'ASC'):$order).'&op='.$_REQUEST['op'].'&fct='.$_REQUEST['fct'].'">'.(defined('_XPY_AM_TH_'.strtoupper($key))?constant('_XPY_AM_TH_'.strtoupper($key)):'_XPY_AM_TH_'.strtoupper($key)).'</a>');
			$GLOBALS['xoopsTpl']->assign('filter_'.strtolower(str_replace('-','_',$key)).'_th', $discount_handler->getFilterForm($filter, $key, $sort, $fct));
		}
		
		$criteria->setStart($start);
		$criteria->setLimit($limit);
		$criteria->setSort('`'.$sort.'`');
		$criteria->setOrder($order);
		
		$GLOBALS['xoopsTpl']->assign('start', $start);
		$GLOBALS['xoopsTpl']->assign('limit', $limit);
		$GLOBALS['xoopsTpl']->assign('sort', $sort);
		$GLOBALS['xoopsTpl']->assign('order', $order);
		$GLOBALS['xoopsTpl']->assign('filter', $filter);
		
		$GLOBALS['xoopsTpl']->assign('form', xpayment_admincreatediscounts());
		
		$discounts = $discount_handler->getObjects($criteria, true);
		foreach($discounts as $iid => $discount) {
			$GLOBALS['xoopsTpl']->append('discounts', $discount->toArray());
		}
		
		$GLOBALS['xoopsTpl']->display('db:xpayment_cpanel_discounts_list.html');
		break;
	case "create":
		extract($_POST);
		if (intval($redeems)==0) {
			redirect_header($_SERVER['PHP_SELF'].'?op=discounts&fct=list&sort='.$sort.'&order='.$order.'&start='.$start.'&limit='.$limit.'&filter='.$filter, 3, _XPY_MSG_DISCOUNT_NOREDEEMS_SPECIFIED);
			exit(0);
		}
		if (intval($discount)==0) {
			redirect_header($_SERVER['PHP_SELF'].'?op=discounts&fct=list&sort='.$sort.'&order='.$order.'&start='.$start.'&limit='.$limit.'&filter='.$filter, 3, _XPY_MSG_DISCOUNT_NODISCOUNT_SPECIFIED);
			exit(0);
		}
		$created=0;
		$reminders=0;
		$prefix = str_replace(' ', '', $prefix);
		$discount_handler =& xoops_getmodulehandler('discounts', 'xpayment');
		foreach(explode("|", $emails) as $email) {
			if(eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $email)) {
				if (!$dis = $discount_handler->getByEmail($email)) {
					if ($discount_handler->sendDiscountCode($email, ($validtill_infinte==true?0:strtotime($validtill['date'])+$validtill['time']), intval($redeems), (float)$discount, $prefix, 0))
						$created++;
				} else {
					if ($dis->sendReminderEmail())
						$reminders++;
				}
			}
		}
		if ($scan==true) {
			foreach($groups as $group) {
				foreach($discount_handler->getUsersByGroup($group, ($logon==true?strtotime($logon_datetime['date'])+$logon_datetime['time']:0), ($since==true?strtotime($since_datetime['date'])+$since_datetime['time']:0), true) as $user) {
					if (!$dis = $discount_handler->getByEmail($user->getVar('email'))) {
						if ($discount_handler->sendDiscountCode($user->getVar('email'), ($validtill_infinte==true?0:strtotime($validtill['date'])+$validtill['time']), intval($redeems), (float)$discount, $prefix, $user->getVar('uid')))
							$created++;
					} else {
						if ($dis->sendReminderEmail())
							$reminders++;
					}
				}
			}	
		}
		redirect_header($_SERVER['PHP_SELF'].'?op=discounts&fct=list&sort='.$sort.'&order='.$order.'&start='.$start.'&limit='.$limit.'&filter='.$filter, 3, sprintf(_XPY_MSG_DISCOUNT_CREATED_REMINDED, $created, $reminders));
		exit(0);
	break;
}
xoops_cp_footer();