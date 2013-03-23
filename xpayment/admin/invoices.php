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
echo $adminMenu->addNavigation('invoices.php');		
switch ($_REQUEST['op'])
{
	case "list":
	default:	
		$invoice_handler =& xoops_getmodulehandler('invoice', 'xpayment');		
		
		$limit = !empty($_REQUEST['limit'])?intval($_REQUEST['limit']):30;
		$start = !empty($_REQUEST['start'])?intval($_REQUEST['start']):0;
		$order = !empty($_REQUEST['order'])?$_REQUEST['order']:'DESC';
		$sort = !empty($_REQUEST['sort'])?$_REQUEST['sort']:'created';
		$filter = !empty($_REQUEST['filter'])?$_REQUEST['filter']:'1,1';
		
		$criteria = $invoice_handler->getFilterCriteria($filter);
		$ttl = $invoice_handler->getCount($criteria);
		
		
		$pagenav = new XoopsPageNav($ttl, $limit, $start, 'start', 'limit='.$limit.'&sort='.$sort.'&order='.$order.'&filter='.$filter.'&op='.$_REQUEST['op'].'&fct='.$_REQUEST['fct']);
		$GLOBALS['xoopsTpl']->assign('pagenav', $pagenav->renderNav());

		foreach (array(	'mode','invoicenumber','drawfor','drawto','drawto_email','amount','grand','shipping',
						'handling','weight','weight_unit','tax','currency','items','transactionid','`created`',
						'updated','actioned','reoccurence','reoccurences','reoccurence_period_days','occurence',
						'previous','occurence_grand','occurence_amount','occurence_tax','occurence_shipping',
						'occurence_handling','occurence_weight','remittion','remittion_settled',
						'donation','comment','user_ip','user_netaddy','user_uid','remitted','due',
						'collect','wait','offline','remittion','discount','discount_amount', 'rate', 'interest') as $id => $key) {
			$GLOBALS['xoopsTpl']->assign(strtolower($key.'_th'), '<a href="'.$_SERVER['PHP_SELF'].'?start='.$start.'&limit='.$limit.'&sort='.$key.'&order='.(($key==$sort)?($order=='ASC'?'DESC':'ASC'):$order).'&op='.$_REQUEST['op'].'&fct='.$_REQUEST['fct'].'">'.(defined('_XPY_AM_TH_'.strtoupper($key))?constant('_XPY_AM_TH_'.strtoupper($key)):'_XPY_AM_TH_'.strtoupper($key)).'</a>');
			$GLOBALS['xoopsTpl']->assign('filter_'.strtolower(str_replace('-','_',$key)).'_th', $invoice_handler->getFilterForm($filter, $key, $sort, $fct));
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
		
		$invoices = $invoice_handler->getObjects($criteria, true);
		foreach($invoices as $iid => $invoice) {
			$GLOBALS['xoopsTpl']->append('invoices', $invoice->toArray());
		}
		$GLOBALS['xoopsTpl']->display('db:xpayment_cpanel_invoice_list.html');
	break;
	
	case "resendnotice":
		$invoice_handler =& xoops_getmodulehandler('invoice', 'xpayment');
		$invoice = $invoice_handler->get($_GET['iid']);
		
		$xoopsMailer =& getMailer();
		$xoopsMailer->setHTML(true);
		$xoopsMailer->setTemplateDir($GLOBALS['xoops']->path('/modules/xpayment/language/'.$GLOBALS['xoopsConfig']['language'].'/mail_templates/'));
		$xoopsMailer->setTemplate('xpayment_invoice_reminder.tpl');
		$xoopsMailer->setSubject(sprintf(_XPY_EMAIL_REMINDER_SUBJECT, $invoice->getVar('grand'), $invoice->getVar('currency'), $invoice->getVar('drawto')));
		
		$xoopsMailer->setToEmails($invoice->getVar('drawto_email'));
		
		$xoopsMailer->assign("SITEURL", XOOPS_URL);
		$xoopsMailer->assign("SITENAME", $GLOBALS['xoopsConfig']['sitename']);
		$xoopsMailer->assign("INVOICENUMBER", $invoice->getVar('invoicenumber'));
		$xoopsMailer->assign("CURRENCY", $invoice->getVar('currency'));
		$xoopsMailer->assign("DRAWTO", $invoice->getVar('drawto'));
		$xoopsMailer->assign("DRAWTO_EMAIL", $invoice->getVar('drawto_email'));
		$xoopsMailer->assign("DRAWFOR", $invoice->getVar('drawfor'));	
		$xoopsMailer->assign("AMOUNT", $invoice->getVar('grand'));
		$xoopsMailer->assign("INVURL", $invoice->getURL());
		$xoopsMailer->assign("PDFURL", $invoice->getPDFURL());
		
		if(!$xoopsMailer->send() ){
			xoops_error($xoopsMailer->getErrors(true), 'Email Send Error');
		}
		redirect_header($_SERVER['PHP_SELF'].'?op=invoices&fct=list', 3, _XPY_MSG_EMAIL_REMINDER_SENT);
		exit;
	break;	
		
	case 'export':
		set_time_limit(3600);	
		$GLOBALS['xoopsLogger']->activated = false;
		$invoice_handler =& xoops_getmodulehandler('invoice', 'xpayment');
		
		
		$limit = !empty($_REQUEST['limit'])?intval($_REQUEST['limit']):30;
		$start = !empty($_REQUEST['start'])?intval($_REQUEST['start']):0;
		$order = !empty($_REQUEST['order'])?$_REQUEST['order']:'DESC';
		$sort = !empty($_REQUEST['sort'])?$_REQUEST['sort']:'created';
		$filter = !empty($_REQUEST['filter'])?$_REQUEST['filter']:'1,1';		
		$criteria = $invoice_handler->getFilterCriteria($filter);
		$criteria->setSort('`'.$sort.'`');
		$criteria->setOrder($order);
		
		header('Content-Disposition: attachment; filename="invoices_'.md5($filter).'.csv"');
		header("Content-Type: text/comma-separated-values");			
		if ($invoice_handler->getCount($criteria)>0) {
			$invoices = $invoice_handler->getObjects($criteria, false);
			if ($invoices) {
				$i = 0;
				foreach($invoices[0]->toArray(false) as $field => $value) { 
						$i++;	
						print '"'.ucfirst($field).'"';
						if ($i<sizeof($invoices[0]->toArray(false)))
								print ',';
							else 
								print "\n";
						
				}
				foreach ($invoices as $iid => $invoice) {
					$i = 0;
					foreach($invoice->toArray(false) as $field => $value) {
						$i++;
						if (is_array($value))
							print '"'.implode(', ', $value).'"';
						elseif (!is_numeric($value))
							print '"'.$value.'"';
						else 
							print ''.$value.'';
						if ($i<sizeof($invoice->toArray(false)))
								print ',';
							else 
								print "\n";
					}
				}
			}
			exit(0);
		}
		redirect_header($_SERVER['PHP_SELF'].'?op=invoices&fct=list', 3, _NOPERM);
		exit(0);
	break;
	
	case 'view':
		
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
			
		$GLOBALS['xoopsTpl']->display('db:xpayment_cpanel_invoice_view.html');				
	break;
	
	case 'cancel':
		
		if (!isset($_POST['confirm'])) {
			xoops_confirm(array('confirm'=>true,'op'=>$_REQUEST['op'],'fct'=>$_REQUEST['fct'],'iid'=>$_REQUEST['iid']), $_SERVER['PHP_SELF'], _XPY_MSG_CONFIRM_CANCEL);
			xoops_cp_footer();
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
xoops_cp_footer();