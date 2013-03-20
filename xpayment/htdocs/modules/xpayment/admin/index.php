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
 * @since           1.30.0
 * @author          Simon Roberts <simon@chronolabs.com.au>
 * @translation     Erol Konik <aphex@aphexthemes.com>
 * @translation     Mariane <mariane_antoun@hotmail.com>
 * @translation     Voltan <voltan@xoops.ir>
 * @translation     Ezsky <ezskyyoung@gmail.com>
 * @translation     Richardo Costa <lusopoemas@gmail.com>
 * @translation     Kris_fr <kris@frxoops.org>
 */	
	include('header.php');
	error_reporting(0);
	xoops_cp_header();
	
	$GLOBALS['xoopsTpl']->assign('php_self', $_SERVER['PHP_SELF']);
	
	xoops_loadLanguage('admin', 'xpayment');
		
	switch($_REQUEST['op']) {
	case "invoices":	
		switch ($_REQUEST['fct'])
		{
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
		default:
		case "list":
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
			loadModuleAdminMenu(1);
			$GLOBALS['xoopsTpl']->display('db:xpayment_cpanel_invoice_list.html');
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
		break;
	case "discounts":	
		switch ($_REQUEST['fct'])
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
			loadModuleAdminMenu(8);		
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
		break;		
	case "tax":	
		switch ($_REQUEST['fct'])
		{
		default:
		case "list":
			$autotax_handler =& xoops_getmodulehandler('autotax', 'xpayment');
			
			$ttl = $autotax_handler->getCount(NULL);
			$limit = !empty($_REQUEST['limit'])?intval($_REQUEST['limit']):30;
			$start = !empty($_REQUEST['start'])?intval($_REQUEST['start']):0;
			$order = !empty($_REQUEST['order'])?$_REQUEST['order']:'ASC';
			$sort = !empty($_REQUEST['sort'])?$_REQUEST['sort']:'country';
						

			$pagenav = new XoopsPageNav($ttl, $limit, $start, 'start', 'limit='.$limit.'&sort='.$sort.'&order='.$order.'&op='.$_REQUEST['op'].'&fct='.$_REQUEST['fct']);
			$GLOBALS['xoopsTpl']->assign('pagenav', $pagenav->renderNav());
					
			$criteria = new Criteria('1','1');
			$criteria->setStart($start);
			$criteria->setLimit($limit);
			$criteria->setSort('`'.$sort.'`');
			$criteria->setOrder($order);
			
			$rates = $autotax_handler->getObjects($criteria, true);
			
			foreach($rates as $id => $rate) {
				$GLOBALS['xoopsTpl']->append('rates', $rate->toArray());
			}		
			
			
			foreach (array(	'country','code','rate') as $id => $key) {
					$GLOBALS['xoopsTpl']->assign($key.'_th', '<a href="'.$_SERVER['PHP_SELF'].'?'.'start='.$start.'&limit='.$limit.'&sort='.$key.'&order='.(($key==$sort)?($order=='ASC'?'DESC':'ASC'):$order).'&op='.$_REQUEST['op'].'&fct='.$_REQUEST['fct'].'">'.(defined('_XPY_AM_TH_'.strtoupper($key))?constant('_XPY_AM_TH_'.strtoupper($key)):'_XPY_AM_TH_'.strtoupper($key)).'</a>');
			}
			loadModuleAdminMenu(6);
			$GLOBALS['xoopsTpl']->display('db:xpayment_cpanel_tax_list.html');
			break;
		case 'save':
			$autotax_handler =& xoops_getmodulehandler('autotax', 'xpayment');
			foreach($_POST['id'] as $key=>$id) {
				$tax = $autotax_handler->get($id);
				$tax->setVars($_POST[$id]);
				$autotax_handler->insert($tax, true);
			}
			redirect_header($_SERVER['PHP_SELF'].'?op=tax&fct=list', 3, _XPY_MSG_TAX_SAVED);
			exit(0);
			break;
		}
		break;		
	case "transactions":	
	
		switch ($_REQUEST['fct'])
		{
		default:
		case "list":
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
			loadModuleAdminMenu(2);
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
		break;	
	case 'gateways':
		$gateways_handler =& xoops_getmodulehandler('gateways', 'xpayment');
		$gateway = $gateways_handler->get($_REQUEST['gid']);
		if (is_object($gateway)) 
			include_once($GLOBALS['xoops']->path('/modules/xpayment/class/gateway/'.$gateway->getVar('class').'/language/'.$GLOBALS['xoopsConfig']['language'].'/'.$gateway->getVar('class').'.php'));

		switch ($_REQUEST['fct'])
		{
		default:
		case "list":
			$gateways_handler =& xoops_getmodulehandler('gateways', 'xpayment');
			
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
			loadModuleAdminMenu(3);
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
		break;
	case "permissions":
		
		loadModuleAdminMenu(4);
		
		$opform = new XoopsSimpleForm(_XPY_AM_PERM_FCT, 'actionform', 'index.php', "get");
		$op_select = new XoopsFormSelect("", 'fct', $_REQUEST['fct']);
		$op_select->setExtra('onchange="document.forms.actionform.submit()"');
		$op_select->addOptionArray(array(
			"email"=>_XPY_AM_PERM_EMAIL, 
			"gateways"=>_XPY_AM_PERM_GATEWAYS, 
			));
		$opform->addElement($op_select);
		$opform->addElement(new XoopsFormHidden('op', 'permissions'));
		$opform->display();
				
		
		switch ($_REQUEST['fct'])
		{
		default:
		case "email":
			
			$base=array();
			$base[_XPY_ENUM_MODE_PAID] = _XPY_AM_MODE_DESC_PAID;
			$base[_XPY_ENUM_MODE_UNPAID] = _XPY_AM_MODE_DESC_UNPAID;
			$base[_XPY_ENUM_MODE_CANCEL] = _XPY_AM_MODE_DESC_CANCEL;
			
			$sub=array();
			$sub[_XPY_ENUM_MODE_PAID][_XPY_ENUM_REMITTION_NONE] = _XPY_AM_MODE_DESC_PAID_NONE;
			$sub[_XPY_ENUM_MODE_UNPAID][_XPY_ENUM_REMITTION_NONE] = _XPY_AM_MODE_DESC_UNPAID_NONE;
			$sub[_XPY_ENUM_MODE_CANCEL][_XPY_ENUM_REMITTION_NONE] = _XPY_AM_MODE_DESC_CANCEL_NONE;
			$sub[_XPY_ENUM_MODE_PAID][_XPY_ENUM_REMITTION_PENDING] = _XPY_AM_MODE_DESC_PAID_PENDING;
			$sub[_XPY_ENUM_MODE_UNPAID][_XPY_ENUM_REMITTION_PENDING] = _XPY_AM_MODE_DESC_UNPAID_PENDING;
			$sub[_XPY_ENUM_MODE_CANCEL][_XPY_ENUM_REMITTION_PENDING] = _XPY_AM_MODE_DESC_CANCEL_PENDING;
			$sub[_XPY_ENUM_MODE_PAID][_XPY_ENUM_REMITTION_NOTICE] = _XPY_AM_MODE_DESC_PAID_NOTICE;
			$sub[_XPY_ENUM_MODE_UNPAID][_XPY_ENUM_REMITTION_NOTICE] = _XPY_AM_MODE_DESC_UNPAID_NOTICE;
			$sub[_XPY_ENUM_MODE_CANCEL][_XPY_ENUM_REMITTION_NOTICE] = _XPY_AM_MODE_DESC_CANCEL_NOTICE;
			$sub[_XPY_ENUM_MODE_PAID][_XPY_ENUM_REMITTION_COLLECT] = _XPY_AM_MODE_DESC_PAID_COLLECT;
			$sub[_XPY_ENUM_MODE_UNPAID][_XPY_ENUM_REMITTION_COLLECT] = _XPY_AM_MODE_DESC_UNPAID_COLLECT;
			$sub[_XPY_ENUM_MODE_CANCEL][_XPY_ENUM_REMITTION_COLLECT] = _XPY_AM_MODE_DESC_CANCEL_COLLECT;
			$sub[_XPY_ENUM_MODE_PAID][_XPY_ENUM_REMITTION_FRAUD] = _XPY_AM_MODE_DESC_PAID_FRAUD;
			$sub[_XPY_ENUM_MODE_UNPAID][_XPY_ENUM_REMITTION_FRAUD] = _XPY_AM_MODE_DESC_UNPAID_FRAUD;
			$sub[_XPY_ENUM_MODE_CANCEL][_XPY_ENUM_REMITTION_FRAUD] = _XPY_AM_MODE_DESC_CANCEL_FRAUD;
			$sub[_XPY_ENUM_MODE_PAID][_XPY_ENUM_REMITTION_SETTLED] = _XPY_AM_MODE_DESC_PAID_SETTLED;
			$sub[_XPY_ENUM_MODE_UNPAID][_XPY_ENUM_REMITTION_SETTLED] = _XPY_AM_MODE_DESC_UNPAID_SETTLED;
			$sub[_XPY_ENUM_MODE_CANCEL][_XPY_ENUM_REMITTION_SETTLED] = _XPY_AM_MODE_DESC_CANCEL_SETTLED;
			$sub[_XPY_ENUM_MODE_PAID][_XPY_ENUM_REMITTION_DISCOUNTED] = _XPY_AM_MODE_DESC_PAID_DISCOUNTED;
			$sub[_XPY_ENUM_MODE_UNPAID][_XPY_ENUM_REMITTION_DISCOUNTED] = _XPY_AM_MODE_DESC_UNPAID_DISCOUNTED;
			$sub[_XPY_ENUM_MODE_CANCEL][_XPY_ENUM_REMITTION_DISCOUNTED] = _XPY_AM_MODE_DESC_CANCEL_DISCOUNTED;			
			$sub[_XPY_ENUM_MODE_PAID][_XPY_ENUM_ITEMMODE_PURCHASED] = _XPY_AM_MODE_DESC_PAID_ITEM_PURCHASED;
			$sub[_XPY_ENUM_MODE_UNPAID][_XPY_ENUM_ITEMMODE_PURCHASED] = _XPY_AM_MODE_DESC_UNPAID_ITEM_PURCHASED;
			$sub[_XPY_ENUM_MODE_CANCEL][_XPY_ENUM_ITEMMODE_PURCHASED] = _XPY_AM_MODE_DESC_CANCEL_ITEM_PURCHASED;
			$sub[_XPY_ENUM_MODE_PAID][_XPY_ENUM_ITEMMODE_REFUNDED] = _XPY_AM_MODE_DESC_PAID_ITEM_REFUNDED;
			$sub[_XPY_ENUM_MODE_UNPAID][_XPY_ENUM_ITEMMODE_REFUNDED] = _XPY_AM_MODE_DESC_UNPAID_ITEM_REFUNDED;
			$sub[_XPY_ENUM_MODE_CANCEL][_XPY_ENUM_ITEMMODE_REFUNDED] = _XPY_AM_MODE_DESC_CANCEL_ITEM_REFUNDED;
			$sub[_XPY_ENUM_MODE_PAID][_XPY_ENUM_ITEMMODE_UNDELIVERED] = _XPY_AM_MODE_DESC_PAID_ITEM_UNDELIVERED;
			$sub[_XPY_ENUM_MODE_UNPAID][_XPY_ENUM_ITEMMODE_UNDELIVERED] = _XPY_AM_MODE_DESC_UNPAID_ITEM_UNDELIVERED;
			$sub[_XPY_ENUM_MODE_CANCEL][_XPY_ENUM_ITEMMODE_UNDELIVERED] = _XPY_AM_MODE_DESC_CANCEL_ITEM_UNDELIVERED;
			$sub[_XPY_ENUM_MODE_PAID][_XPY_ENUM_ITEMMODE_DAMAGED] = _XPY_AM_MODE_DESC_PAID_ITEM_DAMAGED;
			$sub[_XPY_ENUM_MODE_UNPAID][_XPY_ENUM_ITEMMODE_DAMAGED] = _XPY_AM_MODE_DESC_UNPAID_ITEM_DAMAGED;
			$sub[_XPY_ENUM_MODE_CANCEL][_XPY_ENUM_ITEMMODE_DAMAGED] = _XPY_AM_MODE_DESC_CANCEL_ITEM_DAMAGED;
			$sub[_XPY_ENUM_MODE_PAID][_XPY_ENUM_ITEMMODE_PENDING] = _XPY_AM_MODE_DESC_PAID_ITEM_PENDING;
			$sub[_XPY_ENUM_MODE_UNPAID][_XPY_ENUM_ITEMMODE_PENDING] = _XPY_AM_MODE_DESC_UNPAID_ITEM_PENDING;
			$sub[_XPY_ENUM_MODE_CANCEL][_XPY_ENUM_ITEMMODE_PENDING] = _XPY_AM_MODE_DESC_CANCEL_ITEM_PENDING;
			$sub[_XPY_ENUM_MODE_PAID][_XPY_ENUM_ITEMMODE_EXPRESS] = _XPY_AM_MODE_DESC_PAID_ITEM_EXPRESS;
			$sub[_XPY_ENUM_MODE_UNPAID][_XPY_ENUM_ITEMMODE_EXPRESS] = _XPY_AM_MODE_DESC_UNPAID_ITEM_EXPRESS;
			$sub[_XPY_ENUM_MODE_CANCEL][_XPY_ENUM_ITEMMODE_EXPRESS] = _XPY_AM_MODE_DESC_CANCEL_ITEM_EXPRESS;
			$sub[_XPY_ENUM_MODE_PAID][_XPY_ENUM_TRANSACTION_PAYMENT] = _XPY_AM_MODE_DESC_PAID_TRANSACTION_PAYMENT;
			$sub[_XPY_ENUM_MODE_UNPAID][_XPY_ENUM_TRANSACTION_PAYMENT] = _XPY_AM_MODE_DESC_UNPAID_TRANSACTION_PAYMENT;
			$sub[_XPY_ENUM_MODE_CANCEL][_XPY_ENUM_TRANSACTION_PAYMENT] = _XPY_AM_MODE_DESC_CANCEL_TRANSACTION_PAYMENT;
			$sub[_XPY_ENUM_MODE_PAID][_XPY_ENUM_TRANSACTION_REFUND] = _XPY_AM_MODE_DESC_PAID_TRANSACTION_REFUND;
			$sub[_XPY_ENUM_MODE_UNPAID][_XPY_ENUM_TRANSACTION_REFUND] = _XPY_AM_MODE_DESC_UNPAID_TRANSACTION_REFUND;
			$sub[_XPY_ENUM_MODE_CANCEL][_XPY_ENUM_TRANSACTION_REFUND] = _XPY_AM_MODE_DESC_CANCEL_TRANSACTION_REFUND;
			$sub[_XPY_ENUM_MODE_PAID][_XPY_ENUM_TRANSACTION_PENDING] = _XPY_AM_MODE_DESC_PAID_TRANSACTION_PENDING;
			$sub[_XPY_ENUM_MODE_UNPAID][_XPY_ENUM_TRANSACTION_PENDING] = _XPY_AM_MODE_DESC_UNPAID_TRANSACTION_PENDING;
			$sub[_XPY_ENUM_MODE_CANCEL][_XPY_ENUM_TRANSACTION_PENDING] = _XPY_AM_MODE_DESC_CANCEL_TRANSACTION_PENDING;
			$sub[_XPY_ENUM_MODE_PAID][_XPY_ENUM_TRANSACTION_NOTICE] = _XPY_AM_MODE_DESC_PAID_TRANSACTION_NOTICE;
			$sub[_XPY_ENUM_MODE_UNPAID][_XPY_ENUM_TRANSACTION_NOTICE] = _XPY_AM_MODE_DESC_UNPAID_TRANSACTION_NOTICE;
			$sub[_XPY_ENUM_MODE_CANCEL][_XPY_ENUM_TRANSACTION_NOTICE] = _XPY_AM_MODE_DESC_CANCEL_TRANSACTION_NOTICE;
			$sub[_XPY_ENUM_MODE_PAID][_XPY_ENUM_TRANSACTION_OTHER] = _XPY_AM_MODE_DESC_PAID_TRANSACTION_OTHER;
			$sub[_XPY_ENUM_MODE_UNPAID][_XPY_ENUM_TRANSACTION_OTHER] = _XPY_AM_MODE_DESC_UNPAID_TRANSACTION_OTHER;
			$sub[_XPY_ENUM_MODE_CANCEL][_XPY_ENUM_TRANSACTION_OTHER] = _XPY_AM_MODE_DESC_CANCEL_TRANSACTION_OTHER;

			
			$perm_title = _XPY_AM_PERM_TITLE_EMAIL;
			$perm_name = _XPY_AM_PERM_NAME_EMAIL;
			$perm_desc = _XPY_AM_PERM_DESC_EMAIL;
			$anonymous = true;
			break;
		case "gateways":
			$gateways_handler =& xoops_getmodulehandler('gateways', 'xpayment');
			$gateways = $gateways_handler->getObjects(NULL, true);
			$base=array();
			foreach($gateways as $gid => $gateway) {
				xoops_loadLanguage($gateway->getVar('class'), 'xpayment');	
				$base[$gid] = (defined($gateway->getVar('name'))?constant($gateway->getVar('name')):$gateway->getVar('name'));
				
			} 
			$perm_title = _XPY_AM_PERM_TITLE_GATEWAY;
			$perm_name = _XPY_AM_PERM_NAME_GATEWAY;
			$perm_desc = _XPY_AM_PERM_DESC_GATEWAY;
			$anonymous = true;
			break;
		}
				
		$module_handler =& xoops_gethandler('module');
		$module = $module_handler->getByDirname('xpayment');
		$form = new XpaymentGroupPermForm($perm_title, $module->getVar('mid'), $perm_name, $perm_desc, 'admin/index.php?op=permissions&fct='.$_REQUEST['fct'], $anonymous);
		
		foreach (array_keys($base) as $c) {
			if (isset($sub[$c])&&is_array($sub[$c])) {
				$form->addItem($c, "<strong>".$base[$c]."</strong>");
				foreach(array_keys($sub[$c]) as $f){
			        $form->addItem($c+$f, "<em>".$sub[$c][$f]."</em>");
				}
			} else {
				$form->addItem($c, "".$base[$c]."");
			}
		}

		$form->display();
		
		break;
	case "groups":	
		switch ($_REQUEST['fct'])
		{
		default:
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
			
			loadModuleAdminMenu(5);
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
		break;
	case "dashboard":
	default:
		
		loadModuleAdminMenu(0);
		
	    $invoice_handler = xoops_getmodulehandler('invoice', 'xpayment');
	
	 	$indexAdmin = new ModuleAdmin();	
		
	    $parts = array(	_XPY_AM_INVOICES_ASTOTALING => array('`created`'=>array('value'=>'0', 'operator'=>'>=')),
	    				_XPY_AM_INVOICES_LAST12MONTHS => array('`created`'=>array('value'=>time()-(60*60*24*7*4*12), 'operator'=>'>=')),
	    				_XPY_AM_INVOICES_LAST6MONTHS => array('`created`'=>array('value'=>time()-(60*60*24*7*4*6), 'operator'=>'>=')),
	    				_XPY_AM_INVOICES_LAST3MONTHS => array('`created`'=>array('value'=>time()-(60*60*24*7*4*3), 'operator'=>'>=')),
	    				_XPY_AM_INVOICES_LAST1MONTHS => array('`created`'=>array('value'=>time()-(60*60*24*7*4*1), 'operator'=>'>=')));
	    foreach(array_reverse($parts) as $title => $part) {
		    foreach($invoice_handler->getCurrenciesUsed($part) as $currency) {
		    	if (	$invoice_handler->getSumByField('`grand`', '`mode`','UNPAID', array_merge(array('`currency`'=>array('value'=>$currency, 'operator'=> '=')), $part)) != '0.00' ||
		    			$invoice_handler->getSumByField('`grand`', '`mode`','PAID', array_merge(array('`currency`'=>array('value'=>$currency, 'operator'=> '=')), $part)) != '0.00' ||
		    			$invoice_handler->getSumByField('`grand`', '`mode`','CANCEL', array_merge(array('`currency`'=>array('value'=>$currency, 'operator'=> '=')), $part)) != '0.00'
		    		) {
			    	$indexAdmin->addInfoBox(sprintf(_XPY_AM_INVOICES_SUM_TOTAL, $title, $currency));
			    	if ($part['`created`']['value']!=0) {
				    	$indexAdmin->addInfoBoxLine(sprintf(_XPY_AM_INVOICES_SUM_TOTAL, $title, $currency), "<label>"._XPY_AM_INVOICES_FROM."</label>", date(_DATESTRING, time()), 'Red');
					    $indexAdmin->addInfoBoxLine(sprintf(_XPY_AM_INVOICES_SUM_TOTAL, $title, $currency), "<label>"._XPY_AM_INVOICES_TO."</label>", date(_DATESTRING, $part['`created`']['value']), 'Red');
			    	}
				    $indexAdmin->addInfoBoxLine(sprintf(_XPY_AM_INVOICES_SUM_TOTAL, $title, $currency), "<label>"._XPY_AM_INVOICES_SUMARE_UNPAID." $currency</label>", $invoice_handler->getSumByField('`grand`', '`mode`','UNPAID', array_merge(array('`currency`'=>array('value'=>$currency, 'operator'=> '=')), $part)), 'Green');
				    $indexAdmin->addInfoBoxLine(sprintf(_XPY_AM_INVOICES_SUM_TOTAL, $title, $currency), "<label>"._XPY_AM_INVOICES_SUMARE_PAID." $currency</label>", $invoice_handler->getSumByField('`grand`', '`mode`','PAID', array_merge(array('`currency`'=>array('value'=>$currency, 'operator'=> '=')), $part)), 'Green');
				    $indexAdmin->addInfoBoxLine(sprintf(_XPY_AM_INVOICES_SUM_TOTAL, $title, $currency), "<label>"._XPY_AM_INVOICES_SUMARE_CANCELLED." $currency</label>", $invoice_handler->getSumByField('`grand`', '`mode`','CANCEL', array_merge(array('`currency`'=>array('value'=>$currency, 'operator'=> '=')), $part)), 'Green');
				    $indexAdmin->addInfoBoxLine(sprintf(_XPY_AM_INVOICES_SUM_TOTAL, $title, $currency), "<label>"._XPY_AM_INVOICES_SUMARE_INTEREST." $currency</label>", $invoice_handler->getSumByField('`interest`', '1','1', array_merge(array('`currency`'=>array('value'=>$currency, 'operator'=> '=')), $part)), 'Green');
					$indexAdmin->addInfoBoxLine(sprintf(_XPY_AM_INVOICES_SUM_TOTAL, $title, $currency), "<label>"._XPY_AM_INVOICES_SUMARE_UNPAID_NONE." $currency</label>", $invoice_handler->getSumByField('`grand`', '`mode`','UNPAID', array_merge(array('`remittion`'=>array('value'=>'NONE', 'operator'=>'=')), array('`currency`'=>array('value'=>$currency, 'operator'=> '=')), $part)), 'Green');
				    $indexAdmin->addInfoBoxLine(sprintf(_XPY_AM_INVOICES_SUM_TOTAL, $title, $currency), "<label>"._XPY_AM_INVOICES_SUMARE_PAID_NONE." $currency</label>", $invoice_handler->getSumByField('`grand`', '`mode`','PAID', array_merge(array('`remittion`'=>array('value'=>'NONE', 'operator'=>'=')), array('`currency`'=>array('value'=>$currency, 'operator'=> '=')), $part)), 'Green');
				    $indexAdmin->addInfoBoxLine(sprintf(_XPY_AM_INVOICES_SUM_TOTAL, $title, $currency), "<label>"._XPY_AM_INVOICES_SUMARE_CANCELLED_NONE." $currency</label>", $invoice_handler->getSumByField('`grand`', '`mode`','CANCEL', array_merge(array('`remittion`'=>array('value'=>'NONE', 'operator'=>'=')), array('`currency`'=>array('value'=>$currency, 'operator'=> '=')), $part)), 'Green');
				    $indexAdmin->addInfoBoxLine(sprintf(_XPY_AM_INVOICES_SUM_TOTAL, $title, $currency), "<label>"._XPY_AM_INVOICES_SUMARE_UNPAID_COLLECT." $currency</label>", $invoice_handler->getSumByField('`grand`', '`mode`','UNPAID', array_merge(array('`remittion`'=>array('value'=>'COLLECT', 'operator'=>'=')), array('`currency`'=>array('value'=>$currency, 'operator'=> '=')), $part)), 'Green');
				    $indexAdmin->addInfoBoxLine(sprintf(_XPY_AM_INVOICES_SUM_TOTAL, $title, $currency), "<label>"._XPY_AM_INVOICES_SUMARE_PAID_COLLECT." $currency</label>", $invoice_handler->getSumByField('`grand`', '`mode`','PAID', array_merge(array('`remittion`'=>array('value'=>'COLLECT', 'operator'=>'=')), array('`currency`'=>array('value'=>$currency, 'operator'=> '=')), $part)), 'Green');
				    $indexAdmin->addInfoBoxLine(sprintf(_XPY_AM_INVOICES_SUM_TOTAL, $title, $currency), "<label>"._XPY_AM_INVOICES_SUMARE_CANCELLED_COLLECT." $currency</label>", $invoice_handler->getSumByField('`grand`', '`mode`','CANCEL', array_merge(array('`remittion`'=>array('value'=>'COLLECT', 'operator'=>'=')), array('`currency`'=>array('value'=>$currency, 'operator'=> '=')), $part)), 'Green');
				    $indexAdmin->addInfoBoxLine(sprintf(_XPY_AM_INVOICES_SUM_TOTAL, $title, $currency), "<label>"._XPY_AM_INVOICES_SUMARE_UNPAID_FRAUD." $currency</label>", $invoice_handler->getSumByField('`grand`', '`mode`','UNPAID', array_merge(array('`remittion`'=>array('value'=>'FRAUD', 'operator'=>'=')), array('`currency`'=>array('value'=>$currency, 'operator'=> '=')), $part)), 'Green');
				    $indexAdmin->addInfoBoxLine(sprintf(_XPY_AM_INVOICES_SUM_TOTAL, $title, $currency), "<label>"._XPY_AM_INVOICES_SUMARE_PAID_FRAUD." $currency</label>", $invoice_handler->getSumByField('`grand`', '`mode`','PAID', array_merge(array('`remittion`'=>array('value'=>'FRAUD', 'operator'=>'=')), array('`currency`'=>array('value'=>$currency, 'operator'=> '=')), $part)), 'Green');
				    $indexAdmin->addInfoBoxLine(sprintf(_XPY_AM_INVOICES_SUM_TOTAL, $title, $currency), "<label>"._XPY_AM_INVOICES_SUMARE_CANCELLED_FRAUD." $currency</label>", $invoice_handler->getSumByField('`grand`', '`mode`','CANCEL', array_merge(array('`remittion`'=>array('value'=>'FRAUD', 'operator'=>'=')), array('`currency`'=>array('value'=>$currency, 'operator'=> '=')), $part)), 'Green');
				    $indexAdmin->addInfoBoxLine(sprintf(_XPY_AM_INVOICES_SUM_TOTAL, $title, $currency), "<label>"._XPY_AM_INVOICES_SUMARE_UNPAID_SETTLED." $currency</label>", $invoice_handler->getSumByField('`grand`', '`mode`','UNPAID', array_merge(array('`remittion`'=>array('value'=>'SETTLED', 'operator'=>'=')), array('`currency`'=>array('value'=>$currency, 'operator'=> '=')), $part)), 'Green');
				    $indexAdmin->addInfoBoxLine(sprintf(_XPY_AM_INVOICES_SUM_TOTAL, $title, $currency), "<label>"._XPY_AM_INVOICES_SUMARE_PAID_SETTLED." $currency</label>", $invoice_handler->getSumByField('`grand`', '`mode`','PAID', array_merge(array('`remittion`'=>array('value'=>'SETTLED', 'operator'=>'=')), array('`currency`'=>array('value'=>$currency, 'operator'=> '=')), $part)), 'Green');
				    $indexAdmin->addInfoBoxLine(sprintf(_XPY_AM_INVOICES_SUM_TOTAL, $title, $currency), "<label>"._XPY_AM_INVOICES_SUMARE_CANCELLED_SETTLED." $currency</label>", $invoice_handler->getSumByField('`grand`', '`mode`','CANCEL', array_merge(array('`remittion`'=>array('value'=>'SETTLED', 'operator'=>'=')), array('`currency`'=>array('value'=>$currency, 'operator'=> '=')), $part)), 'Green');
				    $indexAdmin->addInfoBoxLine(sprintf(_XPY_AM_INVOICES_SUM_TOTAL, $title, $currency), "<label>"._XPY_AM_INVOICES_SUMARE_UNPAID_DISCOUNTED." $currency</label>", $invoice_handler->getSumByField('`grand`', '`mode`','UNPAID', array_merge(array('`remittion`'=>array('value'=>'DISCOUNTED', 'operator'=>'=')), array('`currency`'=>array('value'=>$currency, 'operator'=> '=')), $part)), 'Green');
				    $indexAdmin->addInfoBoxLine(sprintf(_XPY_AM_INVOICES_SUM_TOTAL, $title, $currency), "<label>"._XPY_AM_INVOICES_SUMARE_PAID_DISCOUNTED." $currency</label>", $invoice_handler->getSumByField('`grand`', '`mode`','PAID', array_merge(array('`remittion`'=>array('value'=>'DISCOUNTED', 'operator'=>'=')), array('`currency`'=>array('value'=>$currency, 'operator'=> '=')), $part)), 'Green');
				    $indexAdmin->addInfoBoxLine(sprintf(_XPY_AM_INVOICES_SUM_TOTAL, $title, $currency), "<label>"._XPY_AM_INVOICES_SUMARE_CANCELLED_DISCOUNTED." $currency</label>", $invoice_handler->getSumByField('`grand`', '`mode`','CANCEL', array_merge(array('`remittion`'=>array('value'=>'DISCOUNTED', 'operator'=>'=')), array('`currency`'=>array('value'=>$currency, 'operator'=> '=')), $part)), 'Green');
				    $indexAdmin->addInfoBoxLine(sprintf(_XPY_AM_INVOICES_SUM_TOTAL, $title, $currency), "<label>"._XPY_AM_INVOICES_SUMARE_UNPAID_DISCOUNTED_AMOUNT." $currency</label>", $invoice_handler->getSumByField('`discount_amount`', '`mode`','UNPAID', array_merge(array('`remittion`'=>array('value'=>'DISCOUNTED', 'operator'=>'=')), array('`currency`'=>array('value'=>$currency, 'operator'=> '=')), $part)), 'Green');
				    $indexAdmin->addInfoBoxLine(sprintf(_XPY_AM_INVOICES_SUM_TOTAL, $title, $currency), "<label>"._XPY_AM_INVOICES_SUMARE_PAID_DISCOUNTED_AMOUNT." $currency</label>", $invoice_handler->getSumByField('`discount_amount`', '`mode`','PAID', array_merge(array('`remittion`'=>array('value'=>'DISCOUNTED', 'operator'=>'=')), array('`currency`'=>array('value'=>$currency, 'operator'=> '=')), $part)), 'Green');
				    $indexAdmin->addInfoBoxLine(sprintf(_XPY_AM_INVOICES_SUM_TOTAL, $title, $currency), "<label>"._XPY_AM_INVOICES_SUMARE_CANCELLED_DISCOUNTED_AMOUNT." $currency</label>", $invoice_handler->getSumByField('`discount_amount`', '`mode`','CANCEL', array_merge(array('`remittion`'=>array('value'=>'DISCOUNTED', 'operator'=>'=')), array('`currency`'=>array('value'=>$currency, 'operator'=> '=')), $part)), 'Green');
					$indexAdmin->addInfoBoxLine(sprintf(_XPY_AM_INVOICES_SUM_TOTAL, $title, $currency), "<label>"._XPY_AM_INVOICES_SUMARE_UNPAID_DONATED."</label>", $invoice_handler->getSumByField('`grand`', '`mode`','UNPAID', array_merge($part, array('`currency`'=>array('value'=>$currency, 'operator'=> '=')), array('`donation`'=>array('value'=>true, 'operator'=>'=')))), 'Green');
				    $indexAdmin->addInfoBoxLine(sprintf(_XPY_AM_INVOICES_SUM_TOTAL, $title, $currency), "<label>"._XPY_AM_INVOICES_SUMARE_PAID_DONATED."</label>", $invoice_handler->getSumByField('`grand`', '`mode`','PAID', array_merge($part, array('`currency`'=>array('value'=>$currency, 'operator'=> '=')), array('`donation`'=>array('value'=>true, 'operator'=>'=')))), 'Green');
				    $indexAdmin->addInfoBoxLine(sprintf(_XPY_AM_INVOICES_SUM_TOTAL, $title, $currency), "<label>"._XPY_AM_INVOICES_SUMARE_CANCELLED_DONATED."</label>", $invoice_handler->getSumByField('`grand`', '`mode`','CANCEL', array_merge($part, array('`currency`'=>array('value'=>$currency, 'operator'=> '=')), array('`donation`'=>array('value'=>true, 'operator'=>'=')))), 'Green');
		    	}
		    	
		    	if (	$invoice_handler->getSumByField('`tax`', '`mode`','UNPAID', array_merge(array('`currency`'=>array('value'=>$currency, 'operator'=> '=')), $part)) != '0.00' ||
		    			$invoice_handler->getSumByField('`tax`', '`mode`','PAID', array_merge(array('`currency`'=>array('value'=>$currency, 'operator'=> '=')), $part)) != '0.00' ||
		    			$invoice_handler->getSumByField('`tax`', '`mode`','CANCEL', array_merge(array('`currency`'=>array('value'=>$currency, 'operator'=> '=')), $part)) != '0.00'
		    		) {
			    
				    $indexAdmin->addInfoBox(sprintf(_XPY_AM_INVOICES_TAX_TOTAL, $title, $currency));
			    	if ($part['`created`']['value']!=0) {
				    	$indexAdmin->addInfoBoxLine(sprintf(_XPY_AM_INVOICES_TAX_TOTAL, $title, $currency), "<label>"._XPY_AM_INVOICES_FROM."</label>", date(_DATESTRING, time()), 'Red');
					    $indexAdmin->addInfoBoxLine(sprintf(_XPY_AM_INVOICES_TAX_TOTAL, $title, $currency), "<label>"._XPY_AM_INVOICES_TO."</label>", date(_DATESTRING, $part['`created`']['value']), 'Red');
			    	}
				    $indexAdmin->addInfoBoxLine(sprintf(_XPY_AM_INVOICES_TAX_TOTAL, $title, $currency), "<label>"._XPY_AM_INVOICES_TAXARE_UNPAID." $currency</label>", $invoice_handler->getSumByField('`tax`', '`mode`','UNPAID', array_merge(array('`currency`'=>array('value'=>$currency, 'operator'=> '=')), $part)), 'Green');
				    $indexAdmin->addInfoBoxLine(sprintf(_XPY_AM_INVOICES_TAX_TOTAL, $title, $currency), "<label>"._XPY_AM_INVOICES_TAXARE_PAID." $currency</label>", $invoice_handler->getSumByField('`tax`', '`mode`','PAID', array_merge(array('`currency`'=>array('value'=>$currency, 'operator'=> '=')), $part)), 'Green');
				    $indexAdmin->addInfoBoxLine(sprintf(_XPY_AM_INVOICES_TAX_TOTAL, $title, $currency), "<label>"._XPY_AM_INVOICES_TAXARE_CANCELLED." $currency</label>", $invoice_handler->getSumByField('`tax`', '`mode`','CANCEL', array_merge(array('`currency`'=>array('value'=>$currency, 'operator'=> '=')), $part)), 'Green');
					$indexAdmin->addInfoBoxLine(sprintf(_XPY_AM_INVOICES_TAX_TOTAL, $title, $currency), "<label>"._XPY_AM_INVOICES_TAXARE_UNPAID_NONE." $currency</label>", $invoice_handler->getSumByField('`tax`', '`mode`','UNPAID', array_merge(array('`remittion`'=>array('value'=>'NONE', 'operator'=>'=')), array('`currency`'=>array('value'=>$currency, 'operator'=> '=')), $part)), 'Green');
				    $indexAdmin->addInfoBoxLine(sprintf(_XPY_AM_INVOICES_TAX_TOTAL, $title, $currency), "<label>"._XPY_AM_INVOICES_TAXARE_PAID_NONE." $currency</label>", $invoice_handler->getSumByField('`tax`', '`mode`','PAID', array_merge(array('`remittion`'=>array('value'=>'NONE', 'operator'=>'=')), array('`currency`'=>array('value'=>$currency, 'operator'=> '=')), $part)), 'Green');
				    $indexAdmin->addInfoBoxLine(sprintf(_XPY_AM_INVOICES_TAX_TOTAL, $title, $currency), "<label>"._XPY_AM_INVOICES_TAXARE_CANCELLED_NONE." $currency</label>", $invoice_handler->getSumByField('`tax`', '`mode`','CANCEL', array_merge(array('`remittion`'=>array('value'=>'NONE', 'operator'=>'=')), array('`currency`'=>array('value'=>$currency, 'operator'=> '=')), $part)), 'Green');
				    $indexAdmin->addInfoBoxLine(sprintf(_XPY_AM_INVOICES_TAX_TOTAL, $title, $currency), "<label>"._XPY_AM_INVOICES_TAXARE_UNPAID_COLLECT." $currency</label>", $invoice_handler->getSumByField('`tax`', '`mode`','UNPAID', array_merge(array('`remittion`'=>array('value'=>'COLLECT', 'operator'=>'=')), array('`currency`'=>array('value'=>$currency, 'operator'=> '=')), $part)), 'Green');
				    $indexAdmin->addInfoBoxLine(sprintf(_XPY_AM_INVOICES_TAX_TOTAL, $title, $currency), "<label>"._XPY_AM_INVOICES_TAXARE_PAID_COLLECT." $currency</label>", $invoice_handler->getSumByField('`tax`', '`mode`','PAID', array_merge(array('`remittion`'=>array('value'=>'COLLECT', 'operator'=>'=')), array('`currency`'=>array('value'=>$currency, 'operator'=> '=')), $part)), 'Green');
				    $indexAdmin->addInfoBoxLine(sprintf(_XPY_AM_INVOICES_TAX_TOTAL, $title, $currency), "<label>"._XPY_AM_INVOICES_TAXARE_CANCELLED_COLLECT." $currency</label>", $invoice_handler->getSumByField('`tax`', '`mode`','CANCEL', array_merge(array('`remittion`'=>array('value'=>'COLLECT', 'operator'=>'=')), array('`currency`'=>array('value'=>$currency, 'operator'=> '=')), $part)), 'Green');
				    $indexAdmin->addInfoBoxLine(sprintf(_XPY_AM_INVOICES_TAX_TOTAL, $title, $currency), "<label>"._XPY_AM_INVOICES_TAXARE_UNPAID_FRAUD." $currency</label>", $invoice_handler->getSumByField('`tax`', '`mode`','UNPAID', array_merge(array('`remittion`'=>array('value'=>'FRAUD', 'operator'=>'=')), array('`currency`'=>array('value'=>$currency, 'operator'=> '=')), $part)), 'Green');
				    $indexAdmin->addInfoBoxLine(sprintf(_XPY_AM_INVOICES_TAX_TOTAL, $title, $currency), "<label>"._XPY_AM_INVOICES_TAXARE_PAID_FRAUD." $currency</label>", $invoice_handler->getSumByField('`tax`', '`mode`','PAID', array_merge(array('`remittion`'=>array('value'=>'FRAUD', 'operator'=>'=')), array('`currency`'=>array('value'=>$currency, 'operator'=> '=')), $part)), 'Green');
				    $indexAdmin->addInfoBoxLine(sprintf(_XPY_AM_INVOICES_TAX_TOTAL, $title, $currency), "<label>"._XPY_AM_INVOICES_TAXARE_CANCELLED_FRAUD." $currency</label>", $invoice_handler->getSumByField('`tax`', '`mode`','CANCEL', array_merge(array('`remittion`'=>array('value'=>'FRAUD', 'operator'=>'=')), array('`currency`'=>array('value'=>$currency, 'operator'=> '=')), $part)), 'Green');
				    $indexAdmin->addInfoBoxLine(sprintf(_XPY_AM_INVOICES_TAX_TOTAL, $title, $currency), "<label>"._XPY_AM_INVOICES_TAXARE_UNPAID_SETTLED." $currency</label>", $invoice_handler->getSumByField('`tax`', '`mode`','UNPAID', array_merge(array('`remittion`'=>array('value'=>'SETTLED', 'operator'=>'=')), array('`currency`'=>array('value'=>$currency, 'operator'=> '=')), $part)), 'Green');
				    $indexAdmin->addInfoBoxLine(sprintf(_XPY_AM_INVOICES_TAX_TOTAL, $title, $currency), "<label>"._XPY_AM_INVOICES_TAXARE_PAID_SETTLED." $currency</label>", $invoice_handler->getSumByField('`tax`', '`mode`','PAID', array_merge(array('`remittion`'=>array('value'=>'SETTLED', 'operator'=>'=')), array('`currency`'=>array('value'=>$currency, 'operator'=> '=')), $part)), 'Green');
				    $indexAdmin->addInfoBoxLine(sprintf(_XPY_AM_INVOICES_TAX_TOTAL, $title, $currency), "<label>"._XPY_AM_INVOICES_TAXARE_CANCELLED_SETTLED." $currency</label>", $invoice_handler->getSumByField('`tax`', '`mode`','CANCEL', array_merge(array('`remittion`'=>array('value'=>'SETTLED', 'operator'=>'=')), array('`currency`'=>array('value'=>$currency, 'operator'=> '=')), $part)), 'Green');
				    $indexAdmin->addInfoBoxLine(sprintf(_XPY_AM_INVOICES_TAX_TOTAL, $title, $currency), "<label>"._XPY_AM_INVOICES_TAXARE_UNPAID_DISCOUNTED." $currency</label>", $invoice_handler->getSumByField('`tax`', '`mode`','UNPAID', array_merge(array('`remittion`'=>array('value'=>'DISCOUNTED', 'operator'=>'=')), array('`currency`'=>array('value'=>$currency, 'operator'=> '=')), $part)), 'Green');
				    $indexAdmin->addInfoBoxLine(sprintf(_XPY_AM_INVOICES_TAX_TOTAL, $title, $currency), "<label>"._XPY_AM_INVOICES_TAXARE_PAID_DISCOUNTED." $currency</label>", $invoice_handler->getSumByField('`tax`', '`mode`','PAID', array_merge(array('`remittion`'=>array('value'=>'DISCOUNTED', 'operator'=>'=')), array('`currency`'=>array('value'=>$currency, 'operator'=> '=')), $part)), 'Green');
				    $indexAdmin->addInfoBoxLine(sprintf(_XPY_AM_INVOICES_TAX_TOTAL, $title, $currency), "<label>"._XPY_AM_INVOICES_TAXARE_CANCELLED_DISCOUNTED." $currency</label>", $invoice_handler->getSumByField('`tax`', '`mode`','CANCEL', array_merge(array('`remittion`'=>array('value'=>'DISCOUNTED', 'operator'=>'=')), array('`currency`'=>array('value'=>$currency, 'operator'=> '=')), $part)), 'Green');
				    $indexAdmin->addInfoBoxLine(sprintf(_XPY_AM_INVOICES_TAX_TOTAL, $title, $currency), "<label>"._XPY_AM_INVOICES_TAXARE_UNPAID_DONATED."</label>", $invoice_handler->getSumByField('`tax`', '`mode`','UNPAID', array_merge($part, array('`currency`'=>array('value'=>$currency, 'operator'=> '=')), array('`donation`'=>array('value'=>true, 'operator'=>'=')))), 'Green');
				    $indexAdmin->addInfoBoxLine(sprintf(_XPY_AM_INVOICES_TAX_TOTAL, $title, $currency), "<label>"._XPY_AM_INVOICES_TAXARE_PAID_DONATED."</label>", $invoice_handler->getSumByField('`tax`', '`mode`','PAID', array_merge($part, array('`currency`'=>array('value'=>$currency, 'operator'=> '=')), array('`donation`'=>array('value'=>true, 'operator'=>'=')))), 'Green');
				    $indexAdmin->addInfoBoxLine(sprintf(_XPY_AM_INVOICES_TAX_TOTAL, $title, $currency), "<label>"._XPY_AM_INVOICES_TAXARE_CANCELLED_DONATED."</label>", $invoice_handler->getSumByField('`tax`', '`mode`','CANCEL', array_merge($part, array('`currency`'=>array('value'=>$currency, 'operator'=> '=')), array('`donation`'=>array('value'=>true, 'operator'=>'=')))), 'Green');
		    	}

				if (	$invoice_handler->getAverageByField('`grand`', '`mode`','UNPAID', array_merge(array('`currency`'=>array('value'=>$currency, 'operator'=> '=')), $part)) != '0.00' ||
		    			$invoice_handler->getAverageByField('`grand`', '`mode`','PAID', array_merge(array('`currency`'=>array('value'=>$currency, 'operator'=> '=')), $part)) != '0.00' ||
		    			$invoice_handler->getAverageByField('`grand`', '`mode`','CANCEL', array_merge(array('`currency`'=>array('value'=>$currency, 'operator'=> '=')), $part)) != '0.00'
		    		) {
			    		    	
			    	$indexAdmin->addInfoBox(sprintf(_XPY_AM_INVOICES_AVG_TOTAL, $title, $currency));
			    	if ($part['`created`']['value']!=0) {
				    	$indexAdmin->addInfoBoxLine(sprintf(_XPY_AM_INVOICES_AVG_TOTAL, $title, $currency), "<label>"._XPY_AM_INVOICES_FROM."</label>", date(_DATESTRING, time()), 'Red');
					    $indexAdmin->addInfoBoxLine(sprintf(_XPY_AM_INVOICES_AVG_TOTAL, $title, $currency), "<label>"._XPY_AM_INVOICES_TO."</label>", date(_DATESTRING, $part['`created`']['value']), 'Red');
			    	}
				    $indexAdmin->addInfoBoxLine(sprintf(_XPY_AM_INVOICES_AVG_TOTAL, $title, $currency), "<label>"._XPY_AM_INVOICES_AVGARE_UNPAID." $currency</label>", $invoice_handler->getAverageByField('`grand`', '`mode`','UNPAID', array_merge(array('`currency`'=>array('value'=>$currency, 'operator'=> '=')), $part)), 'Green');
				    $indexAdmin->addInfoBoxLine(sprintf(_XPY_AM_INVOICES_AVG_TOTAL, $title, $currency), "<label>"._XPY_AM_INVOICES_AVGARE_PAID." $currency</label>", $invoice_handler->getAverageByField('`grand`', '`mode`','PAID', array_merge(array('`currency`'=>array('value'=>$currency, 'operator'=> '=')), $part)), 'Green');
				    $indexAdmin->addInfoBoxLine(sprintf(_XPY_AM_INVOICES_AVG_TOTAL, $title, $currency), "<label>"._XPY_AM_INVOICES_AVGARE_CANCELLED." $currency</label>", $invoice_handler->getAverageByField('`grand`', '`mode`','CANCEL', array_merge(array('`currency`'=>array('value'=>$currency, 'operator'=> '=')), $part)), 'Green');
					$indexAdmin->addInfoBoxLine(sprintf(_XPY_AM_INVOICES_AVG_TOTAL, $title, $currency), "<label>"._XPY_AM_INVOICES_AVGARE_UNPAID_NONE." $currency</label>", $invoice_handler->getAverageByField('`grand`', '`mode`','UNPAID', array_merge(array('`remittion`'=>array('value'=>'NONE', 'operator'=>'=')), array('`currency`'=>array('value'=>$currency, 'operator'=> '=')), $part)), 'Green');
				    $indexAdmin->addInfoBoxLine(sprintf(_XPY_AM_INVOICES_AVG_TOTAL, $title, $currency), "<label>"._XPY_AM_INVOICES_AVGARE_PAID_NONE." $currency</label>", $invoice_handler->getAverageByField('`grand`', '`mode`','PAID', array_merge(array('`remittion`'=>array('value'=>'NONE', 'operator'=>'=')), array('`currency`'=>array('value'=>$currency, 'operator'=> '=')), $part)), 'Green');
				    $indexAdmin->addInfoBoxLine(sprintf(_XPY_AM_INVOICES_AVG_TOTAL, $title, $currency), "<label>"._XPY_AM_INVOICES_AVGARE_CANCELLED_NONE." $currency</label>", $invoice_handler->getAverageByField('`grand`', '`mode`','CANCEL', array_merge(array('`remittion`'=>array('value'=>'NONE', 'operator'=>'=')), array('`currency`'=>array('value'=>$currency, 'operator'=> '=')), $part)), 'Green');
				    $indexAdmin->addInfoBoxLine(sprintf(_XPY_AM_INVOICES_AVG_TOTAL, $title, $currency), "<label>"._XPY_AM_INVOICES_AVGARE_UNPAID_COLLECT." $currency</label>", $invoice_handler->getAverageByField('`grand`', '`mode`','UNPAID', array_merge(array('`remittion`'=>array('value'=>'COLLECT', 'operator'=>'=')), array('`currency`'=>array('value'=>$currency, 'operator'=> '=')), $part)), 'Green');
				    $indexAdmin->addInfoBoxLine(sprintf(_XPY_AM_INVOICES_AVG_TOTAL, $title, $currency), "<label>"._XPY_AM_INVOICES_AVGARE_PAID_COLLECT." $currency</label>", $invoice_handler->getAverageByField('`grand`', '`mode`','PAID', array_merge(array('`remittion`'=>array('value'=>'COLLECT', 'operator'=>'=')), array('`currency`'=>array('value'=>$currency, 'operator'=> '=')), $part)), 'Green');
				    $indexAdmin->addInfoBoxLine(sprintf(_XPY_AM_INVOICES_AVG_TOTAL, $title, $currency), "<label>"._XPY_AM_INVOICES_AVGARE_CANCELLED_COLLECT." $currency</label>", $invoice_handler->getAverageByField('`grand`', '`mode`','CANCEL', array_merge(array('`remittion`'=>array('value'=>'COLLECT', 'operator'=>'=')), array('`currency`'=>array('value'=>$currency, 'operator'=> '=')), $part)), 'Green');
				    $indexAdmin->addInfoBoxLine(sprintf(_XPY_AM_INVOICES_AVG_TOTAL, $title, $currency), "<label>"._XPY_AM_INVOICES_AVGARE_UNPAID_FRAUD." $currency</label>", $invoice_handler->getAverageByField('`grand`', '`mode`','UNPAID', array_merge(array('`remittion`'=>array('value'=>'FRAUD', 'operator'=>'=')), array('`currency`'=>array('value'=>$currency, 'operator'=> '=')), $part)), 'Green');
				    $indexAdmin->addInfoBoxLine(sprintf(_XPY_AM_INVOICES_AVG_TOTAL, $title, $currency), "<label>"._XPY_AM_INVOICES_AVGARE_PAID_FRAUD." $currency</label>", $invoice_handler->getAverageByField('`grand`', '`mode`','PAID', array_merge(array('`remittion`'=>array('value'=>'FRAUD', 'operator'=>'=')), array('`currency`'=>array('value'=>$currency, 'operator'=> '=')), $part)), 'Green');
				    $indexAdmin->addInfoBoxLine(sprintf(_XPY_AM_INVOICES_AVG_TOTAL, $title, $currency), "<label>"._XPY_AM_INVOICES_AVGARE_CANCELLED_FRAUD." $currency</label>", $invoice_handler->getAverageByField('`grand`', '`mode`','CANCEL', array_merge(array('`remittion`'=>array('value'=>'FRAUD', 'operator'=>'=')), array('`currency`'=>array('value'=>$currency, 'operator'=> '=')), $part)), 'Green');
				    $indexAdmin->addInfoBoxLine(sprintf(_XPY_AM_INVOICES_AVG_TOTAL, $title, $currency), "<label>"._XPY_AM_INVOICES_AVGARE_UNPAID_SETTLED." $currency</label>", $invoice_handler->getAverageByField('`grand`', '`mode`','UNPAID', array_merge(array('`remittion`'=>array('value'=>'SETTLED', 'operator'=>'=')), array('`currency`'=>array('value'=>$currency, 'operator'=> '=')), $part)), 'Green');
				    $indexAdmin->addInfoBoxLine(sprintf(_XPY_AM_INVOICES_AVG_TOTAL, $title, $currency), "<label>"._XPY_AM_INVOICES_AVGARE_PAID_SETTLED." $currency</label>", $invoice_handler->getAverageByField('`grand`', '`mode`','PAID', array_merge(array('`remittion`'=>array('value'=>'SETTLED', 'operator'=>'=')), array('`currency`'=>array('value'=>$currency, 'operator'=> '=')), $part)), 'Green');
				    $indexAdmin->addInfoBoxLine(sprintf(_XPY_AM_INVOICES_AVG_TOTAL, $title, $currency), "<label>"._XPY_AM_INVOICES_AVGARE_CANCELLED_SETTLED." $currency</label>", $invoice_handler->getAverageByField('`grand`', '`mode`','CANCEL', array_merge(array('`remittion`'=>array('value'=>'SETTLED', 'operator'=>'=')), array('`currency`'=>array('value'=>$currency, 'operator'=> '=')), $part)), 'Green');
				    $indexAdmin->addInfoBoxLine(sprintf(_XPY_AM_INVOICES_AVG_TOTAL, $title, $currency), "<label>"._XPY_AM_INVOICES_AVGARE_UNPAID_DISCOUNTED." $currency</label>", $invoice_handler->getAverageByField('`grand`', '`mode`','UNPAID', array_merge(array('`remittion`'=>array('value'=>'DISCOUNTED', 'operator'=>'=')), array('`currency`'=>array('value'=>$currency, 'operator'=> '=')), $part)), 'Green');
				    $indexAdmin->addInfoBoxLine(sprintf(_XPY_AM_INVOICES_AVG_TOTAL, $title, $currency), "<label>"._XPY_AM_INVOICES_AVGARE_PAID_DISCOUNTED." $currency</label>", $invoice_handler->getAverageByField('`grand`', '`mode`','PAID', array_merge(array('`remittion`'=>array('value'=>'DISCOUNTED', 'operator'=>'=')), array('`currency`'=>array('value'=>$currency, 'operator'=> '=')), $part)), 'Green');
				    $indexAdmin->addInfoBoxLine(sprintf(_XPY_AM_INVOICES_AVG_TOTAL, $title, $currency), "<label>"._XPY_AM_INVOICES_AVGARE_CANCELLED_DISCOUNTED." $currency</label>", $invoice_handler->getAverageByField('`grand`', '`mode`','CANCEL', array_merge(array('`remittion`'=>array('value'=>'DISCOUNTED', 'operator'=>'=')), array('`currency`'=>array('value'=>$currency, 'operator'=> '=')), $part)), 'Green');
				    $indexAdmin->addInfoBoxLine(sprintf(_XPY_AM_INVOICES_AVG_TOTAL, $title, $currency), "<label>"._XPY_AM_INVOICES_AVGARE_UNPAID_DISCOUNTED_AMOUNT." $currency</label>", $invoice_handler->getAverageByField('`discount_amount`', '`mode`','UNPAID', array_merge(array('`remittion`'=>array('value'=>'DISCOUNTED', 'operator'=>'=')), array('`currency`'=>array('value'=>$currency, 'operator'=> '=')), $part)), 'Green');
				    $indexAdmin->addInfoBoxLine(sprintf(_XPY_AM_INVOICES_AVG_TOTAL, $title, $currency), "<label>"._XPY_AM_INVOICES_AVGARE_PAID_DISCOUNTED_AMOUNT." $currency</label>", $invoice_handler->getAverageByField('`discount_amount`', '`mode`','PAID', array_merge(array('`remittion`'=>array('value'=>'DISCOUNTED', 'operator'=>'=')), array('`currency`'=>array('value'=>$currency, 'operator'=> '=')), $part)), 'Green');
				    $indexAdmin->addInfoBoxLine(sprintf(_XPY_AM_INVOICES_AVG_TOTAL, $title, $currency), "<label>"._XPY_AM_INVOICES_AVGARE_CANCELLED_DISCOUNTED_AMOUNT." $currency</label>", $invoice_handler->getAverageByField('`discount_amount`', '`mode`','CANCEL', array_merge(array('`remittion`'=>array('value'=>'DISCOUNTED', 'operator'=>'=')), array('`currency`'=>array('value'=>$currency, 'operator'=> '=')), $part)), 'Green');
					$indexAdmin->addInfoBoxLine(sprintf(_XPY_AM_INVOICES_AVG_TOTAL, $title, $currency), "<label>"._XPY_AM_INVOICES_AVGARE_UNPAID_DONATED."</label>", $invoice_handler->getAverageByField('`grand`', '`mode`','UNPAID', array_merge($part, array('`currency`'=>array('value'=>$currency, 'operator'=> '=')), array('`donation`'=>array('value'=>true, 'operator'=>'=')))), 'Green');
				    $indexAdmin->addInfoBoxLine(sprintf(_XPY_AM_INVOICES_AVG_TOTAL, $title, $currency), "<label>"._XPY_AM_INVOICES_AVGARE_PAID_DONATED."</label>", $invoice_handler->getAverageByField('`grand`', '`mode`','PAID', array_merge($part, array('`currency`'=>array('value'=>$currency, 'operator'=> '=')), array('`donation`'=>array('value'=>true, 'operator'=>'=')))), 'Green');
				    $indexAdmin->addInfoBoxLine(sprintf(_XPY_AM_INVOICES_AVG_TOTAL, $title, $currency), "<label>"._XPY_AM_INVOICES_AVGARE_CANCELLED_DONATED."</label>", $invoice_handler->getAverageByField('`grand`', '`mode`','CANCEL', array_merge($part, array('`currency`'=>array('value'=>$currency, 'operator'=> '=')), array('`donation`'=>array('value'=>true, 'operator'=>'=')))), 'Green');
							    
		    	}
		    	if (	$invoice_handler->getMaximumByField('`grand`', '`mode`','UNPAID', array_merge(array('`currency`'=>array('value'=>$currency, 'operator'=> '=')), $part)) != '0.00' ||
		    			$invoice_handler->getMaximumByField('`grand`', '`mode`','PAID', array_merge(array('`currency`'=>array('value'=>$currency, 'operator'=> '=')), $part)) != '0.00' ||
		    			$invoice_handler->getMaximumByField('`grand`', '`mode`','CANCEL', array_merge(array('`currency`'=>array('value'=>$currency, 'operator'=> '=')), $part)) != '0.00'
		    		) {
		    	
				    $indexAdmin->addInfoBox(sprintf(_XPY_AM_INVOICES_MAX_TOTAL, $title, $currency));
			    	if ($part['`created`']['value']!=0) {
				    	$indexAdmin->addInfoBoxLine(sprintf(_XPY_AM_INVOICES_MAX_TOTAL, $title, $currency), "<label>"._XPY_AM_INVOICES_FROM."</label>", date(_DATESTRING, time()), 'Red');
					    $indexAdmin->addInfoBoxLine(sprintf(_XPY_AM_INVOICES_MAX_TOTAL, $title, $currency), "<label>"._XPY_AM_INVOICES_TO."</label>", date(_DATESTRING, $part['`created`']['value']), 'Red');
			    	}
				    $indexAdmin->addInfoBoxLine(sprintf(_XPY_AM_INVOICES_MAX_TOTAL, $title, $currency), "<label>"._XPY_AM_INVOICES_MAXARE_UNPAID." $currency</label>", $invoice_handler->getMaximumByField('`grand`', '`mode`','UNPAID', array_merge(array('`currency`'=>array('value'=>$currency, 'operator'=> '=')), $part)), 'Green');
				    $indexAdmin->addInfoBoxLine(sprintf(_XPY_AM_INVOICES_MAX_TOTAL, $title, $currency), "<label>"._XPY_AM_INVOICES_MAXARE_PAID." $currency</label>", $invoice_handler->getMaximumByField('`grand`', '`mode`','PAID', array_merge(array('`currency`'=>array('value'=>$currency, 'operator'=> '=')), $part)), 'Green');
				    $indexAdmin->addInfoBoxLine(sprintf(_XPY_AM_INVOICES_MAX_TOTAL, $title, $currency), "<label>"._XPY_AM_INVOICES_MAXARE_CANCELLED." $currency</label>", $invoice_handler->getMaximumByField('`grand`', '`mode`','CANCEL', array_merge(array('`currency`'=>array('value'=>$currency, 'operator'=> '=')), $part)), 'Green');
					$indexAdmin->addInfoBoxLine(sprintf(_XPY_AM_INVOICES_MAX_TOTAL, $title, $currency), "<label>"._XPY_AM_INVOICES_MAXARE_UNPAID_NONE." $currency</label>", $invoice_handler->getMaximumByField('`grand`', '`mode`','UNPAID', array_merge(array('`remittion`'=>array('value'=>'NONE', 'operator'=>'=')), array('`currency`'=>array('value'=>$currency, 'operator'=> '=')), $part)), 'Green');
				    $indexAdmin->addInfoBoxLine(sprintf(_XPY_AM_INVOICES_MAX_TOTAL, $title, $currency), "<label>"._XPY_AM_INVOICES_MAXARE_PAID_NONE." $currency</label>", $invoice_handler->getMaximumByField('`grand`', '`mode`','PAID', array_merge(array('`remittion`'=>array('value'=>'NONE', 'operator'=>'=')), array('`currency`'=>array('value'=>$currency, 'operator'=> '=')), $part)), 'Green');
				    $indexAdmin->addInfoBoxLine(sprintf(_XPY_AM_INVOICES_MAX_TOTAL, $title, $currency), "<label>"._XPY_AM_INVOICES_MAXARE_CANCELLED_NONE." $currency</label>", $invoice_handler->getMaximumByField('`grand`', '`mode`','CANCEL', array_merge(array('`remittion`'=>array('value'=>'NONE', 'operator'=>'=')), array('`currency`'=>array('value'=>$currency, 'operator'=> '=')), $part)), 'Green');
				    $indexAdmin->addInfoBoxLine(sprintf(_XPY_AM_INVOICES_MAX_TOTAL, $title, $currency), "<label>"._XPY_AM_INVOICES_MAXARE_UNPAID_COLLECT." $currency</label>", $invoice_handler->getMaximumByField('`grand`', '`mode`','UNPAID', array_merge(array('`remittion`'=>array('value'=>'COLLECT', 'operator'=>'=')), array('`currency`'=>array('value'=>$currency, 'operator'=> '=')), $part)), 'Green');
				    $indexAdmin->addInfoBoxLine(sprintf(_XPY_AM_INVOICES_MAX_TOTAL, $title, $currency), "<label>"._XPY_AM_INVOICES_MAXARE_PAID_COLLECT." $currency</label>", $invoice_handler->getMaximumByField('`grand`', '`mode`','PAID', array_merge(array('`remittion`'=>array('value'=>'COLLECT', 'operator'=>'=')), array('`currency`'=>array('value'=>$currency, 'operator'=> '=')), $part)), 'Green');
				    $indexAdmin->addInfoBoxLine(sprintf(_XPY_AM_INVOICES_MAX_TOTAL, $title, $currency), "<label>"._XPY_AM_INVOICES_MAXARE_CANCELLED_COLLECT." $currency</label>", $invoice_handler->getMaximumByField('`grand`', '`mode`','CANCEL', array_merge(array('`remittion`'=>array('value'=>'COLLECT', 'operator'=>'=')), array('`currency`'=>array('value'=>$currency, 'operator'=> '=')), $part)), 'Green');
				    $indexAdmin->addInfoBoxLine(sprintf(_XPY_AM_INVOICES_MAX_TOTAL, $title, $currency), "<label>"._XPY_AM_INVOICES_MAXARE_UNPAID_FRAUD." $currency</label>", $invoice_handler->getMaximumByField('`grand`', '`mode`','UNPAID', array_merge(array('`remittion`'=>array('value'=>'FRAUD', 'operator'=>'=')), array('`currency`'=>array('value'=>$currency, 'operator'=> '=')), $part)), 'Green');
				    $indexAdmin->addInfoBoxLine(sprintf(_XPY_AM_INVOICES_MAX_TOTAL, $title, $currency), "<label>"._XPY_AM_INVOICES_MAXARE_PAID_FRAUD." $currency</label>", $invoice_handler->getMaximumByField('`grand`', '`mode`','PAID', array_merge(array('`remittion`'=>array('value'=>'FRAUD', 'operator'=>'=')), array('`currency`'=>array('value'=>$currency, 'operator'=> '=')), $part)), 'Green');
				    $indexAdmin->addInfoBoxLine(sprintf(_XPY_AM_INVOICES_MAX_TOTAL, $title, $currency), "<label>"._XPY_AM_INVOICES_MAXARE_CANCELLED_FRAUD." $currency</label>", $invoice_handler->getMaximumByField('`grand`', '`mode`','CANCEL', array_merge(array('`remittion`'=>array('value'=>'FRAUD', 'operator'=>'=')), array('`currency`'=>array('value'=>$currency, 'operator'=> '=')), $part)), 'Green');
				    $indexAdmin->addInfoBoxLine(sprintf(_XPY_AM_INVOICES_MAX_TOTAL, $title, $currency), "<label>"._XPY_AM_INVOICES_MAXARE_UNPAID_SETTLED." $currency</label>", $invoice_handler->getMaximumByField('`grand`', '`mode`','UNPAID', array_merge(array('`remittion`'=>array('value'=>'SETTLED', 'operator'=>'=')), array('`currency`'=>array('value'=>$currency, 'operator'=> '=')), $part)), 'Green');
				    $indexAdmin->addInfoBoxLine(sprintf(_XPY_AM_INVOICES_MAX_TOTAL, $title, $currency), "<label>"._XPY_AM_INVOICES_MAXARE_PAID_SETTLED." $currency</label>", $invoice_handler->getMaximumByField('`grand`', '`mode`','PAID', array_merge(array('`remittion`'=>array('value'=>'SETTLED', 'operator'=>'=')), array('`currency`'=>array('value'=>$currency, 'operator'=> '=')), $part)), 'Green');
				    $indexAdmin->addInfoBoxLine(sprintf(_XPY_AM_INVOICES_MAX_TOTAL, $title, $currency), "<label>"._XPY_AM_INVOICES_MAXARE_CANCELLED_SETTLED." $currency</label>", $invoice_handler->getMaximumByField('`grand`', '`mode`','CANCEL', array_merge(array('`remittion`'=>array('value'=>'SETTLED', 'operator'=>'=')), array('`currency`'=>array('value'=>$currency, 'operator'=> '=')), $part)), 'Green');
				    $indexAdmin->addInfoBoxLine(sprintf(_XPY_AM_INVOICES_MAX_TOTAL, $title, $currency), "<label>"._XPY_AM_INVOICES_MAXARE_UNPAID_DISCOUNTED." $currency</label>", $invoice_handler->getMaximumByField('`grand`', '`mode`','UNPAID', array_merge(array('`remittion`'=>array('value'=>'DISCOUNTED', 'operator'=>'=')), array('`currency`'=>array('value'=>$currency, 'operator'=> '=')), $part)), 'Green');
				    $indexAdmin->addInfoBoxLine(sprintf(_XPY_AM_INVOICES_MAX_TOTAL, $title, $currency), "<label>"._XPY_AM_INVOICES_MAXARE_PAID_DISCOUNTED." $currency</label>", $invoice_handler->getMaximumByField('`grand`', '`mode`','PAID', array_merge(array('`remittion`'=>array('value'=>'DISCOUNTED', 'operator'=>'=')), array('`currency`'=>array('value'=>$currency, 'operator'=> '=')), $part)), 'Green');
				    $indexAdmin->addInfoBoxLine(sprintf(_XPY_AM_INVOICES_MAX_TOTAL, $title, $currency), "<label>"._XPY_AM_INVOICES_MAXARE_CANCELLED_DISCOUNTED." $currency</label>", $invoice_handler->getMaximumByField('`grand`', '`mode`','CANCEL', array_merge(array('`remittion`'=>array('value'=>'DISCOUNTED', 'operator'=>'=')), array('`currency`'=>array('value'=>$currency, 'operator'=> '=')), $part)), 'Green');
				    $indexAdmin->addInfoBoxLine(sprintf(_XPY_AM_INVOICES_MAX_TOTAL, $title, $currency), "<label>"._XPY_AM_INVOICES_MAXARE_UNPAID_DISCOUNTED_AMOUNT." $currency</label>", $invoice_handler->getMaximumByField('`discount_amount`', '`mode`','UNPAID', array_merge(array('`remittion`'=>array('value'=>'DISCOUNTED', 'operator'=>'=')), array('`currency`'=>array('value'=>$currency, 'operator'=> '=')), $part)), 'Green');
				    $indexAdmin->addInfoBoxLine(sprintf(_XPY_AM_INVOICES_MAX_TOTAL, $title, $currency), "<label>"._XPY_AM_INVOICES_MAXARE_PAID_DISCOUNTED_AMOUNT." $currency</label>", $invoice_handler->getMaximumByField('`discount_amount`', '`mode`','PAID', array_merge(array('`remittion`'=>array('value'=>'DISCOUNTED', 'operator'=>'=')), array('`currency`'=>array('value'=>$currency, 'operator'=> '=')), $part)), 'Green');
				    $indexAdmin->addInfoBoxLine(sprintf(_XPY_AM_INVOICES_MAX_TOTAL, $title, $currency), "<label>"._XPY_AM_INVOICES_MAXARE_CANCELLED_DISCOUNTED_AMOUNT." $currency</label>", $invoice_handler->getMaximumByField('`discount_amount`', '`mode`','CANCEL', array_merge(array('`remittion`'=>array('value'=>'DISCOUNTED', 'operator'=>'=')), array('`currency`'=>array('value'=>$currency, 'operator'=> '=')), $part)), 'Green');	    
				    $indexAdmin->addInfoBoxLine(sprintf(_XPY_AM_INVOICES_MAX_TOTAL, $title, $currency), "<label>"._XPY_AM_INVOICES_MAXARE_UNPAID_DONATED."</label>", $invoice_handler->getMaximumByField('`grand`', '`mode`','UNPAID', array_merge($part, array('`currency`'=>array('value'=>$currency, 'operator'=> '=')), array('`donation`'=>array('value'=>true, 'operator'=>'=')))), 'Green');
				    $indexAdmin->addInfoBoxLine(sprintf(_XPY_AM_INVOICES_MAX_TOTAL, $title, $currency), "<label>"._XPY_AM_INVOICES_MAXARE_PAID_DONATED."</label>", $invoice_handler->getMaximumByField('`grand`', '`mode`','PAID', array_merge($part, array('`currency`'=>array('value'=>$currency, 'operator'=> '=')), array('`donation`'=>array('value'=>true, 'operator'=>'=')))), 'Green');
				    $indexAdmin->addInfoBoxLine(sprintf(_XPY_AM_INVOICES_MAX_TOTAL, $title, $currency), "<label>"._XPY_AM_INVOICES_MAXARE_CANCELLED_DONATED."</label>", $invoice_handler->getMaximumByField('`grand`', '`mode`','CANCEL', array_merge($part, array('`currency`'=>array('value'=>$currency, 'operator'=> '=')), array('`donation`'=>array('value'=>true, 'operator'=>'=')))), 'Green');
		    	}

		    	if (	$invoice_handler->getCountByField('*', '`mode`','UNPAID', array_merge(array('`currency`'=>array('value'=>$currency, 'operator'=> '=')), $part)) != '0' ||
		    			$invoice_handler->getCountByField('*', '`mode`','PAID', array_merge(array('`currency`'=>array('value'=>$currency, 'operator'=> '=')), $part)) != '0' ||
		    			$invoice_handler->getCountByField('*', '`mode`','CANCEL', array_merge(array('`currency`'=>array('value'=>$currency, 'operator'=> '=')), $part)) != '0'
		    		) {
				    $indexAdmin->addInfoBox(sprintf(_XPY_AM_INVOICES_COUNTS_TOTAL, $title, $currency));
			    	if ($part['`created`']['value']!=0) {
				    	$indexAdmin->addInfoBoxLine(sprintf(_XPY_AM_INVOICES_COUNTS_TOTAL, $title, $currency), "<label>"._XPY_AM_INVOICES_FROM."</label>", date(_DATESTRING, time()), 'Red');
					    $indexAdmin->addInfoBoxLine(sprintf(_XPY_AM_INVOICES_COUNTS_TOTAL, $title, $currency), "<label>"._XPY_AM_INVOICES_TO."</label>", date(_DATESTRING, $part['`created`']['value']), 'Red');
			    	}
				    $indexAdmin->addInfoBoxLine(sprintf(_XPY_AM_INVOICES_COUNTS_TOTAL, $title, $currency), "<label>"._XPY_AM_INVOICES_THEREARE_UNPAID."</label>", $invoice_handler->getCountByField('*', '`mode`','UNPAID', array_merge($part, array('`currency`'=>array('value'=>$currency, 'operator'=> '=')))), 'Green');
				    $indexAdmin->addInfoBoxLine(sprintf(_XPY_AM_INVOICES_COUNTS_TOTAL, $title, $currency), "<label>"._XPY_AM_INVOICES_THEREARE_PAID."</label>", $invoice_handler->getCountByField('*', '`mode`','PAID', array_merge($part, array('`currency`'=>array('value'=>$currency, 'operator'=> '=')))), 'Green');
				    $indexAdmin->addInfoBoxLine(sprintf(_XPY_AM_INVOICES_COUNTS_TOTAL, $title, $currency), "<label>"._XPY_AM_INVOICES_THEREARE_CANCELLED."</label>", $invoice_handler->getCountByField('*', '`mode`','CANCEL', array_merge($part, array('`currency`'=>array('value'=>$currency, 'operator'=> '=')))), 'Green');
				    $indexAdmin->addInfoBoxLine(sprintf(_XPY_AM_INVOICES_COUNTS_TOTAL, $title, $currency), "<label>"._XPY_AM_INVOICES_THEREARE_UNPAID_NONE."</label>", $invoice_handler->getCountByField('*', '`mode`','UNPAID', array_merge($part, array('`currency`'=>array('value'=>$currency, 'operator'=> '=')), array('`remittion`'=>array('value'=>'NONE', 'operator'=>'=')))), 'Green');
				    $indexAdmin->addInfoBoxLine(sprintf(_XPY_AM_INVOICES_COUNTS_TOTAL, $title, $currency), "<label>"._XPY_AM_INVOICES_THEREARE_PAID_NONE."</label>", $invoice_handler->getCountByField('*', '`mode`','PAID', array_merge($part, array('`currency`'=>array('value'=>$currency, 'operator'=> '=')), array('`remittion`'=>array('value'=>'NONE', 'operator'=>'=')))), 'Green');
				    $indexAdmin->addInfoBoxLine(sprintf(_XPY_AM_INVOICES_COUNTS_TOTAL, $title, $currency), "<label>"._XPY_AM_INVOICES_THEREARE_CANCELLED_NONE."</label>", $invoice_handler->getCountByField('*', '`mode`','CANCEL', array_merge($part, array('`currency`'=>array('value'=>$currency, 'operator'=> '=')), array('`remittion`'=>array('value'=>'NONE', 'operator'=>'=')))), 'Green');
				    $indexAdmin->addInfoBoxLine(sprintf(_XPY_AM_INVOICES_COUNTS_TOTAL, $title, $currency), "<label>"._XPY_AM_INVOICES_THEREARE_UNPAID_PENDING."</label>", $invoice_handler->getCountByField('*', '`mode`','UNPAID', array_merge($part, array('`currency`'=>array('value'=>$currency, 'operator'=> '=')), array('`remittion`'=>array('value'=>'PENDING', 'operator'=>'=')))), 'Green');
				    $indexAdmin->addInfoBoxLine(sprintf(_XPY_AM_INVOICES_COUNTS_TOTAL, $title, $currency), "<label>"._XPY_AM_INVOICES_THEREARE_PAID_PENDING."</label>", $invoice_handler->getCountByField('*', '`mode`','PAID', array_merge($part, array('`currency`'=>array('value'=>$currency, 'operator'=> '=')), array('`remittion`'=>array('value'=>'PENDING', 'operator'=>'=')))), 'Green');
				    $indexAdmin->addInfoBoxLine(sprintf(_XPY_AM_INVOICES_COUNTS_TOTAL, $title, $currency), "<label>"._XPY_AM_INVOICES_THEREARE_CANCELLED_PENDING."</label>", $invoice_handler->getCountByField('*', '`mode`','CANCEL', array_merge($part, array('`currency`'=>array('value'=>$currency, 'operator'=> '=')), array('`remittion`'=>array('value'=>'PENDING', 'operator'=>'=')))), 'Green');
					$indexAdmin->addInfoBoxLine(sprintf(_XPY_AM_INVOICES_COUNTS_TOTAL, $title, $currency), "<label>"._XPY_AM_INVOICES_THEREARE_UNPAID_NOTICE."</label>", $invoice_handler->getCountByField('*', '`mode`','UNPAID', array_merge($part, array('`currency`'=>array('value'=>$currency, 'operator'=> '=')), array('`remittion`'=>array('value'=>'NOTICE', 'operator'=>'=')))), 'Green');
				    $indexAdmin->addInfoBoxLine(sprintf(_XPY_AM_INVOICES_COUNTS_TOTAL, $title, $currency), "<label>"._XPY_AM_INVOICES_THEREARE_PAID_NOTICE."</label>", $invoice_handler->getCountByField('*', '`mode`','PAID', array_merge($part, array('`currency`'=>array('value'=>$currency, 'operator'=> '=')), array('`remittion`'=>array('value'=>'NOTICE', 'operator'=>'=')))), 'Green');
				    $indexAdmin->addInfoBoxLine(sprintf(_XPY_AM_INVOICES_COUNTS_TOTAL, $title, $currency), "<label>"._XPY_AM_INVOICES_THEREARE_CANCELLED_NOTICE."</label>", $invoice_handler->getCountByField('*', '`mode`','CANCEL', array_merge($part, array('`currency`'=>array('value'=>$currency, 'operator'=> '=')), array('`remittion`'=>array('value'=>'NOTICE', 'operator'=>'=')))), 'Green');
					$indexAdmin->addInfoBoxLine(sprintf(_XPY_AM_INVOICES_COUNTS_TOTAL, $title, $currency), "<label>"._XPY_AM_INVOICES_THEREARE_UNPAID_COLLECT."</label>", $invoice_handler->getCountByField('*', '`mode`','UNPAID', array_merge($part, array('`currency`'=>array('value'=>$currency, 'operator'=> '=')), array('`remittion`'=>array('value'=>'COLLECT', 'operator'=>'=')))), 'Green');
				    $indexAdmin->addInfoBoxLine(sprintf(_XPY_AM_INVOICES_COUNTS_TOTAL, $title, $currency), "<label>"._XPY_AM_INVOICES_THEREARE_PAID_COLLECT."</label>", $invoice_handler->getCountByField('*', '`mode`','PAID', array_merge($part, array('`currency`'=>array('value'=>$currency, 'operator'=> '=')), array('`remittion`'=>array('value'=>'COLLECT', 'operator'=>'=')))), 'Green');
				    $indexAdmin->addInfoBoxLine(sprintf(_XPY_AM_INVOICES_COUNTS_TOTAL, $title, $currency), "<label>"._XPY_AM_INVOICES_THEREARE_CANCELLED_COLLECT."</label>", $invoice_handler->getCountByField('*', '`mode`','CANCEL', array_merge($part, array('`currency`'=>array('value'=>$currency, 'operator'=> '=')), array('`remittion`'=>array('value'=>'COLLECT', 'operator'=>'=')))), 'Green');
					$indexAdmin->addInfoBoxLine(sprintf(_XPY_AM_INVOICES_COUNTS_TOTAL, $title, $currency), "<label>"._XPY_AM_INVOICES_THEREARE_UNPAID_FRAUD."</label>", $invoice_handler->getCountByField('*', '`mode`','UNPAID', array_merge($part, array('`currency`'=>array('value'=>$currency, 'operator'=> '=')), array('`remittion`'=>array('value'=>'FRAUD', 'operator'=>'=')))), 'Green');
				    $indexAdmin->addInfoBoxLine(sprintf(_XPY_AM_INVOICES_COUNTS_TOTAL, $title, $currency), "<label>"._XPY_AM_INVOICES_THEREARE_PAID_FRAUD."</label>", $invoice_handler->getCountByField('*', '`mode`','PAID', array_merge($part, array('`currency`'=>array('value'=>$currency, 'operator'=> '=')), array('`remittion`'=>array('value'=>'FRAUD', 'operator'=>'=')))), 'Green');
				    $indexAdmin->addInfoBoxLine(sprintf(_XPY_AM_INVOICES_COUNTS_TOTAL, $title, $currency), "<label>"._XPY_AM_INVOICES_THEREARE_CANCELLED_FRAUD."</label>", $invoice_handler->getCountByField('*', '`mode`','CANCEL', array_merge($part, array('`currency`'=>array('value'=>$currency, 'operator'=> '=')), array('`remittion`'=>array('value'=>'FRAUD', 'operator'=>'=')))), 'Green');
					$indexAdmin->addInfoBoxLine(sprintf(_XPY_AM_INVOICES_COUNTS_TOTAL, $title, $currency), "<label>"._XPY_AM_INVOICES_THEREARE_UNPAID_SETTLED."</label>", $invoice_handler->getCountByField('*', '`mode`','UNPAID', array_merge($part, array('`currency`'=>array('value'=>$currency, 'operator'=> '=')), array('`remittion`'=>array('value'=>'SETTLED', 'operator'=>'=')))), 'Green');
				    $indexAdmin->addInfoBoxLine(sprintf(_XPY_AM_INVOICES_COUNTS_TOTAL, $title, $currency), "<label>"._XPY_AM_INVOICES_THEREARE_PAID_SETTLED."</label>", $invoice_handler->getCountByField('*', '`mode`','PAID', array_merge($part, array('`currency`'=>array('value'=>$currency, 'operator'=> '=')), array('`remittion`'=>array('value'=>'SETTLED', 'operator'=>'=')))), 'Green');
				    $indexAdmin->addInfoBoxLine(sprintf(_XPY_AM_INVOICES_COUNTS_TOTAL, $title, $currency), "<label>"._XPY_AM_INVOICES_THEREARE_CANCELLED_SETTLED."</label>", $invoice_handler->getCountByField('*', '`mode`','CANCEL', array_merge($part, array('`currency`'=>array('value'=>$currency, 'operator'=> '=')), array('`remittion`'=>array('value'=>'SETTLED', 'operator'=>'=')))), 'Green');
					$indexAdmin->addInfoBoxLine(sprintf(_XPY_AM_INVOICES_COUNTS_TOTAL, $title, $currency), "<label>"._XPY_AM_INVOICES_THEREARE_UNPAID_SETTLED."</label>", $invoice_handler->getCountByField('*', '`mode`','UNPAID', array_merge($part, array('`currency`'=>array('value'=>$currency, 'operator'=> '=')), array('`remittion`'=>array('value'=>'SETTLED', 'operator'=>'=')))), 'Green');
				    $indexAdmin->addInfoBoxLine(sprintf(_XPY_AM_INVOICES_COUNTS_TOTAL, $title, $currency), "<label>"._XPY_AM_INVOICES_THEREARE_PAID_SETTLED."</label>", $invoice_handler->getCountByField('*', '`mode`','PAID', array_merge($part, array('`currency`'=>array('value'=>$currency, 'operator'=> '=')), array('`remittion`'=>array('value'=>'SETTLED', 'operator'=>'=')))), 'Green');
				    $indexAdmin->addInfoBoxLine(sprintf(_XPY_AM_INVOICES_COUNTS_TOTAL, $title, $currency), "<label>"._XPY_AM_INVOICES_THEREARE_CANCELLED_SETTLED."</label>", $invoice_handler->getCountByField('*', '`mode`','CANCEL', array_merge($part, array('`currency`'=>array('value'=>$currency, 'operator'=> '=')), array('`remittion`'=>array('value'=>'SETTLED', 'operator'=>'=')))), 'Green');
					$indexAdmin->addInfoBoxLine(sprintf(_XPY_AM_INVOICES_COUNTS_TOTAL, $title, $currency), "<label>"._XPY_AM_INVOICES_THEREARE_UNPAID_DISCOUNTED."</label>", $invoice_handler->getCountByField('*', '`mode`','UNPAID', array_merge($part, array('`currency`'=>array('value'=>$currency, 'operator'=> '=')), array('`remittion`'=>array('value'=>'DISCOUNTED', 'operator'=>'=')))), 'Green');
				    $indexAdmin->addInfoBoxLine(sprintf(_XPY_AM_INVOICES_COUNTS_TOTAL, $title, $currency), "<label>"._XPY_AM_INVOICES_THEREARE_PAID_DISCOUNTED."</label>", $invoice_handler->getCountByField('*', '`mode`','PAID', array_merge($part, array('`currency`'=>array('value'=>$currency, 'operator'=> '=')), array('`remittion`'=>array('value'=>'DISCOUNTED', 'operator'=>'=')))), 'Green');
				    $indexAdmin->addInfoBoxLine(sprintf(_XPY_AM_INVOICES_COUNTS_TOTAL, $title, $currency), "<label>"._XPY_AM_INVOICES_THEREARE_CANCELLED_DISCOUNTED."</label>", $invoice_handler->getCountByField('*', '`mode`','CANCEL', array_merge($part, array('`currency`'=>array('value'=>$currency, 'operator'=> '=')), array('`remittion`'=>array('value'=>'DISCOUNTED', 'operator'=>'=')))), 'Green');
					$indexAdmin->addInfoBoxLine(sprintf(_XPY_AM_INVOICES_COUNTS_TOTAL, $title, $currency), "<label>"._XPY_AM_INVOICES_THEREARE_UNPAID_DONATED."</label>", $invoice_handler->getCountByField('*', '`mode`','UNPAID', array_merge($part, array('`currency`'=>array('value'=>$currency, 'operator'=> '=')), array('`donation`'=>array('value'=>true, 'operator'=>'=')))), 'Green');
				    $indexAdmin->addInfoBoxLine(sprintf(_XPY_AM_INVOICES_COUNTS_TOTAL, $title, $currency), "<label>"._XPY_AM_INVOICES_THEREARE_PAID_DONATED."</label>", $invoice_handler->getCountByField('*', '`mode`','PAID', array_merge($part, array('`currency`'=>array('value'=>$currency, 'operator'=> '=')), array('`donation`'=>array('value'=>true, 'operator'=>'=')))), 'Green');
				    $indexAdmin->addInfoBoxLine(sprintf(_XPY_AM_INVOICES_COUNTS_TOTAL, $title, $currency), "<label>"._XPY_AM_INVOICES_THEREARE_CANCELLED_DONATED."</label>", $invoice_handler->getCountByField('*', '`mode`','CANCEL', array_merge($part, array('`currency`'=>array('value'=>$currency, 'operator'=> '=')), array('`donation`'=>array('value'=>true, 'operator'=>'=')))), 'Green');
		    	}	    
		    }
	    }
	        
	    echo $indexAdmin->renderIndex();	
		
		break;	
	case "about":
		loadModuleAdminMenu(8);
		$paypalitemno='XPAYMENTABOUT100';
		$aboutAdmin = new ModuleAdmin();
		$about = $aboutAdmin->renderabout($paypalitemno, false);
		$donationform = array(	0 => '<form name="donation" id="donation" action="http://www.chronolabs.com.au/modules/xpayment/" method="post" onsubmit="return xoopsFormValidate_donation();">',
								1 => '<table class="outer" cellspacing="1" width="100%"><tbody><tr><th colspan="2">'.constant('_XPY_AM_XPAYMENT_ABOUT_MAKEDONATE').'</th></tr><tr align="left" valign="top"><td class="head"><div class="xoops-form-element-caption-required"><span class="caption-text">Donation Amount</span><span class="caption-marker">*</span></div></td><td class="even"><select size="1" name="item[A][amount]" id="item[A][amount]" title="Donation Amount"><option value="5">5.00 AUD</option><option value="10">10.00 AUD</option><option value="20">20.00 AUD</option><option value="40">40.00 AUD</option><option value="60">60.00 AUD</option><option value="80">80.00 AUD</option><option value="90">90.00 AUD</option><option value="100">100.00 AUD</option><option value="200">200.00 AUD</option></select></td></tr><tr align="left" valign="top"><td class="head"></td><td class="even"><input class="formButton" name="submit" id="submit" value="'._SUBMIT.'" title="'._SUBMIT.'" type="submit"></td></tr></tbody></table>',
								2 => '<input name="op" id="op" value="createinvoice" type="hidden"><input name="plugin" id="plugin" value="donations" type="hidden"><input name="donation" id="donation" value="1" type="hidden"><input name="drawfor" id="drawfor" value="Chronolabs Co-Operative" type="hidden"><input name="drawto" id="drawto" value="%s" type="hidden"><input name="drawto_email" id="drawto_email" value="%s" type="hidden"><input name="key" id="key" value="%s" type="hidden"><input name="currency" id="currency" value="AUD" type="hidden"><input name="weight_unit" id="weight_unit" value="kgs" type="hidden"><input name="item[A][cat]" id="item[A][cat]" value="XDN%s" type="hidden"><input name="item[A][name]" id="item[A][name]" value="Donation for %s" type="hidden"><input name="item[A][quantity]" id="item[A][quantity]" value="1" type="hidden"><input name="item[A][shipping]" id="item[A][shipping]" value="0" type="hidden"><input name="item[A][handling]" id="item[A][handling]" value="0" type="hidden"><input name="item[A][weight]" id="item[A][weight]" value="0" type="hidden"><input name="item[A][tax]" id="item[A][tax]" value="0" type="hidden"><input name="return" id="return" value="http://www.chronolabs.com.au/modules/donations/success.php" type="hidden"><input name="cancel" id="cancel" value="http://www.chronolabs.com.au/modules/donations/success.php" type="hidden"></form>',																'D'=>'',
								3 => '',
								4 => '<!-- Start Form Validation JavaScript //-->
<script type="text/javascript">
<!--//
function xoopsFormValidate_donation() { var myform = window.document.donation; 
var hasSelected = false; var selectBox = myform.item[A][amount];for (i = 0; i < selectBox.options.length; i++ ) { if (selectBox.options[i].selected == true && selectBox.options[i].value != \'\') { hasSelected = true; break; } }if (!hasSelected) { window.alert("Please enter Donation Amount"); selectBox.focus(); return false; }return true;
}
//--></script>
<!-- End Form Validation JavaScript //-->');
		$paypalform = array(	0 => '<form action="https://www.paypal.com/cgi-bin/webscr" method="post">',
								1 => '<input name="cmd" value="_s-xclick" type="hidden">',
								2 => '<input name="hosted_button_id" value="%s" type="hidden">',
								3 => '<img alt="" src="https://www.paypal.com/fr_FR/i/scr/pixel.gif" height="1" border="0" width="1">',
								4 => '<input src="https://www.paypal.com/en_US/i/btn/btn_donate_LG.gif" name="submit" alt="PayPal - The safer, easier way to pay online!" border="0" type="image">',
								5 => '</form>');
		for($key=0;$key<=4;$key++) {
			switch ($key) {
				case 2:
					$donationform[$key] =  sprintf($donationform[$key], $GLOBALS['xoopsConfig']['sitename'] . ' - ' . (strlen($GLOBALS['xoopsUser']->getVar('name'))>0?$GLOBALS['xoopsUser']->getVar('name'). ' ['.$GLOBALS['xoopsUser']->getVar('uname').']':$GLOBALS['xoopsUser']->getVar('uname')), $GLOBALS['xoopsUser']->getVar('email'), XOOPS_LICENSE_KEY, strtoupper($GLOBALS['xpaymentModule']->getVar('dirname')),  strtoupper($GLOBALS['xpaymentModule']->getVar('dirname')). ' '.$GLOBALS['xpaymentModule']->getVar('name'));
					break;
			}
		}
		
		$istart = strpos($about, ($paypalform[0]), 1);
		$iend = strpos($about, ($paypalform[5]), $istart+1)+strlen($paypalform[5])-1;
		echo (substr($about, 0, $istart-1));
		echo implode("\n", $donationform);
		echo (substr($about, $iend+1, strlen($about)-$iend-1));
		break;
	}
		
	xoops_cp_footer();
?>