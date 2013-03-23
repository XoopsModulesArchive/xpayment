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
echo $adminMenu->addNavigation('transactions.php');		
switch($_REQUEST['op']) 
{		
	case "list":
	default:
		$invoice_transactions_handler =& xoops_getmodulehandler('invoice_transactions', 'xpayment');
		
		$ttl = $invoice_transactions_handler->getCount(NULL);
		$limit = !empty($_REQUEST['limit'])?intval($_REQUEST['limit']):30;
		$start = !empty($_REQUEST['start'])?intval($_REQUEST['start']):0;
		$order = !empty($_REQUEST['order'])?$_REQUEST['order']:'DESC';
		$sort = !empty($_REQUEST['sort'])?$_REQUEST['sort']:'date';
					
		if ($_GET['iid']==0) {
			$pagenav = new XoopsPageNav($ttl, $limit, $start, 'start', 'limit='.$limit.'&sort='.$sort.'&order='.$order.'&op='.$_REQUEST['op'].'&fct='.$_REQUEST['fct']);
			$GLOBALS['xoopsTpl']->assign('pagenav', $pagenav->renderNav());
					
			$criteria = new Criteria('1','1');
			$criteria->setStart($start);
			$criteria->setLimit($limit);
			$criteria->setSort('`'.$sort.'`');
			$criteria->setOrder($order);
		} else {
			$pagenav = new XoopsPageNav($ttl, $limit, $start, 'start', 'limit='.$limit.'&sort='.$sort.'&order='.$order.'&iid='.$_REQUEST['iid'].'&op='.$_REQUEST['op'].'&fct='.$_REQUEST['fct']);
			$GLOBALS['xoopsTpl']->assign('pagenav', $pagenav->renderNav());
					
			$criteria = new Criteria('iid',$_REQUEST['iid']);
			$criteria->setStart($start);
			$criteria->setLimit($limit);
			$criteria->setSort('`'.$sort.'`');
			$criteria->setOrder($order);
			
			$invoice_handler =& xoops_getmodulehandler('invoice', 'xpayment');
			$invoice =& $invoice_handler->get($_GET['iid']);
			$GLOBALS['xoopsTpl']->assign('invoice', $invoice->toArray());
			
		}
		
		$transactions = $invoice_transactions_handler->getObjects($criteria, true);
		
		foreach($transactions as $tiid => $transaction) {
			$GLOBALS['xoopsTpl']->append('transactions', $transaction->toArray());
		}		
		
		if ($_GET['iid']==0) {
			foreach (array(	'transactionid','email','invoice','status','date','gross','fee','settle',
							'exchangerate','firstname','lastname','street','city','state','postcode','country',
							'address_status','payer_email','payer_status','gateway', 'plugin') as $id => $key) {
					$GLOBALS['xoopsTpl']->assign($key.'_th', '<a href="'.$_SERVER['PHP_SELF'].'?'.'start='.$start.'&limit='.$limit.'&sort='.$key.'&order='.(($key==$sort)?($order=='ASC'?'DESC':'ASC'):$order).'&op='.$_REQUEST['op'].'&fct='.$_REQUEST['fct'].'">'.(defined('_XPY_AM_TH_'.strtoupper($key))?constant('_XPY_AM_TH_'.strtoupper($key)):'_XPY_AM_TH_'.strtoupper($key)).'</a>');
			}
		} else {
			foreach (array(	'transactionid','email','invoice','status','date','gross','fee','settle',
							'exchangerate','firstname','lastname','street','city','state','postcode','country',
							'address_status','payer_email','payer_status','gateway', 'plugin') as $id => $key) {
				$GLOBALS['xoopsTpl']->assign($key.'_th', '<a href="'.$_SERVER['PHP_SELF'].'?'.'start='.$start.'&limit='.$limit.'&sort='.$key.'&order='.(($key==$sort)?($order=='ASC'?'DESC':'ASC'):$order).'&op='.$_REQUEST['op'].'&fct='.$_REQUEST['fct'].'&iid='.$_REQUEST['iid'].'">'.(defined('_XPY_AM_TH_'.strtoupper($key))?constant('_XPY_AM_TH_'.strtoupper($key)):'_XPY_AM_TH_'.strtoupper($key)).'</a>');
			}
		}
		$GLOBALS['xoopsTpl']->display('db:xpayment_cpanel_transactions_list.html');
	break;
	
	case 'view':
		$invoice_transactions_handler =& xoops_getmodulehandler('invoice_transactions', 'xpayment');
		$transaction =& $invoice_transactions_handler->get($_GET['tiid']);
		$GLOBALS['xoopsTpl']->assign('transaction', $transaction->toArray());
		loadModuleAdminMenu(2);
		$GLOBALS['xoopsTpl']->display('db:xpayment_cpanel_transactions_view.html');
	break;
}

xoops_cp_footer();