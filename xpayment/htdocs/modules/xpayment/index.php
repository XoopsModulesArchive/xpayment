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
    $invoice='';
	
	if (isset($_POST)&&!empty($_POST)) {
		
		if (isset($_POST['op'])&&$_POST['op']==='createinvoice') {
			
			
			$invoice_handler =& xoops_getmodulehandler('invoice', 'xpayment');

			// Stops Duplication
			$userip = getIPData(false);
			if (isset($_POST['key'])) {
				$criteria = new CriteriaCompo(new Criteria('`plugin`', (!empty($_POST['plugin'])?$_POST['plugin']:'xpayment')));
				$criteria->add(new Criteria('`key`', $_POST['key']));
				$criteria->add(new Criteria('`mode`', 'UNPAID'));
				if ($userip['uid']>0) {
					$criteria->add(new Criteria('`user_uid`', $userip['uid']));
				} else {
					$criteria->add(new Criteria('`user_ip`', $userip['ip4'].$userip['ip6']));
					$criteria->add(new Criteria('`user_netaddy`', $userip['network-addy']));
				}
				if ($invoice_handler->getCount($criteria)==1) {
					$invoices = $invoice_handler->getObjects($criteria, false);
					header( "HTTP/1.1 301 Moved Permanently" ); 
			       	header('Location: '.$invoices[0]->getURL());
			        exit;
				}
			}
			
			$invoice_items_handler =& xoops_getmodulehandler('invoice_items', 'xpayment');
						
			$invoice = $invoice_handler->create();
			
			$invoice->setVar('return', $_POST['return']);
			$invoice->setVar('cancel', $_POST['cancel']);
			$invoice->setVar('ipn', $_POST['ipn']);
			$invoice->setVar('currency', (!empty($_POST['currency'])?strtoupper($_POST['currency']):$GLOBALS['xoopsModuleConfig']['currency']));
			$invoice->setVar('drawfor', (!empty($_POST['drawfor'])?$_POST['drawfor']:$GLOBALS['xoopsConfig']['sitename']));
			$invoice->setVar('invoicenumber', $_POST['invoicenumber']);
			$invoice->setVar('drawto', $_POST['drawto']);
			$invoice->setVar('drawto_email', $_POST['drawto_email']);
			$invoice->setVar('key', $_POST['key']);
			$invoice->setVar('plugin', (!empty($_POST['plugin'])?$_POST['plugin']:'xpayment'));
			$invoice->setVar('weight_unit', (!empty($_POST['weight_unit'])?strtolower($_POST['weight_unit']):$GLOBALS['xoopsModuleConfig']['weightunit']));
			$invoice->setVar('mode', 'UNPAID');
			$invoice->setVar('reoccurrence', $_POST['reoccurrence']);
			$invoice->setVar('reoccurrence_period_days', (!empty($_POST['reoccurrence_period_days'])?$_POST['reoccurrence_period_days']:($GLOBALS['xoopsModuleConfig']['period']/(60*60*24))));
			$invoice->setVar('donation', ((isset($_POST['donation'])||isset($_POST['donations']))?true:false));
			$invoice->setVar('comment', $_POST['comment']);
			
			if (isset($_POST['topayment'])&&$_POST['topayment']==true) {
				$invoice->setVar('topayment', time()+$GLOBALS['xpaymentModuleConfig']['secs_topayment']);
			} else {
				$invoice->setVar('topayment', 0);
			}
			
			$invoice->setVar('user_ip', $userip['ip4'].$userip['ip6']);
			$invoice->setVar('user_netaddy', $userip['network-addy']);
			$invoice->setVar('user_uid', $userip['uid']);
			
			
			
			if ($iid = $invoice_handler->insert($invoice)) {
				$invoice = $invoice_handler->get($iid);
				if (strlen($invoice->getVar('invoicenumber'))==0)
					$invoice->setVar('invoicenumber', $invoice->getVar('iid'));
				$amount=0;
				$shipping=0;
				$handling=0;
				$weight=0;
				$items=0;
				$tax=0;
				foreach($_POST['item'] as $id => $item) {
					if (!empty($item['cat'])&&!empty($item['name'])&&$item['quantity']>0) {
						$itemobj = $invoice_items_handler->create();
						$itemobj->setVar('iid', $invoice->getVar('iid'));		
						$itemobj->setVars($item);
						if ($iiid = $invoice_items_handler->insert($itemobj)) {
							$items=$items+$itemobj->getVar('quantity');
							$totals = $itemobj->getTotalsArray();
							$amount = $amount + $totals['amount'];
							$shipping = $shipping + $totals['shipping'];
							$handling = $handling + $totals['handling'];
							$weight = $weight + $totals['weight'];
							$tax = $tax + $totals['tax'];					
						}
					}
				}
				
				$invoice->setVar('items', $items);
				$invoice->setVar('shipping', $shipping);
				$invoice->setVar('handling', $handling);
				$invoice->setVar('weight', $weight);
				$invoice->setVar('tax', $tax);
				$invoice->setVar('amount', $amount);
				$grand = ($amount+$handling+$shipping+$tax);
				$invoice->setVar('grand', $grand);
				
				$groups_handler  =& xoops_getmodulehandler('groups', 'xpayment');
				$invoice->setVar('broker_uids', $groups_handler->getUids('BROKERS', $invoice->getVar('plugin'), $grand));
				$invoice->setVar('accounts_uids', $groups_handler->getUids('ACCOUNTS', $invoice->getVar('plugin'), $grand));
				$invoice->setVar('officer_uids', $groups_handler->getUids('OFFICERS', $invoice->getVar('plugin'), $grand));
				
				$invoice = $invoice_handler->get($invoice_handler->insert($invoice));
				if (isset($_POST['code'])) {
					$invoice->applyDiscountCode($_POST['code']);
					$invoice = $invoice_handler->get($invoice_handler->insert($invoice));
				}
				
				$xoopsMailer =& getMailer();
				$xoopsMailer->setHTML(true);
				$xoopsMailer->setTemplateDir($GLOBALS['xoops']->path('/modules/xpayment/language/'.$GLOBALS['xoopsConfig']['language'].'/mail_templates/'));
				$xoopsMailer->setTemplate('xpayment_invoice_created.tpl');
				$xoopsMailer->setSubject(sprintf(_XPY_EMAIL_CREATED_SUBJECT, $grand, $_POST['currency'], $_POST['drawto']));
				
				$xoopsMailer->setToEmails($_POST['drawto_email']);
				
				$xoopsMailer->assign("SITEURL", XOOPS_URL);
				$xoopsMailer->assign("SITENAME", $GLOBALS['xoopsConfig']['sitename']);
				$xoopsMailer->assign("INVOICENUMBER", $invoice->getVar('invoicenumber'));
				$xoopsMailer->assign("CURRENCY", $invoice->getVar('currency'));
				$xoopsMailer->assign("DRAWTO", $invoice->getVar('drawto'));
				$xoopsMailer->assign("DRAWTO_EMAIL", $invoice->getVar('drawto_email'));
				$xoopsMailer->assign("DRAWFOR", $invoice->getVar('drawfor'));	
				$xoopsMailer->assign("AMOUNT", $grand);
				$xoopsMailer->assign("INVURL", $invoice->getURL());
				$xoopsMailer->assign("PDFURL", $invoice->getPDFURL());
				
				if(!$xoopsMailer->send() ){
					xoops_error($xoopsMailer->getErrors(true), 'Email Send Error');
				}
								
				header( "HTTP/1.1 301 Moved Permanently" ); 
		       	header('Location: '.$invoice->getURL());
		        exit;
				
			} else {
				include_once $GLOBALS['xoops']->path('/header.php');
				xoops_error($invoice->getHtmlErrors(), 'Invoice Creation Error');
				include_once $GLOBALS['xoops']->path('/footer.php');
				exit(0);		
			}	
		} elseif (isset($_POST['op'])&&$_POST['op']==='discount') {
			$invoice_handler =& xoops_getmodulehandler('invoice', 'xpayment');
			$key = $_POST['iid'];
			$criteria = new Criteria('offline', time(), '>=');
			$criteria->setSort('iid');
			$criteria->setOrder('DESC');
			$count = $invoice_handler->getCount($criteria);
			$invoices = $invoice_handler->getObjects($criteria, true);
			foreach($invoices as $iid => $inv) {
				if ($key==md5($inv->getVar('iid').XOOPS_LICENSE_KEY)) {
					$invoice = $inv;
				}
			}
			
			if (is_object($invoice)) {
				if ($invoice->applyDiscountCode($_POST['code'])) {
					if ($invoice_handler->insert($invoice)) {
						redirect_header($invoice->getURL(), 10, sprintf(_XPY_MF_DISCOUNT_APPLIED_SUCCESSFULLY, $invoice->getVar('discount'), $invoice->getVar('discount_amount'), $invoice->getVar('currency')));
					} else {
						redirect_header($invoice->getURL(), 10, _XPY_MF_DISCOUNT_APPLIED_UNSUCCESSFULLY);
					}
				} else {
					redirect_header($invoice->getURL(), 10, _XPY_MF_DISCOUNT_APPLIED_UNSUCCESSFULLY);
				}
			} else {
				redirect_header(XOOPS_URL, 10, _NOPERM);
			}
			exit(0);
		} else {
			
			if ($GLOBALS['xoopsModuleConfig']['htaccess']==true)
				$url = XOOPS_URL.'/'.$GLOBALS['xoopsModuleConfig']['baseurl'].'/index'.$GLOBALS['xoopsModuleConfig']['endofurl'];
			else
				$url = XOOPS_URL.'/modules/xpayment/index.php';
			
			if (!strpos($url, $_SERVER['REQUEST_URI'])&&$GLOBALS['xoopsModuleConfig']['htaccess']==true) {
				header( "HTTP/1.1 301 Moved Permanently" ); 
				header('Location: '.$url);
				exit(0);
			}
		
			if ($GLOBALS['xoopsModuleConfig']['help']==true)
				$xoopsOption['template_main'] = 'xpayment_help.html';
			else 
				$xoopsOption['template_main'] = 'xpayment_invoice.html';
			include_once $GLOBALS['xoops']->path('/header.php');
			$GLOBALS['xoopsTpl']->assign('xoops_siteemail',  $GLOBALS['xoopsConfig']['adminmail']);
			$GLOBALS['xoopsTpl']->assign('php_self', $_SERVER['PHP_SELF']);
			$GLOBALS['xoopsTpl']->assign('xoConfig', $GLOBALS['xoopsModuleConfig']);
			if (is_object($GLOBALS['xoopsUser']))
				$GLOBALS['xoopsTpl']->assign('user', $GLOBALS['xoopsUser']->toArray());
			include_once $GLOBALS['xoops']->path('/footer.php');
			exit(0);
		}
		
	} else {
		$invoice_handler =& xoops_getmodulehandler('invoice', 'xpayment');
		$invoice_items_handler =& xoops_getmodulehandler('invoice_items', 'xpayment');
	
		if (isset($_GET['iid'])&&$GLOBALS['xoopsModuleConfig']['id_protect']==false) {
			$invoice =& $invoice_handler->get($_GET['iid']);
		} elseif (isset($_GET['invoicenum'])&&$GLOBALS['xoopsModuleConfig']['id_protect']==false) {
			$invoice =& $invoice_handler->getInvoiceNumber($_GET['invoicenum']);
		} else {
			$key = isset($_GET['iid']) ? $_GET['iid'] : '';
			$criteria = new Criteria('offline', time(), '>=');
			$criteria->setSort('iid');
			$criteria->setOrder('DESC');
			$count = $invoice_handler->getCount($criteria);
			$invoices = $invoice_handler->getObjects($criteria, true);
			foreach($invoices as $iid => $inv) {
				if ($key==md5($inv->getVar('iid').XOOPS_LICENSE_KEY)) {
					$invoice = $inv;
				}
			}
		}
		
		if (!is_object($invoice)) {

			if ($GLOBALS['xoopsModuleConfig']['htaccess']==true)
				$url = XOOPS_URL.'/'.$GLOBALS['xoopsModuleConfig']['baseurl'].'/index'.$GLOBALS['xoopsModuleConfig']['endofurl'];
			else
				$url = XOOPS_URL.'/modules/xpayment/index.php';
			
			if (!strpos($url, $_SERVER['REQUEST_URI'])&&$GLOBALS['xoopsModuleConfig']['htaccess']==true) {
				header( "HTTP/1.1 301 Moved Permanently" ); 
				header('Location: '.$url);
				exit(0);
			}
		
			if ($GLOBALS['xoopsModuleConfig']['help']==true)
				$xoopsOption['template_main'] = 'xpayment_help.html';
			else 
				$xoopsOption['template_main'] = 'xpayment_invoice.html';
			include_once $GLOBALS['xoops']->path('/header.php');
			$GLOBALS['xoopsTpl']->assign('xoops_siteemail',  $GLOBALS['xoopsConfig']['adminmail']);
			$GLOBALS['xoopsTpl']->assign('php_self', $_SERVER['PHP_SELF']);
			$GLOBALS['xoopsTpl']->assign('xoConfig', $GLOBALS['xoopsModuleConfig']);
			if (is_object($GLOBALS['xoopsUser']))
				$GLOBALS['xoopsTpl']->assign('user', $GLOBALS['xoopsUser']->toArray());
			include_once $GLOBALS['xoops']->path('/footer.php');
			exit(0);
		}
		
		if (!strpos($invoice->getURL(), $_SERVER['REQUEST_URI'])&&$GLOBALS['xoopsModuleConfig']['htaccess']==true) {
				header( "HTTP/1.1 301 Moved Permanently" ); 
				header('Location: '.$invoice->getURL());
				exit(0);
			}
		
		if ($invoice->getVar('offline')<time()) {
			header( "HTTP/1.1 301 Moved Permanently" ); 
			header('Location: '.XOOPS_URL.'/modules/xpayment/');
			exit(0);
		}
			
		$xoopsOption['template_main'] = 'xpayment_payment.html';
		include_once $GLOBALS['xoops']->path('/header.php');
		

		$GLOBALS['xoopsTpl']->assign('invoice', $invoice->toArray());
		$GLOBALS['xoopsTpl']->assign('xoConfig', $GLOBALS['xoopsModuleConfig']);
		
		if ($invoice->getVar('mode')=='UNPAID') {
			$GLOBALS['xoTheme']->addScript(XOOPS_URL.'/browse.php?Frameworks/jquery/jquery.js');
			$GLOBALS['xoTheme']->addScript(XOOPS_URL.'/modules/xpayment/js/jquery.json.gateway.js');
			$GLOBALS['xoTheme']->addScript( null, array( 'type' => 'text/javascript' ), 'function ChangeGateway(element) {
	var params = new Array();
	$.getJSON("'.XOOPS_URL.'/modules/xpayment/dojsongateway.php?passkey=' . md5(XOOPS_LICENSE_KEY.date('Ymdhi')) . '&gid=" + $(\'#\' + element).val() + "&iid='. $_GET['iid'] . '", params, refreshformdesc);
}' );
			xoops_load('xoopsformloader');
			include($GLOBALS['xoops']->path('/modules/xpayment/include/formselectgateway.php'));
			$gatewaysel = new XoopsFormSelectGateway('', 'gid');
			$gatewaysel->setExtra('onchange="javascript:ChangeGateway(\'gid\');"');	
			$button = new XoopsFormButton('', 'submit', _SUBMIT);
			$button->setExtra('onclick="javascript:ChangeGateway(\'gid\');"');
			$GLOBALS['xoopsTpl']->assign('payment_markup', '<span>'.$gatewaysel->render().$button->render().'</span>');
			$GLOBALS['xoopsTpl']->assign('discount_form', xpayment_userdiscount($invoice));
		}
		
		$criteria = new Criteria('iid', $invoice->getVar('iid'));
		$items = $invoice_items_handler->getObjects($criteria, true);
		foreach($items as $iiid => $item)
			$GLOBALS['xoopsTpl']->append('items',  $item->toArray(($invoice->getVar('did')!=0)));
			
		include_once $GLOBALS['xoops']->path('/footer.php');
	}
	
?>