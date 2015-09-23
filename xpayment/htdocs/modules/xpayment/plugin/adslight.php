<?php

	
	function PaidAdslightHook($invoice) {

		$sql = "update ".$GLOBALS['xoopsDB']->prefix('adslight_listing').' set `status` = 2 where `lid`= "'.$invoice->getVar('key').'"';
		$GLOBALS['xoopsDB']->queryF($sql);
		include_once $GLOBALS['xoops']->path('/modules/xpayment/plugin/xpayment.php');		
		return PaidXPaymentHook($invoice);
		
	}
	
	function UnpaidAdslightHook($invoice) {
		include_once $GLOBALS['xoops']->path('/modules/xpayment/plugin/xpayment.php');
		return UnpaidXPaymentHook($invoice);		
	}
	
	function CancelAdslightHook($invoice) {
		include_once $GLOBALS['xoops']->path('/modules/xpayment/plugin/xpayment.php');
		return CancelXPaymentHook($invoice);
	}
	
?>