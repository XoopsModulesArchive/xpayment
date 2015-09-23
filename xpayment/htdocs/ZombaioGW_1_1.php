<?php
	include('modules/xpayment/header.php');
	
	include_once($GLOBALS['xoops']->path('/modules/xpayment/class/gateway/zombaio/zombaio.php'));
	$class = 'ZombaioGatewaysPlugin';
	
	if (class_exists($class))
		$invoice = $class::goInvoiceObj();

	if (is_a($invoice, 'XpaymentInvoice')) {
		$gateways_handler =& xoops_getmodulehandler('gateways','xpayment');
		$gateway = $gateways_handler->getGateway($invoice->getVar('gateway'), $invoice);
	}
	
	if (is_a($gateway, 'XpaymentGateways')) {
		$gateway->goIPN($_REQUEST);
	}
		
?>