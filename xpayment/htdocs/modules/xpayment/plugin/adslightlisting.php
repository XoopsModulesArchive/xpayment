<?php

	
	function PaidAdslightlistingHook($invoice) {

		$sql = "update ".$GLOBALS['xoopsDB']->prefix('adslight_listing').' set `valid` = \'Yes\' where `lid`= "'.$invoice->getVar('key').'"';
		$GLOBALS['xoopsDB']->queryF($sql);
		include_once $GLOBALS['xoops']->path('/modules/xpayment/plugin/xpayment.php');		
		return PaidXPaymentHook($invoice);
		
	}
	
	function UnpaidAdslightlistingHook($invoice) {
		include_once $GLOBALS['xoops']->path('/modules/xpayment/plugin/xpayment.php');
		return UnpaidXPaymentHook($invoice);		
	}
	
	function CancelAdslightlistingHook($invoice) {
		include_once $GLOBALS['xoops']->path('/modules/xpayment/plugin/xpayment.php');
		return CancelXPaymentHook($invoice);
	}
	
?>