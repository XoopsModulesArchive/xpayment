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
	function xpayment_adminpayment($invoice) {

		$sform = new XoopsThemeForm(_XPY_AM_PAYMENT, 'payment', $_SERVER['PHP_SELF'], 'post');
		$formobj = array();	
		$eletray = array();
				
		$formobj['transactionid'] = new XoopsFormText(_XPY_AM_TH_TRANSACTIONID, 'transactionid', 45, 128, '');
		$invoice_transactions_handler =& xoops_getmodulehandler('invoice_transactions', 'xpayment');
		$gross = $invoice_transactions_handler->sumOfGross($invoice->getVar('iid'));
		$left = $invoice->getVar('grand')-$gross;
		if ($left<>0)
			$formobj['amount'] = new XoopsFormText(_XPY_AM_TH_AMOUNT, 'amount', 15, 15, $left);
		else 
			return false;

		$eletray['buttons'] = new XoopsFormElementTray('', '&nbsp;');
		$sformobj['buttons']['save'] = new XoopsFormButton('', 'submit', _SUBMIT, 'submit');
		$eletray['buttons']->addElement($sformobj['buttons']['save']);
		$formobj['buttons'] = $eletray['buttons'];
				
		$required = array('transactionid', 'amount');
		
		foreach($formobj as $id => $obj)			
			if (in_array($id, $required))
				$sform->addElement($formobj[$id], true);			
			else
				$sform->addElement($formobj[$id], false);

		$sform->addElement(new XoopsFormHidden('iid', $invoice->getVar('iid')));		
		$sform->addElement(new XoopsFormHidden('op', 'invoices'));	
		$sform->addElement(new XoopsFormHidden('fct', 'transaction'));	
		
		return $sform->render();
		
	}

	function xpayment_adminsettle($invoice) {

		$sform = new XoopsThemeForm(_XPY_AM_SETTLE, 'settle', $_SERVER['PHP_SELF'], 'post');
		$formobj = array();	
		$eletray = array();
				
		$invoice_transactions_handler =& xoops_getmodulehandler('invoice_transactions', 'xpayment');
		$gross = $invoice_transactions_handler->sumOfGross($invoice->getVar('iid'));
		$left = $invoice->getVar('grand')-$gross;
		if ($left<>0)
			$formobj['settlement'] = new XoopsFormText(_XPY_AM_TH_AMOUNT, 'settlement', 15, 15, $left);
		else 
			return false;

		$eletray['buttons'] = new XoopsFormElementTray('', '&nbsp;');
		$sformobj['buttons']['save'] = new XoopsFormButton('', 'submit', _SUBMIT, 'submit');
		$eletray['buttons']->addElement($sformobj['buttons']['save']);
		$formobj['buttons'] = $eletray['buttons'];
				
		$required = array('settlement');
		
		foreach($formobj as $id => $obj)			
			if (in_array($id, $required))
				$sform->addElement($formobj[$id], true);			
			else
				$sform->addElement($formobj[$id], false);

		$sform->addElement(new XoopsFormHidden('iid', $invoice->getVar('iid')));		
		$sform->addElement(new XoopsFormHidden('op', 'invoices'));	
		$sform->addElement(new XoopsFormHidden('fct', 'settle'));	
		
		return $sform->render();
		
	}
	
	function xpayment_adminrule($rid, $group_id) {

		$sform = new XoopsThemeForm(_XPY_AM_ADDRULE, 'rule', $_SERVER['PHP_SELF'], 'post');
		$formobj = array();	
		$eletray = array();
		
		$groups_handler =& xoops_getmodulehandler('groups', 'xpayment');
		if ($rid==0)
			$group = $groups_handler->create();
		else 
		 	$group = $groups_handler->get($rid);
				
		$formobj['plugin'] = new XoopsFormSelectPlugin(_XPY_AM_TH_PLUGIN, 'plugin', $group->getVar('plugin'));
		$formobj['uid'] = new XoopsFormSelectGroupedUser(_XPY_AM_TH_UID, 'uid', $group->getVar('uid'), 1, false, $group_id);
		$formobj['limit'] = new XoopsFormRadioYN(_XPY_AM_TH_LIMIT, 'limit', $group->getVar('limit'));
		$formobj['minimum'] = new XoopsFormText(_XPY_AM_TH_MINIMUM, 'minimum', 15, 16, $group->getVar('minimum'));
		$formobj['maximum'] = new XoopsFormText(_XPY_AM_TH_MAXIMUM, 'maximum', 15, 16, $group->getVar('maximum'));
		
		$eletray['buttons'] = new XoopsFormElementTray('', '&nbsp;');
		$sformobj['buttons']['save'] = new XoopsFormButton('', 'submit', _SUBMIT, 'submit');
		$eletray['buttons']->addElement($sformobj['buttons']['save']);
		$formobj['buttons'] = $eletray['buttons'];
				
		$required = array('plugin', 'uid');
		
		foreach($formobj as $id => $obj)			
			if (in_array($id, $required))
				$sform->addElement($formobj[$id], true);			
			else
				$sform->addElement($formobj[$id], false);

		$sform->addElement(new XoopsFormHidden('rid', $group->getVar('rid')));		
		$sform->addElement(new XoopsFormHidden('op', 'groups'));	
		$sform->addElement(new XoopsFormHidden('fct', 'save'));	
		$sform->addElement(new XoopsFormHidden('action', $_REQUEST['fct']));
		
		return $sform->render();
		
		return '';
	}
	
	function xpayment_userdiscount($invoice) {

		$sform = new XoopsThemeForm(_XPY_MF_DISCOUNT, 'discount', $_SERVER['PHP_SELF'], 'post');
		$formobj = array();	
		$eletray = array();
		
		if ($invoice->getVar('did')>0) {
			$formobj['discount'] = new XoopsFormLabel(_XPY_MF_DISCOUNT_CODE, str_replace('%amount', $invoice->getVar('discount_amount') . ' ' . $invoice->getVar('currency'), str_replace('%discount', $invoice->getVar('discount'), _XPY_MF_DISCOUNT_CODE_APPLIED)));
		} else {
			$formobj['code'] = new XoopsFormText(_XPY_MF_DISCOUNT_CODE, 'code', 35, 48, '');
			$eletray['buttons'] = new XoopsFormElementTray('', '&nbsp;');
			$sformobj['buttons']['save'] = new XoopsFormButton('', 'submit', _SUBMIT, 'submit');
			$eletray['buttons']->addElement($sformobj['buttons']['save']);
			$formobj['buttons'] = $eletray['buttons'];
		}
		
		$required = array('code');
		
		foreach($formobj as $id => $obj)			
			if (in_array($id, $required))
				$sform->addElement($formobj[$id], true);			
			else
				$sform->addElement($formobj[$id], false);

		$sform->addElement(new XoopsFormHidden('iid', md5($invoice->getVar('iid').XOOPS_LICENSE_KEY)));		
		$sform->addElement(new XoopsFormHidden('op', 'discount'));	
		$sform->addElement(new XoopsFormHidden('fct', 'apply'));	
		
		return $sform->render();
		
	}
	
	function xpayment_admincreatediscounts() {
		$sform = new XoopsThemeForm(_XPY_AM_CREATE_DISCOUNT_CODES, 'create_discount', $_SERVER['PHP_SELF'], 'post');
		$formobj = array();	
		$eletray = array();
		
		$formobj['prefix'] = new XoopsFormText(_XPY_AM_PREFIX_DISCOUNT_CODE, 'prefix', 15, 25, $GLOBALS['xoopsModuleConfig']['discount_prefix']);
		$formobj['discount'] = new XoopsFormText(_XPY_AM_AMOUNT_DISCOUNT_CODE, 'discount', 15, 25, $GLOBALS['xoopsModuleConfig']['discount_percentage']);
		$formobj['redeems'] = new XoopsFormText(_XPY_AM_REDEEMS_DISCOUNT_CODE, 'redeems', 15, 25, $GLOBALS['xoopsModuleConfig']['discount_redeems']);
		$formobj['validtill'] = new XoopsFormElementTray(_XPY_AM_VALIDTILL_DISCOUNT_CODE, '<br/>');
		$formobj['validtill']->addElement(new XoopsFormDateTime('', 'validtill', 15, time() + $GLOBALS['xoopsModuleConfig']['discount_validtill']));
		$formobj['validtill']->addElement(new XoopsFormRadioYN(_XPY_AM_VALIDTILL_NEVERTIMEOUT_DISCOUNT_CODE, 'validtill_infinte', false));
		$formobj['emails'] = new XoopsFormTextArea(_XPY_AM_EMAILS_DISCOUNT_CODE, 'emails', '');
		$formobj['emails']->setDescription(_XPY_AM_EMAILS_DISCOUNT_CODE_DESC);
		$formobj['scan'] = new XoopsFormRadioYN(_XPY_AM_SCAN_DISCOUNT_CODE, 'scan', false);
		$formobj['groups'] = new XoopsFormElementTray(_XPY_AM_GROUPS_DISCOUNT_CODE, '&nbsp;');
		//$formobj['groups']->addElement(new XoopsFormRadioYN('', 'groups', false));
		$formobj['groups']->addElement(new XoopsFormSelectGroup('', 'groups[]', false, ARRAY(XOOPS_GROUP_USERS), 6, true));
		$formobj['since'] = new XoopsFormElementTray(_XPY_AM_SINCE_DISCOUNT_CODE, '&nbsp;');
		$formobj['since']->addElement(new XoopsFormRadioYN('', 'since', false));
		$formobj['since']->addElement(new XoopsFormDateTime('', 'since_datetime', 15, time()));
		$formobj['logon'] = new XoopsFormElementTray(_XPY_AM_LOGON_DISCOUNT_CODE, '&nbsp;');
		$formobj['logon']->addElement(new XoopsFormRadioYN('', 'logon', false));
		$formobj['logon']->addElement(new XoopsFormDateTime('', 'logon_datetime', 15, time()));
				
		$eletray['buttons'] = new XoopsFormElementTray('', '&nbsp;');
		$sformobj['buttons']['save'] = new XoopsFormButton('', 'submit', _SUBMIT, 'submit');
		$eletray['buttons']->addElement($sformobj['buttons']['save']);
		$formobj['buttons'] = $eletray['buttons'];
	
		$required = array('discount', 'redeems', 'prefix');
		
		foreach($formobj as $id => $obj)			
			if (in_array($id, $required))
				$sform->addElement($formobj[$id], true);			
			else
				$sform->addElement($formobj[$id], false);
		
		$limit = !empty($_REQUEST['limit'])?intval($_REQUEST['limit']):30;
		$start = !empty($_REQUEST['start'])?intval($_REQUEST['start']):0;
		$order = !empty($_REQUEST['order'])?$_REQUEST['order']:'DESC';
		$sort = !empty($_REQUEST['sort'])?$_REQUEST['sort']:'created';
		$filter = !empty($_REQUEST['filter'])?$_REQUEST['filter']:'1,1';
		$sform->addElement(new XoopsFormHidden('limit', $limit));
		$sform->addElement(new XoopsFormHidden('start', $start));
		$sform->addElement(new XoopsFormHidden('order', $order));
		$sform->addElement(new XoopsFormHidden('sort', $sort));
		$sform->addElement(new XoopsFormHidden('filter', $filter));
		$sform->addElement(new XoopsFormHidden('op', 'discounts'));	
		$sform->addElement(new XoopsFormHidden('fct', 'create'));	
		
		return $sform->render();
				
	}
?>