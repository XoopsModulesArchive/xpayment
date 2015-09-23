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
 * @copyright       Chronolabs Co-Op http://www.chronolabs.coop/
 * @license         http://www.fsf.org/copyleft/gpl.html GNU public license
 * @package         xpayment
 * @since           1.30.0
 * @author          Simon Roberts <simon@chronolabs.coop>
 * @translation     Erol Konik <aphex@aphexthemes.com>
 * @translation     Mariane <mariane_antoun@hotmail.com>
 * @translation     Voltan <voltan@xoops.ir>
 * @translation     Ezsky <ezskyyoung@gmail.com>
 * @translation     Richardo Costa <lusopoemas@gmail.com>
 * @translation     Kris_fr <kris@frxoops.org>
 */	
	include('header.php');
	
	if (!is_object($GLOBALS['xoopsUser'])) {
		redirect_header(XOOPS_URL.'/modules/xpayment/index.php', 3, _NOPERM);
		exit(0);
	}
	
	if (!in_array($GLOBALS['xoopsModuleConfig']['officers'], $GLOBALS['xoopsUser']->getGroups())) {
		redirect_header(XOOPS_URL.'/modules/xpayment/index.php', 3, _NOPERM);
		exit(0);
	}
	
	xoops_loadLanguage('admin', 'xpayment');
		
	switch($_REQUEST['op']) {
	default:
	case "invoices":	
		switch ($_REQUEST['fct'])
		{
		default:
		case "list":
			$xoopsOption['template_main'] = 'xpayment_invoice_list.html';
			include_once $GLOBALS['xoops']->path( "/header.php" );
			$GLOBALS['xoopsTpl']->assign('php_self', $_SERVER['PHP_SELF']);
			
			$invoice_handler =& xoops_getmodulehandler('invoice', 'xpayment');
			
			$criteria = new CriteriaCompo(new Criteria('officer_uids', '%"'.$GLOBALS['xoopsUser']->getVar('uid').'"%', 'LIKE'));
			$criteria->add(new Criteria('remittion', "('NOTICE', 'COLLECT', 'SETTLED', 'PENDING')", 'IN'));
			
			$ttl = $invoice_handler->getCount($criteria);
			$limit = !empty($_REQUEST['limit'])?intval($_REQUEST['limit']):30;
			$start = !empty($_REQUEST['start'])?intval($_REQUEST['start']):0;
			$order = !empty($_REQUEST['order'])?$_REQUEST['order']:'DESC';
			$sort = !empty($_REQUEST['sort'])?$_REQUEST['sort']:'created';
			
			$pagenav = new XoopsPageNav($ttl, $limit, $start, 'start', 'limit='.$limit.'&sort='.$sort.'&order='.$order.'&op='.$_REQUEST['op'].'&fct='.$_REQUEST['fct']);
			$GLOBALS['xoopsTpl']->assign('pagenav', $pagenav->renderNav());

			foreach (array(	'mode','invoicenumber','drawfor','drawto','drawto_email','amount','grand','shipping',
							'handling','weight','weight_unit','tax','currency','items','transactionid','created',
							'updated','actioned','reoccurence','reoccurences','reoccurence_period_days','occurence',
							'previous','occurence_grand','occurence_amount','occurence_tax','occurence_shipping',
							'occurence_handling','occurence_weight','remittion','remittion_settled',
							'donation','comment','user_ip','user_netaddy','user_uid','remitted','due',
							'collect','wait','offline', 'remittion') as $id => $key) {
				$GLOBALS['xoopsTpl']->assign(strtolower($key.'_th'), '<a href="'.$_SERVER['PHP_SELF'].'?start='.$start.'&limit='.$limit.'&sort='.$key.'&order='.(($key==$sort)?($order=='ASC'?'DESC':'ASC'):$order).'&op='.$_REQUEST['op'].'&fct='.$_REQUEST['fct'].'">'.(defined('_XPY_AM_TH_'.strtoupper($key))?constant('_XPY_AM_TH_'.strtoupper($key)):'_XPY_AM_TH_'.strtoupper($key)).'</a>');
			}
			
			$criteria->setStart($start);
			$criteria->setLimit($limit);
			$criteria->setSort($sort);
			$criteria->setOrder($order);
			
			$invoices = $invoice_handler->getObjects($criteria, true);
			foreach($invoices as $iid => $invoice) {
				$GLOBALS['xoopsTpl']->append('invoices', $invoice->toArray());
			}
					
			break;
		case 'view':
			$xoopsOption['template_main'] = 'xpayment_invoice_view.html';
			include_once $GLOBALS['xoops']->path( "/header.php" );
			$GLOBALS['xoopsTpl']->assign('php_self', $_SERVER['PHP_SELF']);
			
			$invoice_handler =& xoops_getmodulehandler('invoice', 'xpayment');
			$invoice_items_handler =& xoops_getmodulehandler('invoice_items', 'xpayment');
		
			$invoice =& $invoice_handler->get($_GET['iid']);
					
			$GLOBALS['xoopsTpl']->assign('invoice', $invoice->toArray());
			
			if ($invoice->getVar('mode')=='UNPAID')
				$GLOBALS['xoopsTpl']->assign('payment_markup', $invoice->getAdminPaymentHtml());

			if ($invoice->getVar('mode')=='UNPAID'&&($invoice->getVar('remittion')=='COLLECT'||$invoice->getVar('remittion')=='SETTLED'))
				$GLOBALS['xoopsTpl']->assign('settle_markup', $invoice->getAdminSettleHtml());
				
			$criteria = new Criteria('iid', $invoice->getVar('iid'));
			$items = $invoice_items_handler->getObjects($criteria, true);
			foreach($items as $iiid => $item)
				$GLOBALS['xoopsTpl']->append('items',  $item->toArray());
			
			
							
			break;
		case 'cancel':
			
			include_once $GLOBALS['xoops']->path( "/header.php" );
			$GLOBALS['xoopsTpl']->assign('php_self', $_SERVER['PHP_SELF']);
			
			if (!isset($_POST['confirm'])) {
				xoops_confirm(array('confirm'=>true,'op'=>$_REQUEST['op'],'fct'=>$_REQUEST['fct'],'iid'=>$_REQUEST['iid']), $_SERVER['PHP_SELF'], _XPY_MSG_CONFIRM_CANCEL);
				include($GLOBALS['xoops']->path('/footer.php'));
				exit(0);
			}
			
			$invoice_handler =& xoops_getmodulehandler('invoice', 'xpayment');
			$invoice = $invoice_handler->get($_REQUEST['iid']);
			$invoice->setVar('mode', 'CANCEL');
			$invoice_handler->insert($invoice);
			$invoice->runPlugin();
			redirect_header($_SERVER['PHP_SELF'].'?op=invoices&fct=list', 3, _XPY_MSG_INVOICE_CANCELED);
			exit(0);
			break;
		case 'transaction':
			
			$invoice_handler =& xoops_getmodulehandler('invoice', 'xpayment');
			$invoice_transactions_handler =& xoops_getmodulehandler('invoice_transactions', 'xpayment');
			$invoice_transactions = $invoice_transactions_handler->create();		
			$invoice = $invoice_handler->get($_REQUEST['iid']);
			$invoice_transactions->setVar('transactionid', $_REQUEST['transactionid']);
			$invoice_transactions->setVar('iid', $_REQUEST['iid']);
			$invoice_transactions->setVar('invoice', $_REQUEST['iid']);
			$invoice_transactions->setVar('date', time());
			$invoice_transactions->setVar('email', $GLOBALS['xoopsConfig']['adminmail']);
			$invoice_transactions->setVar('gross', $_REQUEST['amount']);
			$invoice_transactions->setVar('status', 'Manual');
			$invoice_transactions_handler->insert($invoice_transactions);
			$gross = $invoice_transactions_handler->sumOfGross($_REQUEST['iid']);
			if ($gross>=$invoice->getVar('grand'))
				$invoice->setVar('mode', 'PAID');
			$invoice->setVar('transactionid', $_REQUEST['transactionid']);
			$invoice_handler->insert($invoice);
			redirect_header($_SERVER['PHP_SELF'].'?op=invoices&fct=list', 3, _XPY_MSG_INVOICE_PAID);
			exit(0);
			break;
		case 'settle':
			$invoice_handler =& xoops_getmodulehandler('invoice', 'xpayment');
			$invoice = $invoice_handler->get($_REQUEST['iid']);
			$invoice->setVar('remittion','SETTLED');
			$invoice->setVar('remittion_settled',$_REQUEST['settlement']);
			$invoice_handler->insert($invoice);
			redirect_header($_SERVER['PHP_SELF'].'?op=invoices&fct=list', 3, _XPY_MSG_INVOICE_SETTLEMENT);
			exit(0);
			break;
			
		}
		break;
	case "transactions":	
	
		switch ($_REQUEST['fct'])
		{
		default:
		case "list":
			$xoopsOption['template_main'] = 'xpayment_transactions_list.html';
			include_once $GLOBALS['xoops']->path( "/header.php" );
			$GLOBALS['xoopsTpl']->assign('php_self', $_SERVER['PHP_SELF']);
			
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
				$criteria->setSort($sort);
				$criteria->setOrder($order);
			} else {
				$pagenav = new XoopsPageNav($ttl, $limit, $start, 'start', 'limit='.$limit.'&sort='.$sort.'&order='.$order.'&iid='.$_REQUEST['iid'].'&op='.$_REQUEST['op'].'&fct='.$_REQUEST['fct']);
				$GLOBALS['xoopsTpl']->assign('pagenav', $pagenav->renderNav());
						
				$criteria = new Criteria('iid',$_REQUEST['iid']);
				$criteria->setStart($start);
				$criteria->setLimit($limit);
				$criteria->setSort($sort);
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
			
			break;
		case 'view':
			$xoopsOption['template_main'] = 'xpayment_transactions_view.html';
			include_once $GLOBALS['xoops']->path( "/header.php" );
			$GLOBALS['xoopsTpl']->assign('php_self', $_SERVER['PHP_SELF']);
			
			$invoice_transactions_handler =& xoops_getmodulehandler('invoice_transactions', 'xpayment');
			$transaction =& $invoice_transactions_handler->get($_GET['tiid']);
			$GLOBALS['xoopsTpl']->assign('transaction', $transaction->toArray());
			break;
		}
		break;	
		
	}
	
	include($GLOBALS['xoops']->path('/footer.php'));
?>