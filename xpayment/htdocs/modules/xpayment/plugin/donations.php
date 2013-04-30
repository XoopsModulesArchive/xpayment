<?php
	function PaidDonationsHook($invoice) {
	
		$donations_handler = xoops_getmodulehandler('donations', 'donations');
		$donation = $donations_handler->create();
		$donation->setVar('uid', $invoice->getVar('user_uid'));
		$donation->setVar('amount', $invoice->getVar('grand'));
		$donation->setVar('currency', $invoice->getVar('currency'));
		$donation->setVar('realname', $invoice->getVar('drawto'));
		$donation->setVar('email', $invoice->getVar('drawto_email'));
		$donation->setVar('iid', $invoice->getVar('iid'));
		
		$invoice_transaction_handler = xoops_getmodulehandler('invoice_transactions', 'xpayment');
		$criteria = new Criteria('iid', $invoice->getVar('iid'));
		$criteria->setSort('`date`');
		$criteria->setOrder('DESC');
		$criteria->setLimit(1);
		
		$trans = $invoice_transaction_handler->getObjects($criteria);
		if (is_object($trans[0])) {
			$donation->setVar('state', $trans[0]->getVar('state'));
			$donation->setVar('country', $trans[0]->getVar('country'));
		}
		
		@$donations_handler->insert($donation, true);

		$module_handler = xoops_gethandler('module');
		$config_handler = xoops_gethandler('config');
		$xoMod = $module_handler->getByDirname('donations');
		$xoConfig = $config_handler->getConfigList($xoMod->getVar('mid'));
		
		if ($xoConfig['change_group']&&$donation->getVar('uid')<>0) {
			$member_handler = xoops_gethandler('member');
			$member_handler->addUserToGroup($xoConfig['donation_group'], $donation->getVar('uid'));
		}
		
		$xoMod = $module_handler->getByDirname('profile');
		if (is_object($xoMod)&&$donation->getVar('uid')<>0) {
			$profile_handler = xoops_getmodulehandler('profile', 'profile');
			$profile = $profile_handler->get($donation->getVar('uid'));
			$profile->setVar($xoConfig['profile_field'], time());
			$profile_handler->insert($profile);
		}
		
		include_once $GLOBALS['xoops']->path('/modules/xpayment/plugin/xpayment.php');		
		return PaidXPaymentHook($invoice);
		
	}
	
	function UnpaidDonationsHook($invoice) {
		include_once $GLOBALS['xoops']->path('/modules/xpayment/plugin/xpayment.php');
		return UnpaidXPaymentHook($invoice);		
	}
	
	function CancelDonationsHook($invoice) {
		include_once $GLOBALS['xoops']->path('/modules/xpayment/plugin/xpayment.php');
		return CancelXPaymentHook($invoice);
	}
	
	?>