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
	function PaidXpaymentHook($invoice) {

		if ($invoice->getVar('iid')>0) {
			xoops_load('xoopsmailer');
			xoops_loadLanguage('main','xpayment');
			
			$xoopsMailer =& getMailer();
			$xoopsMailer->setHTML(true);
			$xoopsMailer->setTemplateDir($GLOBALS['xoops']->path('/modules/xpayment/language/'.$GLOBALS['xoopsConfig']['language'].'/mail_templates/'));
			$xoopsMailer->setTemplate('xpayment_invoice_paid.tpl');
			$xoopsMailer->setSubject(sprintf(_XPY_EMAIL_PAID_SUBJECT, $invoice->getVar('grand'), $invoice->getVar('currency'), $invoice->getVar('drawto')));
			
			$xoopsMailer = setEmailXpaymentTags($xoopsMailer, $invoice);
			$ttlgroups = setEmailXpaymentReceiever($xoopsMailer, $invoice, _XPY_ENUM_MODE_PAID);
			
			$module_handler =& xoops_gethandler('module');
			$groupperm_handler =& xoops_gethandler('groupperm');
			$xpMod = $module_handler->getByDirname('xpayment');		
			if ($groupperm_handler->checkRight('email', _XPY_ENUM_MODE_PAID, $ttlgroups, $xpMod->getVar('mid'))) 
				if (!$xoopsMailer->send())
					return false;
				else 
					return true;
		}
		return true;
	}
	
	function UnpaidXpaymentHook($invoice) {
		
		if ($invoice->getVar('iid')>0) {
			xoops_load('xoopsmailer');
			xoops_loadLanguage('main','xpayment');
			
			$xoopsMailer =& getMailer();
			$xoopsMailer->setHTML(true);
			$xoopsMailer->setTemplateDir($GLOBALS['xoops']->path('/modules/xpayment/language/'.$GLOBALS['xoopsConfig']['language'].'/mail_templates/'));
			$xoopsMailer->setTemplate('xpayment_invoice_unpaid.tpl');
			$xoopsMailer->setSubject(sprintf(_XPY_EMAIL_UNPAID_SUBJECT, $invoice->getVar('grand'), $invoice->getVar('currency'), $invoice->getVar('drawto')));

			$xoopsMailer = setEmailXpaymentTags($xoopsMailer, $invoice);
			$ttlgroups = setEmailXpaymentReceiever($xoopsMailer, $invoice, _XPY_ENUM_MODE_UNPAID);

			$module_handler =& xoops_gethandler('module');
			$groupperm_handler =& xoops_gethandler('groupperm');
			$xpMod = $module_handler->getByDirname('xpayment');		
			if ($groupperm_handler->checkRight('email', _XPY_ENUM_MODE_UNPAID, $ttlgroups, $xpMod->getVar('mid'))) 
				if (!$xoopsMailer->send())
					return false;
				else 
					return true;
		}
		return true;	
	}
	
	function CancelXpaymentHook($invoice) {
		
		if ($invoice->getVar('iid')>0) {
			xoops_load('xoopsmailer');
			xoops_loadLanguage('main','xpayment');
			
			$xoopsMailer =& getMailer();
			$xoopsMailer->setHTML(true);
			$xoopsMailer->setTemplateDir($GLOBALS['xoops']->path('/modules/xpayment/language/'.$GLOBALS['xoopsConfig']['language'].'/mail_templates/'));
			$xoopsMailer->setTemplate('xpayment_invoice_canceled.tpl');
			$xoopsMailer->setSubject(sprintf(_XPY_EMAIL_CANCELED_SUBJECT, $invoice->getVar('grand'), $invoice->getVar('currency'), $invoice->getVar('drawto')));
			
			$xoopsMailer = setEmailXpaymentTags($xoopsMailer, $invoice);
			$ttlgroups = setEmailXpaymentReceiever($xoopsMailer, $invoice, _XPY_ENUM_MODE_CANCEL);
			
			$module_handler =& xoops_gethandler('module');
			$groupperm_handler =& xoops_gethandler('groupperm');
			$xpMod = $module_handler->getByDirname('xpayment');		
			if ($groupperm_handler->checkRight('email', _XPY_ENUM_MODE_CANCEL, $ttlgroups, $xpMod->getVar('mid'))) 
				if (!$xoopsMailer->send())
					return false;
				else 
					return true;
		}
		return true;
	}

	// Remittence Invoice Plugin Functions
	function DiscountedPaidXpaymentHook($invoice) {

		if ($invoice->getVar('iid')>0) {
			xoops_load('xoopsmailer');
			xoops_loadLanguage('main','xpayment');
			
			$xoopsMailer =& getMailer();
			$xoopsMailer->setHTML(true);
			$xoopsMailer->setTemplateDir($GLOBALS['xoops']->path('/modules/xpayment/language/'.$GLOBALS['xoopsConfig']['language'].'/mail_templates/'));
			$xoopsMailer->setTemplate('xpayment_invoice_paid_discounted.tpl');
			$xoopsMailer->setSubject(sprintf(_XPY_EMAIL_PAID_DISCOUNTED_SUBJECT, $invoice->getVar('grand'), $invoice->getVar('currency'), $invoice->getVar('drawto')));
			
			$xoopsMailer = setEmailXpaymentTags($xoopsMailer, $invoice);
			$ttlgroups = setEmailXpaymentReceiever($xoopsMailer, $invoice, _XPY_ENUM_MODE_PAID+_XPY_ENUM_REMITTION_DISCOUNTED);
			
			$module_handler =& xoops_gethandler('module');
			$groupperm_handler =& xoops_gethandler('groupperm');
			$xpMod = $module_handler->getByDirname('xpayment');		
			if ($groupperm_handler->checkRight('email', _XPY_ENUM_MODE_PAID+_XPY_ENUM_REMITTION_DISCOUNTED, $ttlgroups, $xpMod->getVar('mid'))) 
				if (!$xoopsMailer->send())
					return false;
				else 
					return true;
		}
		return true;
	}

	function DiscountedUnpaidXpaymentHook($invoice) {

		if ($invoice->getVar('iid')>0) {
			xoops_load('xoopsmailer');
			xoops_loadLanguage('main','xpayment');
			
			$xoopsMailer =& getMailer();
			$xoopsMailer->setHTML(true);
			$xoopsMailer->setTemplateDir($GLOBALS['xoops']->path('/modules/xpayment/language/'.$GLOBALS['xoopsConfig']['language'].'/mail_templates/'));
			$xoopsMailer->setTemplate('xpayment_invoice_unpaid_discounted.tpl');
			$xoopsMailer->setSubject(sprintf(_XPY_EMAIL_UNPAID_DISCOUNTED_SUBJECT, $invoice->getVar('grand'), $invoice->getVar('currency'), $invoice->getVar('drawto')));
			
			$xoopsMailer = setEmailXpaymentTags($xoopsMailer, $invoice);
			$ttlgroups = setEmailXpaymentReceiever($xoopsMailer, $invoice, _XPY_ENUM_MODE_UNPAID+_XPY_ENUM_REMITTION_DISCOUNTED);
			
			$module_handler =& xoops_gethandler('module');
			$groupperm_handler =& xoops_gethandler('groupperm');
			$xpMod = $module_handler->getByDirname('xpayment');		
			if ($groupperm_handler->checkRight('email', _XPY_ENUM_MODE_UNPAID+_XPY_ENUM_REMITTION_DISCOUNTED, $ttlgroups, $xpMod->getVar('mid'))) 
				if (!$xoopsMailer->send())
					return false;
				else 
					return true;
		}
		return true;
	}
	
	function DiscountedCancelXpaymentHook($invoice) {

		if ($invoice->getVar('iid')>0) {
			xoops_load('xoopsmailer');
			xoops_loadLanguage('main','xpayment');
			
			$xoopsMailer =& getMailer();
			$xoopsMailer->setHTML(true);
			$xoopsMailer->setTemplateDir($GLOBALS['xoops']->path('/modules/xpayment/language/'.$GLOBALS['xoopsConfig']['language'].'/mail_templates/'));
			$xoopsMailer->setTemplate('xpayment_invoice_canceled_discounted.tpl');
			$xoopsMailer->setSubject(sprintf(_XPY_EMAIL_CANCELED_DISCOUNTED_SUBJECT, $invoice->getVar('grand'), $invoice->getVar('currency'), $invoice->getVar('drawto')));
			
			$xoopsMailer = setEmailXpaymentTags($xoopsMailer, $invoice);
			$ttlgroups = setEmailXpaymentReceiever($xoopsMailer, $invoice, _XPY_ENUM_MODE_CANCEL+_XPY_ENUM_REMITTION_DISCOUNTED);
			
			$module_handler =& xoops_gethandler('module');
			$groupperm_handler =& xoops_gethandler('groupperm');
			$xpMod = $module_handler->getByDirname('xpayment');		
			if ($groupperm_handler->checkRight('email', _XPY_ENUM_MODE_CANCEL+_XPY_ENUM_REMITTION_DISCOUNTED, $ttlgroups, $xpMod->getVar('mid'))) 
				if (!$xoopsMailer->send())
					return false;
				else 
					return true;
		}
		return true;
	}
	// Remittence Invoice Plugin Functions
	function NonePaidXpaymentHook($invoice) {

		if ($invoice->getVar('iid')>0) {
			xoops_load('xoopsmailer');
			xoops_loadLanguage('main','xpayment');
			
			$xoopsMailer =& getMailer();
			$xoopsMailer->setHTML(true);
			$xoopsMailer->setTemplateDir($GLOBALS['xoops']->path('/modules/xpayment/language/'.$GLOBALS['xoopsConfig']['language'].'/mail_templates/'));
			$xoopsMailer->setTemplate('xpayment_invoice_paid_none.tpl');
			$xoopsMailer->setSubject(sprintf(_XPY_EMAIL_PAID_NONE_SUBJECT, $invoice->getVar('grand'), $invoice->getVar('currency'), $invoice->getVar('drawto')));
			
			$xoopsMailer = setEmailXpaymentTags($xoopsMailer, $invoice);
			$ttlgroups = setEmailXpaymentReceiever($xoopsMailer, $invoice, _XPY_ENUM_MODE_PAID+_XPY_ENUM_REMITTION_NONE);
			
			$module_handler =& xoops_gethandler('module');
			$groupperm_handler =& xoops_gethandler('groupperm');
			$xpMod = $module_handler->getByDirname('xpayment');		
			if ($groupperm_handler->checkRight('email', _XPY_ENUM_MODE_PAID+_XPY_ENUM_REMITTION_NONE, $ttlgroups, $xpMod->getVar('mid'))) 
				if (!$xoopsMailer->send())
					return false;
				else 
					return true;
		}
		return true;
	}
	
	function NoneUnpaidXpaymentHook($invoice) {
		
		if ($invoice->getVar('iid')>0) {
			xoops_load('xoopsmailer');
			xoops_loadLanguage('main','xpayment');
			
			$xoopsMailer =& getMailer();
			$xoopsMailer->setHTML(true);
			$xoopsMailer->setTemplateDir($GLOBALS['xoops']->path('/modules/xpayment/language/'.$GLOBALS['xoopsConfig']['language'].'/mail_templates/'));
			$xoopsMailer->setTemplate('xpayment_invoice_unpaid_none.tpl');
			$xoopsMailer->setSubject(sprintf(_XPY_EMAIL_UNPAID_NONE_SUBJECT, $invoice->getVar('grand'), $invoice->getVar('currency'), $invoice->getVar('drawto')));
			
			$xoopsMailer = setEmailXpaymentTags($xoopsMailer, $invoice);
			$ttlgroups = setEmailXpaymentReceiever($xoopsMailer, $invoice, _XPY_ENUM_MODE_UNPAID+_XPY_ENUM_REMITTION_NONE);
			
			$module_handler =& xoops_gethandler('module');
			$groupperm_handler =& xoops_gethandler('groupperm');
			$xpMod = $module_handler->getByDirname('xpayment');		
			if ($groupperm_handler->checkRight('email', _XPY_ENUM_MODE_UNPAID+_XPY_ENUM_REMITTION_NONE, $ttlgroups, $xpMod->getVar('mid'))) 
				if (!$xoopsMailer->send())
					return false;
				else 
					return true;
		}
		return true;	
	}
	
	function NoneCancelXpaymentHook($invoice) {
		
		if ($invoice->getVar('iid')>0) {
			xoops_load('xoopsmailer');
			xoops_loadLanguage('main','xpayment');
			
			$xoopsMailer =& getMailer();
			$xoopsMailer->setHTML(true);
			$xoopsMailer->setTemplateDir($GLOBALS['xoops']->path('/modules/xpayment/language/'.$GLOBALS['xoopsConfig']['language'].'/mail_templates/'));
			$xoopsMailer->setTemplate('xpayment_invoice_canceled_none.tpl');
			$xoopsMailer->setSubject(sprintf(_XPY_EMAIL_CANCELED_NONE_SUBJECT, $invoice->getVar('grand'), $invoice->getVar('currency'), $invoice->getVar('drawto')));
			
			$xoopsMailer = setEmailXpaymentTags($xoopsMailer, $invoice);
			$ttlgroups = setEmailXpaymentReceiever($xoopsMailer, $invoice, _XPY_ENUM_MODE_CANCEL+_XPY_ENUM_REMITTION_NONE);
			
			$module_handler =& xoops_gethandler('module');
			$groupperm_handler =& xoops_gethandler('groupperm');
			$xpMod = $module_handler->getByDirname('xpayment');		
			if ($groupperm_handler->checkRight('email', _XPY_ENUM_MODE_CANCEL+_XPY_ENUM_REMITTION_NONE, $ttlgroups, $xpMod->getVar('mid'))) 
				if (!$xoopsMailer->send())
					return false;
				else 
					return true;		
		}
		return true;
	}
	
	function PendingPaidXpaymentHook($invoice) {

		if ($invoice->getVar('iid')>0) {
			xoops_load('xoopsmailer');
			xoops_loadLanguage('main','xpayment');
			
			$xoopsMailer =& getMailer();
			$xoopsMailer->setHTML(true);
			$xoopsMailer->setTemplateDir($GLOBALS['xoops']->path('/modules/xpayment/language/'.$GLOBALS['xoopsConfig']['language'].'/mail_templates/'));
			$xoopsMailer->setTemplate('xpayment_invoice_paid_pending.tpl');
			$xoopsMailer->setSubject(sprintf(_XPY_EMAIL_PAID_PENDING_SUBJECT, $invoice->getVar('grand'), $invoice->getVar('currency'), $invoice->getVar('drawto')));
			
			$xoopsMailer = setEmailXpaymentTags($xoopsMailer, $invoice);
			$ttlgroups = setEmailXpaymentReceiever($xoopsMailer, $invoice, _XPY_ENUM_MODE_PAID+_XPY_ENUM_REMITTION_PENDING);
			
			$module_handler =& xoops_gethandler('module');
			$groupperm_handler =& xoops_gethandler('groupperm');
			$xpMod = $module_handler->getByDirname('xpayment');		
			if ($groupperm_handler->checkRight('email', _XPY_ENUM_MODE_PAID+_XPY_ENUM_REMITTION_PENDING, $ttlgroups, $xpMod->getVar('mid'))) 
				if (!$xoopsMailer->send())
					return false;
				else 
					return true;
					
		}
		return true;
	}
	
	function PendingUnpaidXpaymentHook($invoice) {
		
		if ($invoice->getVar('iid')>0) {
			xoops_load('xoopsmailer');
			xoops_loadLanguage('main','xpayment');
			
			$xoopsMailer =& getMailer();
			$xoopsMailer->setHTML(true);
			$xoopsMailer->setTemplateDir($GLOBALS['xoops']->path('/modules/xpayment/language/'.$GLOBALS['xoopsConfig']['language'].'/mail_templates/'));
			$xoopsMailer->setTemplate('xpayment_invoice_unpaid_pending.tpl');
			$xoopsMailer->setSubject(sprintf(_XPY_EMAIL_UNPAID_PENDING_SUBJECT, $invoice->getVar('grand'), $invoice->getVar('currency'), $invoice->getVar('drawto')));
			
			$xoopsMailer = setEmailXpaymentTags($xoopsMailer, $invoice);
			$ttlgroups = setEmailXpaymentReceiever($xoopsMailer, $invoice, _XPY_ENUM_MODE_UNPAID+_XPY_ENUM_REMITTION_PENDING);
			
			$module_handler =& xoops_gethandler('module');
			$groupperm_handler =& xoops_gethandler('groupperm');
			$xpMod = $module_handler->getByDirname('xpayment');		
			if ($groupperm_handler->checkRight('email', _XPY_ENUM_MODE_UNPAID+_XPY_ENUM_REMITTION_PENDING, $ttlgroups, $xpMod->getVar('mid'))) 
				if (!$xoopsMailer->send())
					return false;
				else 
					return true;		}
		return true;	
	}
	
	function PendingCancelXpaymentHook($invoice) {
		
		if ($invoice->getVar('iid')>0) {
			xoops_load('xoopsmailer');
			xoops_loadLanguage('main','xpayment');
			
			$xoopsMailer =& getMailer();
			$xoopsMailer->setHTML(true);
			$xoopsMailer->setTemplateDir($GLOBALS['xoops']->path('/modules/xpayment/language/'.$GLOBALS['xoopsConfig']['language'].'/mail_templates/'));
			$xoopsMailer->setTemplate('xpayment_invoice_canceled_pending.tpl');
			$xoopsMailer->setSubject(sprintf(_XPY_EMAIL_CANCELED_PENDING_SUBJECT, $invoice->getVar('grand'), $invoice->getVar('currency'), $invoice->getVar('drawto')));
						
			$xoopsMailer = setEmailXpaymentTags($xoopsMailer, $invoice);
			$ttlgroups = setEmailXpaymentReceiever($xoopsMailer, $invoice, _XPY_ENUM_MODE_CANCEL+_XPY_ENUM_REMITTION_PENDING);
			
			$module_handler =& xoops_gethandler('module');
			$groupperm_handler =& xoops_gethandler('groupperm');
			$xpMod = $module_handler->getByDirname('xpayment');		
			if ($groupperm_handler->checkRight('email', _XPY_ENUM_MODE_CANCEL+_XPY_ENUM_REMITTION_PENDING, $ttlgroups, $xpMod->getVar('mid'))) 
				if (!$xoopsMailer->send())
					return false;
				else 
					return true;
			
		}
		return true;
	}

	function NoticePaidXpaymentHook($invoice) {

		if ($invoice->getVar('iid')>0) {
			xoops_load('xoopsmailer');
			xoops_loadLanguage('main','xpayment');
			
			$xoopsMailer =& getMailer();
			$xoopsMailer->setHTML(true);
			$xoopsMailer->setTemplateDir($GLOBALS['xoops']->path('/modules/xpayment/language/'.$GLOBALS['xoopsConfig']['language'].'/mail_templates/'));
			$xoopsMailer->setTemplate('xpayment_invoice_paid_notice.tpl');
			$xoopsMailer->setSubject(sprintf(_XPY_EMAIL_PAID_NOTICE_SUBJECT, $invoice->getVar('grand'), $invoice->getVar('currency'), $invoice->getVar('drawto')));
			
			$xoopsMailer = setEmailXpaymentTags($xoopsMailer, $invoice);
			$ttlgroups = setEmailXpaymentReceiever($xoopsMailer, $invoice, _XPY_ENUM_MODE_PAID+_XPY_ENUM_REMITTION_NOTICE);
			
			$module_handler =& xoops_gethandler('module');
			$groupperm_handler =& xoops_gethandler('groupperm');
			$xpMod = $module_handler->getByDirname('xpayment');		
			if ($groupperm_handler->checkRight('email', _XPY_ENUM_MODE_PAID+_XPY_ENUM_REMITTION_NOTICE, $ttlgroups, $xpMod->getVar('mid'))) 
				if (!$xoopsMailer->send())
					return false;
				else 
					return true;
			
		}
		return true;
	}
	
	function NoticeUnpaidXpaymentHook($invoice) {
		
		if ($invoice->getVar('iid')>0) {
			xoops_load('xoopsmailer');
			xoops_loadLanguage('main','xpayment');
			
			$xoopsMailer =& getMailer();
			$xoopsMailer->setHTML(true);
			$xoopsMailer->setTemplateDir($GLOBALS['xoops']->path('/modules/xpayment/language/'.$GLOBALS['xoopsConfig']['language'].'/mail_templates/'));
			$xoopsMailer->setTemplate('xpayment_invoice_unpaid_notice.tpl');
			$xoopsMailer->setSubject(sprintf(_XPY_EMAIL_UNPAID_NOTICE_SUBJECT, $invoice->getVar('grand'), $invoice->getVar('currency'), $invoice->getVar('drawto')));
			
			$xoopsMailer = setEmailXpaymentTags($xoopsMailer, $invoice);
			$ttlgroups = setEmailXpaymentReceiever($xoopsMailer, $invoice, _XPY_ENUM_MODE_UNPAID+_XPY_ENUM_REMITTION_NOTICE);
			
			$module_handler =& xoops_gethandler('module');
			$groupperm_handler =& xoops_gethandler('groupperm');
			$xpMod = $module_handler->getByDirname('xpayment');		
			if ($groupperm_handler->checkRight('email', _XPY_ENUM_MODE_UNPAID+_XPY_ENUM_REMITTION_NOTICE, $ttlgroups, $xpMod->getVar('mid'))) 
				if (!$xoopsMailer->send())
					return false;
				else 
					return true;
			
		}
		return true;	
	}
	
	function NoticeCancelXpaymentHook($invoice) {
		
		if ($invoice->getVar('iid')>0) {
			xoops_load('xoopsmailer');
			xoops_loadLanguage('main','xpayment');
			
			$xoopsMailer =& getMailer();
			$xoopsMailer->setHTML(true);
			$xoopsMailer->setTemplateDir($GLOBALS['xoops']->path('/modules/xpayment/language/'.$GLOBALS['xoopsConfig']['language'].'/mail_templates/'));
			$xoopsMailer->setTemplate('xpayment_invoice_canceled_notice.tpl');
			$xoopsMailer->setSubject(sprintf(_XPY_EMAIL_CANCELED_NOTICE_SUBJECT, $invoice->getVar('grand'), $invoice->getVar('currency'), $invoice->getVar('drawto')));
			
			$xoopsMailer = setEmailXpaymentTags($xoopsMailer, $invoice);
			$ttlgroups = setEmailXpaymentReceiever($xoopsMailer, $invoice, _XPY_ENUM_MODE_CANCEL+_XPY_ENUM_REMITTION_NOTICE);
			
			$module_handler =& xoops_gethandler('module');
			$groupperm_handler =& xoops_gethandler('groupperm');
			$xpMod = $module_handler->getByDirname('xpayment');		
			if ($groupperm_handler->checkRight('email', _XPY_ENUM_MODE_CANCEL+_XPY_ENUM_REMITTION_NOTICE, $ttlgroups, $xpMod->getVar('mid'))) 
				if (!$xoopsMailer->send())
					return false;
				else 
					return true;
			
		}
		return true;
	}
	
	function CollectPaidXpaymentHook($invoice) {

		if ($invoice->getVar('iid')>0) {
			xoops_load('xoopsmailer');
			xoops_loadLanguage('main','xpayment');
			
			$xoopsMailer =& getMailer();
			$xoopsMailer->setHTML(true);
			$xoopsMailer->setTemplateDir($GLOBALS['xoops']->path('/modules/xpayment/language/'.$GLOBALS['xoopsConfig']['language'].'/mail_templates/'));
			$xoopsMailer->setTemplate('xpayment_invoice_paid_collect.tpl');
			$xoopsMailer->setSubject(sprintf(_XPY_EMAIL_PAID_COLLECT_SUBJECT, $invoice->getVar('grand'), $invoice->getVar('currency'), $invoice->getVar('drawto')));
			
			$xoopsMailer = setEmailXpaymentTags($xoopsMailer, $invoice);
			$ttlgroups = setEmailXpaymentReceiever($xoopsMailer, $invoice, _XPY_ENUM_MODE_PAID+_XPY_ENUM_REMITTION_COLLECT);
			
			$module_handler =& xoops_gethandler('module');
			$groupperm_handler =& xoops_gethandler('groupperm');
			$xpMod = $module_handler->getByDirname('xpayment');		
			if ($groupperm_handler->checkRight('email', _XPY_ENUM_MODE_PAID+_XPY_ENUM_REMITTION_COLLECT, $ttlgroups, $xpMod->getVar('mid'))) 
				if (!$xoopsMailer->send())
					return false;
				else 
					return true;
		}
		return true;
	}
	
	function CollectUnpaidXpaymentHook($invoice) {
		
		if ($invoice->getVar('iid')>0) {
			xoops_load('xoopsmailer');
			xoops_loadLanguage('main','xpayment');
			
			$xoopsMailer =& getMailer();
			$xoopsMailer->setHTML(true);
			$xoopsMailer->setTemplateDir($GLOBALS['xoops']->path('/modules/xpayment/language/'.$GLOBALS['xoopsConfig']['language'].'/mail_templates/'));
			$xoopsMailer->setTemplate('xpayment_invoice_unpaid_collect.tpl');
			$xoopsMailer->setSubject(sprintf(_XPY_EMAIL_UNPAID_COLLECT_SUBJECT, $invoice->getVar('grand'), $invoice->getVar('currency'), $invoice->getVar('drawto')));
			
			$xoopsMailer = setEmailXpaymentTags($xoopsMailer, $invoice);
			$ttlgroups = setEmailXpaymentReceiever($xoopsMailer, $invoice, _XPY_ENUM_MODE_UNPAID+_XPY_ENUM_REMITTION_COLLECT);
			
			$module_handler =& xoops_gethandler('module');
			$groupperm_handler =& xoops_gethandler('groupperm');
			$xpMod = $module_handler->getByDirname('xpayment');		
			if ($groupperm_handler->checkRight('email', _XPY_ENUM_MODE_UNPAID+_XPY_ENUM_REMITTION_COLLECT, $ttlgroups, $xpMod->getVar('mid'))) 
				if (!$xoopsMailer->send())
					return false;
				else 
					return true;
		}
		return true;	
	}
	
	function CollectCancelXpaymentHook($invoice) {
		
		if ($invoice->getVar('iid')>0) {
			xoops_load('xoopsmailer');
			xoops_loadLanguage('main','xpayment');
			
			$xoopsMailer =& getMailer();
			$xoopsMailer->setHTML(true);
			$xoopsMailer->setTemplateDir($GLOBALS['xoops']->path('/modules/xpayment/language/'.$GLOBALS['xoopsConfig']['language'].'/mail_templates/'));
			$xoopsMailer->setTemplate('xpayment_invoice_canceled_collect.tpl');
			$xoopsMailer->setSubject(sprintf(_XPY_EMAIL_CANCELED_COLLECT_SUBJECT, $invoice->getVar('grand'), $invoice->getVar('currency'), $invoice->getVar('drawto')));
			
			$xoopsMailer = setEmailXpaymentTags($xoopsMailer, $invoice);
			$ttlgroups = setEmailXpaymentReceiever($xoopsMailer, $invoice, _XPY_ENUM_MODE_CANCEL+_XPY_ENUM_REMITTION_COLLECT);
			
			$module_handler =& xoops_gethandler('module');
			$groupperm_handler =& xoops_gethandler('groupperm');
			$xpMod = $module_handler->getByDirname('xpayment');		
			if ($groupperm_handler->checkRight('email', _XPY_ENUM_MODE_CANCEL+_XPY_ENUM_REMITTION_COLLECT, $ttlgroups, $xpMod->getVar('mid'))) 
				if (!$xoopsMailer->send())
					return false;
				else 
					return true;
		}
		return true;
	}
	
	function FraudPaidXpaymentHook($invoice) {

		if ($invoice->getVar('iid')>0) {
			xoops_load('xoopsmailer');
			xoops_loadLanguage('main','xpayment');
			
			$xoopsMailer =& getMailer();
			$xoopsMailer->setHTML(true);
			$xoopsMailer->setTemplateDir($GLOBALS['xoops']->path('/modules/xpayment/language/'.$GLOBALS['xoopsConfig']['language'].'/mail_templates/'));
			$xoopsMailer->setTemplate('xpayment_invoice_paid_fraud.tpl');
			$xoopsMailer->setSubject(sprintf(_XPY_EMAIL_PAID_FRAUD_SUBJECT, $invoice->getVar('grand'), $invoice->getVar('currency'), $invoice->getVar('drawto')));
			
			$xoopsMailer = setEmailXpaymentTags($xoopsMailer, $invoice);
			$ttlgroups = setEmailXpaymentReceiever($xoopsMailer, $invoice, _XPY_ENUM_MODE_PAID+_XPY_ENUM_REMITTION_FRAUD);
			
			$module_handler =& xoops_gethandler('module');
			$groupperm_handler =& xoops_gethandler('groupperm');
			$xpMod = $module_handler->getByDirname('xpayment');		
			if ($groupperm_handler->checkRight('email', _XPY_ENUM_MODE_PAID+_XPY_ENUM_REMITTION_FRAUD, $ttlgroups, $xpMod->getVar('mid'))) 
				if (!$xoopsMailer->send())
					return false;
				else 
					return true;
			
		}
		return true;
	}
	
	function FraudUnpaidXpaymentHook($invoice) {
		
		if ($invoice->getVar('iid')>0) {
			xoops_load('xoopsmailer');
			xoops_loadLanguage('main','xpayment');
			
			$xoopsMailer =& getMailer();
			$xoopsMailer->setHTML(true);
			$xoopsMailer->setTemplateDir($GLOBALS['xoops']->path('/modules/xpayment/language/'.$GLOBALS['xoopsConfig']['language'].'/mail_templates/'));
			$xoopsMailer->setTemplate('xpayment_invoice_unpaid_fraud.tpl');
			$xoopsMailer->setSubject(sprintf(_XPY_EMAIL_UNPAID_FRAUD_SUBJECT, $invoice->getVar('grand'), $invoice->getVar('currency'), $invoice->getVar('drawto')));
			
			$xoopsMailer = setEmailXpaymentTags($xoopsMailer, $invoice);
			$ttlgroups = setEmailXpaymentReceiever($xoopsMailer, $invoice, _XPY_ENUM_MODE_UNPAID+_XPY_ENUM_REMITTION_FRAUD);
			
			$module_handler =& xoops_gethandler('module');
			$groupperm_handler =& xoops_gethandler('groupperm');
			$xpMod = $module_handler->getByDirname('xpayment');		
			if ($groupperm_handler->checkRight('email', _XPY_ENUM_MODE_UNPAID+_XPY_ENUM_REMITTION_FRAUD, $ttlgroups, $xpMod->getVar('mid'))) 
				if (!$xoopsMailer->send())
					return false;
				else 
					return true;
		}
		return true;	
	}
	
	function FraudCancelXpaymentHook($invoice) {
		
		if ($invoice->getVar('iid')>0) {
			xoops_load('xoopsmailer');
			xoops_loadLanguage('main','xpayment');
			
			$xoopsMailer =& getMailer();
			$xoopsMailer->setHTML(true);
			$xoopsMailer->setTemplateDir($GLOBALS['xoops']->path('/modules/xpayment/language/'.$GLOBALS['xoopsConfig']['language'].'/mail_templates/'));
			$xoopsMailer->setTemplate('xpayment_invoice_canceled_fraud.tpl');
			$xoopsMailer->setSubject(sprintf(_XPY_EMAIL_CANCELED_FRAUD_SUBJECT, $invoice->getVar('grand'), $invoice->getVar('currency'), $invoice->getVar('drawto')));
			
			$xoopsMailer = setEmailXpaymentTags($xoopsMailer, $invoice);
			$ttlgroups = setEmailXpaymentReceiever($xoopsMailer, $invoice, _XPY_ENUM_MODE_CANCEL+_XPY_ENUM_REMITTION_FRAUD);
			
			$module_handler =& xoops_gethandler('module');
			$groupperm_handler =& xoops_gethandler('groupperm');
			$xpMod = $module_handler->getByDirname('xpayment');		
			if ($groupperm_handler->checkRight('email', _XPY_ENUM_MODE_CANCEL+_XPY_ENUM_REMITTION_FRAUD, $ttlgroups, $xpMod->getVar('mid'))) 
				if (!$xoopsMailer->send())
					return false;
				else 
					return true;
		}
		return true;
	}

	function SettledPaidXpaymentHook($invoice) {

		if ($invoice->getVar('iid')>0) {
			xoops_load('xoopsmailer');
			xoops_loadLanguage('main','xpayment');
			
			$xoopsMailer =& getMailer();
			$xoopsMailer->setHTML(true);
			$xoopsMailer->setTemplateDir($GLOBALS['xoops']->path('/modules/xpayment/language/'.$GLOBALS['xoopsConfig']['language'].'/mail_templates/'));
			$xoopsMailer->setTemplate('xpayment_invoice_paid_settled.tpl');
			$xoopsMailer->setSubject(sprintf(_XPY_EMAIL_PAID_SETTLED_SUBJECT, $invoice->getVar('grand'), $invoice->getVar('currency'), $invoice->getVar('drawto')));
			
			$xoopsMailer = setEmailXpaymentTags($xoopsMailer, $invoice);
			$ttlgroups = setEmailXpaymentReceiever($xoopsMailer, $invoice, _XPY_ENUM_MODE_PAID+_XPY_ENUM_REMITTION_SETTLED);
			
			$module_handler =& xoops_gethandler('module');
			$groupperm_handler =& xoops_gethandler('groupperm');
			$xpMod = $module_handler->getByDirname('xpayment');		
			if ($groupperm_handler->checkRight('email', _XPY_ENUM_MODE_PAID+_XPY_ENUM_REMITTION_SETTLED, $ttlgroups, $xpMod->getVar('mid'))) 
				if (!$xoopsMailer->send())
					return false;
				else 
					return true;
		}
		return true;
	}
	
	function SettledUnpaidXpaymentHook($invoice) {
		
		if ($invoice->getVar('iid')>0) {
			xoops_load('xoopsmailer');
			xoops_loadLanguage('main','xpayment');
			
			$xoopsMailer =& getMailer();
			$xoopsMailer->setHTML(true);
			$xoopsMailer->setTemplateDir($GLOBALS['xoops']->path('/modules/xpayment/language/'.$GLOBALS['xoopsConfig']['language'].'/mail_templates/'));
			$xoopsMailer->setTemplate('xpayment_invoice_unpaid_settled.tpl');
			$xoopsMailer->setSubject(sprintf(_XPY_EMAIL_UNPAID_SETTLED_SUBJECT, $invoice->getVar('grand'), $invoice->getVar('currency'), $invoice->getVar('drawto')));
			
			$xoopsMailer = setEmailXpaymentTags($xoopsMailer, $invoice);
			$ttlgroups = setEmailXpaymentReceiever($xoopsMailer, $invoice, _XPY_ENUM_MODE_UNPAID+_XPY_ENUM_REMITTION_SETTLED);
			
			$module_handler =& xoops_gethandler('module');
			$groupperm_handler =& xoops_gethandler('groupperm');
			$xpMod = $module_handler->getByDirname('xpayment');		
			if ($groupperm_handler->checkRight('email', _XPY_ENUM_MODE_UNPAID+_XPY_ENUM_REMITTION_SETTLED, $ttlgroups, $xpMod->getVar('mid'))) 
				if (!$xoopsMailer->send())
					return false;
				else 
					return true;
		}
		return true;	
	}
	
	function SettledCancelXpaymentHook($invoice) {
		
		if ($invoice->getVar('iid')>0) {
			xoops_load('xoopsmailer');
			xoops_loadLanguage('main','xpayment');
			
			$xoopsMailer =& getMailer();
			$xoopsMailer->setHTML(true);
			$xoopsMailer->setTemplateDir($GLOBALS['xoops']->path('/modules/xpayment/language/'.$GLOBALS['xoopsConfig']['language'].'/mail_templates/'));
			$xoopsMailer->setTemplate('xpayment_invoice_canceled_settled.tpl');
			$xoopsMailer->setSubject(sprintf(_XPY_EMAIL_CANCELED_SETTLED_SUBJECT, $invoice->getVar('grand'), $invoice->getVar('currency'), $invoice->getVar('drawto')));
			
			$xoopsMailer = setEmailXpaymentTags($xoopsMailer, $invoice);
			$ttlgroups = setEmailXpaymentReceiever($xoopsMailer, $invoice, _XPY_ENUM_MODE_CANCEL+_XPY_ENUM_REMITTION_SETTLED);
			
			$module_handler =& xoops_gethandler('module');
			$groupperm_handler =& xoops_gethandler('groupperm');
			$xpMod = $module_handler->getByDirname('xpayment');		
			if ($groupperm_handler->checkRight('email', _XPY_ENUM_MODE_CANCEL+_XPY_ENUM_REMITTION_SETTLED, $ttlgroups, $xpMod->getVar('mid'))) 
				if (!$xoopsMailer->send())
					return false;
				else 
					return true;
		}
		return true;
	}
	
	// Warehouse/PLC Logic/Pick & Pack Scripts - Item by Item - Invoice Plugin Functions
	function PurchasedPaidXpaymentItemHook($item, $invoice) {

		if ($invoice->getVar('iid')>0) {
			xoops_load('xoopsmailer');
			xoops_loadLanguage('main','xpayment');
			
			$xoopsMailer =& getMailer();
			$xoopsMailer->setHTML(true);
			$xoopsMailer->setTemplateDir($GLOBALS['xoops']->path('/modules/xpayment/language/'.$GLOBALS['xoopsConfig']['language'].'/mail_templates/'));
			$xoopsMailer->setTemplate('xpayment_invoice_paid_purchased.tpl');
			$xoopsMailer->setSubject(sprintf(_XPY_EMAIL_PAID_PURCHASED_SUBJECT, $invoice->getVar('grand'), $invoice->getVar('currency'), $invoice->getVar('drawto')));
			
			$xoopsMailer = setEmailXpaymentTags($xoopsMailer, $invoice, $item);
			$ttlgroups = setEmailXpaymentReceiever($xoopsMailer, $invoice, _XPY_ENUM_MODE_PAID+_XPY_ENUM_ITEMMODE_PURCHASED);
			
			$module_handler =& xoops_gethandler('module');
			$groupperm_handler =& xoops_gethandler('groupperm');
			$xpMod = $module_handler->getByDirname('xpayment');		
			if ($groupperm_handler->checkRight('email', _XPY_ENUM_MODE_PAID+_XPY_ENUM_ITEMMODE_PURCHASED, $ttlgroups, $xpMod->getVar('mid'))) 
				if (!$xoopsMailer->send())
					return false;
				else 
					return true;
		}
		return true;
	}
	
	function PurchasedUnpaidXpaymentItemHook($item, $invoice) {
		
		if ($invoice->getVar('iid')>0) {
			xoops_load('xoopsmailer');
			xoops_loadLanguage('main','xpayment');
			
			$xoopsMailer =& getMailer();
			$xoopsMailer->setHTML(true);
			$xoopsMailer->setTemplateDir($GLOBALS['xoops']->path('/modules/xpayment/language/'.$GLOBALS['xoopsConfig']['language'].'/mail_templates/'));
			$xoopsMailer->setTemplate('xpayment_invoice_unpaid_purchased.tpl');
			$xoopsMailer->setSubject(sprintf(_XPY_EMAIL_UNPAID_PURCHASED_SUBJECT, $invoice->getVar('grand'), $invoice->getVar('currency'), $invoice->getVar('drawto')));
			
			$xoopsMailer = setEmailXpaymentTags($xoopsMailer, $invoice, $item);
			$ttlgroups = setEmailXpaymentReceiever($xoopsMailer, $invoice, _XPY_ENUM_MODE_UNPAID+_XPY_ENUM_ITEMMODE_PURCHASED);
			
			$module_handler =& xoops_gethandler('module');
			$groupperm_handler =& xoops_gethandler('groupperm');
			$xpMod = $module_handler->getByDirname('xpayment');		
			if ($groupperm_handler->checkRight('email', _XPY_ENUM_MODE_UNPAID+_XPY_ENUM_ITEMMODE_PURCHASED, $ttlgroups, $xpMod->getVar('mid'))) 
				if (!$xoopsMailer->send())
					return false;
				else 
					return true;
		}
		return true;	
	}
	
	function PurchasedCancelXpaymentItemHook($item, $invoice) {
		
		if ($invoice->getVar('iid')>0) {
			xoops_load('xoopsmailer');
			xoops_loadLanguage('main','xpayment');
			
			$xoopsMailer =& getMailer();
			$xoopsMailer->setHTML(true);
			$xoopsMailer->setTemplateDir($GLOBALS['xoops']->path('/modules/xpayment/language/'.$GLOBALS['xoopsConfig']['language'].'/mail_templates/'));
			$xoopsMailer->setTemplate('xpayment_invoice_canceled_purchased.tpl');
			$xoopsMailer->setSubject(sprintf(_XPY_EMAIL_CANCELED_PURCHASED_SUBJECT, $invoice->getVar('grand'), $invoice->getVar('currency'), $invoice->getVar('drawto')));
			
			$xoopsMailer = setEmailXpaymentTags($xoopsMailer, $invoice, $item);
			$ttlgroups = setEmailXpaymentReceiever($xoopsMailer, $invoice, _XPY_ENUM_MODE_CANCEL+_XPY_ENUM_ITEMMODE_PURCHASED);
			
			$module_handler =& xoops_gethandler('module');
			$groupperm_handler =& xoops_gethandler('groupperm');
			$xpMod = $module_handler->getByDirname('xpayment');		
			if ($groupperm_handler->checkRight('email', _XPY_ENUM_MODE_CANCEL+_XPY_ENUM_ITEMMODE_PURCHASED, $ttlgroups, $xpMod->getVar('mid'))) 
				if (!$xoopsMailer->send())
					return false;
				else 
					return true;
		}
		return true;
	}
	
	function RefundedPaidXpaymentItemHook($item, $invoice) {

		if ($invoice->getVar('iid')>0) {
			xoops_load('xoopsmailer');
			xoops_loadLanguage('main','xpayment');
			
			$xoopsMailer =& getMailer();
			$xoopsMailer->setHTML(true);
			$xoopsMailer->setTemplateDir($GLOBALS['xoops']->path('/modules/xpayment/language/'.$GLOBALS['xoopsConfig']['language'].'/mail_templates/'));
			$xoopsMailer->setTemplate('xpayment_invoice_paid_refunded.tpl');
			$xoopsMailer->setSubject(sprintf(_XPY_EMAIL_PAID_REFUNDED_SUBJECT, $invoice->getVar('grand'), $invoice->getVar('currency'), $invoice->getVar('drawto')));
			
			$xoopsMailer = setEmailXpaymentTags($xoopsMailer, $invoice, $item);
			$ttlgroups = setEmailXpaymentReceiever($xoopsMailer, $invoice, _XPY_ENUM_MODE_PAID+_XPY_ENUM_ITEMMODE_REFUNDED);
			
			$module_handler =& xoops_gethandler('module');
			$groupperm_handler =& xoops_gethandler('groupperm');
			$xpMod = $module_handler->getByDirname('xpayment');		
			if ($groupperm_handler->checkRight('email', _XPY_ENUM_MODE_PAID+_XPY_ENUM_ITEMMODE_REFUNDED, $ttlgroups, $xpMod->getVar('mid'))) 
				if (!$xoopsMailer->send())
					return false;
				else 
					return true;
		}
		return true;
	}
	
	function RefundedUnpaidXpaymentItemHook($item, $invoice) {
		
		if ($invoice->getVar('iid')>0) {
			xoops_load('xoopsmailer');
			xoops_loadLanguage('main','xpayment');
			
			$xoopsMailer =& getMailer();
			$xoopsMailer->setHTML(true);
			$xoopsMailer->setTemplateDir($GLOBALS['xoops']->path('/modules/xpayment/language/'.$GLOBALS['xoopsConfig']['language'].'/mail_templates/'));
			$xoopsMailer->setTemplate('xpayment_invoice_unpaid_refunded.tpl');
			$xoopsMailer->setSubject(sprintf(_XPY_EMAIL_UNPAID_REFUNDED_SUBJECT, $invoice->getVar('grand'), $invoice->getVar('currency'), $invoice->getVar('drawto')));
			
			$xoopsMailer = setEmailXpaymentTags($xoopsMailer, $invoice, $item);
			$ttlgroups = setEmailXpaymentReceiever($xoopsMailer, $invoice, _XPY_ENUM_MODE_UNPAID+_XPY_ENUM_ITEMMODE_REFUNDED);
			
			$module_handler =& xoops_gethandler('module');
			$groupperm_handler =& xoops_gethandler('groupperm');
			$xpMod = $module_handler->getByDirname('xpayment');		
			if ($groupperm_handler->checkRight('email', _XPY_ENUM_MODE_UNPAID+_XPY_ENUM_ITEMMODE_REFUNDED, $ttlgroups, $xpMod->getVar('mid'))) 
				if (!$xoopsMailer->send())
					return false;
				else 
					return true;
		}
		return true;	
	}
	
	function RefundedCancelXpaymentItemHook($item, $invoice) {
		
		if ($invoice->getVar('iid')>0) {
			xoops_load('xoopsmailer');
			xoops_loadLanguage('main','xpayment');
			
			$xoopsMailer =& getMailer();
			$xoopsMailer->setHTML(true);
			$xoopsMailer->setTemplateDir($GLOBALS['xoops']->path('/modules/xpayment/language/'.$GLOBALS['xoopsConfig']['language'].'/mail_templates/'));
			$xoopsMailer->setTemplate('xpayment_invoice_canceled_refunded.tpl');
			$xoopsMailer->setSubject(sprintf(_XPY_EMAIL_CANCELED_REFUNDED_SUBJECT, $invoice->getVar('grand'), $invoice->getVar('currency'), $invoice->getVar('drawto')));
			
			$xoopsMailer = setEmailXpaymentTags($xoopsMailer, $invoice, $item);
			$ttlgroups = setEmailXpaymentReceiever($xoopsMailer, $invoice, _XPY_ENUM_MODE_CANCEL+_XPY_ENUM_ITEMMODE_REFUNDED);
			
			$module_handler =& xoops_gethandler('module');
			$groupperm_handler =& xoops_gethandler('groupperm');
			$xpMod = $module_handler->getByDirname('xpayment');		
			if ($groupperm_handler->checkRight('email', _XPY_ENUM_MODE_CANCEL+_XPY_ENUM_ITEMMODE_REFUNDED, $ttlgroups, $xpMod->getVar('mid'))) 
				if (!$xoopsMailer->send())
					return false;
				else 
					return true;
		}
		return true;
	}
	
	function UndeliveredPaidXpaymentItemHook($items, $invoice) {

		if ($invoice->getVar('iid')>0) {
			xoops_load('xoopsmailer');
			xoops_loadLanguage('main','xpayment');
			
			$xoopsMailer =& getMailer();
			$xoopsMailer->setHTML(true);
			$xoopsMailer->setTemplateDir($GLOBALS['xoops']->path('/modules/xpayment/language/'.$GLOBALS['xoopsConfig']['language'].'/mail_templates/'));
			$xoopsMailer->setTemplate('xpayment_invoice_paid_undelivered.tpl');
			$xoopsMailer->setSubject(sprintf(_XPY_EMAIL_PAID_UNDELIVERED_SUBJECT, $invoice->getVar('grand'), $invoice->getVar('currency'), $invoice->getVar('drawto')));
			
			$xoopsMailer = setEmailXpaymentTags($xoopsMailer, $invoice, $item);
			$ttlgroups = setEmailXpaymentReceiever($xoopsMailer, $invoice, _XPY_ENUM_MODE_PAID+_XPY_ENUM_ITEMMODE_UNDELIVERED);
			
			$module_handler =& xoops_gethandler('module');
			$groupperm_handler =& xoops_gethandler('groupperm');
			$xpMod = $module_handler->getByDirname('xpayment');		
			if ($groupperm_handler->checkRight('email', _XPY_ENUM_MODE_PAID+_XPY_ENUM_ITEMMODE_UNDELIVERED, $ttlgroups, $xpMod->getVar('mid'))) 
				if (!$xoopsMailer->send())
					return false;
				else 
					return true;
		}
		return true;
	}
	
	function UndeliveredUnpaidXpaymentItemHook($item, $invoice) {
		
		if ($invoice->getVar('iid')>0) {
			xoops_load('xoopsmailer');
			xoops_loadLanguage('main','xpayment');
			
			$xoopsMailer =& getMailer();
			$xoopsMailer->setHTML(true);
			$xoopsMailer->setTemplateDir($GLOBALS['xoops']->path('/modules/xpayment/language/'.$GLOBALS['xoopsConfig']['language'].'/mail_templates/'));
			$xoopsMailer->setTemplate('xpayment_invoice_unpaid_undelivered.tpl');
			$xoopsMailer->setSubject(sprintf(_XPY_EMAIL_UNPAID_UNDELIVERED_SUBJECT, $invoice->getVar('grand'), $invoice->getVar('currency'), $invoice->getVar('drawto')));
			
			$xoopsMailer = setEmailXpaymentTags($xoopsMailer, $invoice, $item);
			$ttlgroups = setEmailXpaymentReceiever($xoopsMailer, $invoice, _XPY_ENUM_MODE_UNPAID+_XPY_ENUM_ITEMMODE_UNDELIVERED);
			
			$module_handler =& xoops_gethandler('module');
			$groupperm_handler =& xoops_gethandler('groupperm');
			$xpMod = $module_handler->getByDirname('xpayment');		
			if ($groupperm_handler->checkRight('email', _XPY_ENUM_MODE_UNPAID+_XPY_ENUM_ITEMMODE_UNDELIVERED, $ttlgroups, $xpMod->getVar('mid'))) 
				if (!$xoopsMailer->send())
					return false;
				else 
					return true;
		}
		return true;	
	}
	
	function UndeliveredCancelXpaymentItemHook($item, $invoice) {
		
		if ($invoice->getVar('iid')>0) {
			xoops_load('xoopsmailer');
			xoops_loadLanguage('main','xpayment');
			
			$xoopsMailer =& getMailer();
			$xoopsMailer->setHTML(true);
			$xoopsMailer->setTemplateDir($GLOBALS['xoops']->path('/modules/xpayment/language/'.$GLOBALS['xoopsConfig']['language'].'/mail_templates/'));
			$xoopsMailer->setTemplate('xpayment_invoice_canceled_undelivered.tpl');
			$xoopsMailer->setSubject(sprintf(_XPY_EMAIL_CANCELED_UNDELIVERED_SUBJECT, $invoice->getVar('grand'), $invoice->getVar('currency'), $invoice->getVar('drawto')));
			
			$xoopsMailer = setEmailXpaymentTags($xoopsMailer, $invoice, $item);
			$ttlgroups = setEmailXpaymentReceiever($xoopsMailer, $invoice, _XPY_ENUM_MODE_CANCEL+_XPY_ENUM_ITEMMODE_UNDELIVERED);
			
			$module_handler =& xoops_gethandler('module');
			$groupperm_handler =& xoops_gethandler('groupperm');
			$xpMod = $module_handler->getByDirname('xpayment');		
			if ($groupperm_handler->checkRight('email', _XPY_ENUM_MODE_CANCEL+_XPY_ENUM_ITEMMODE_UNDELIVERED, $ttlgroups, $xpMod->getVar('mid'))) 
				if (!$xoopsMailer->send())
					return false;
				else 
					return true;
		}
		return true;
	}
	
	function DamagedPaidXpaymentItemHook($item, $invoice) {

		if ($invoice->getVar('iid')>0) {
			xoops_load('xoopsmailer');
			xoops_loadLanguage('main','xpayment');
			
			$xoopsMailer =& getMailer();
			$xoopsMailer->setHTML(true);
			$xoopsMailer->setTemplateDir($GLOBALS['xoops']->path('/modules/xpayment/language/'.$GLOBALS['xoopsConfig']['language'].'/mail_templates/'));
			$xoopsMailer->setTemplate('xpayment_invoice_paid_damaged.tpl');
			$xoopsMailer->setSubject(sprintf(_XPY_EMAIL_PAID_DAMAGED_SUBJECT, $invoice->getVar('grand'), $invoice->getVar('currency'), $invoice->getVar('drawto')));
			
			$xoopsMailer = setEmailXpaymentTags($xoopsMailer, $invoice, $item);
			$ttlgroups = setEmailXpaymentReceiever($xoopsMailer, $invoice, _XPY_ENUM_MODE_PAID+_XPY_ENUM_ITEMMODE_DAMAGED);
			
			$module_handler =& xoops_gethandler('module');
			$groupperm_handler =& xoops_gethandler('groupperm');
			$xpMod = $module_handler->getByDirname('xpayment');		
			if ($groupperm_handler->checkRight('email', _XPY_ENUM_MODE_PAID+_XPY_ENUM_ITEMMODE_DAMAGED, $ttlgroups, $xpMod->getVar('mid'))) 
				if (!$xoopsMailer->send())
					return false;
				else 
					return true;
		}
		return true;
	}
	
	function DamagedUnpaidXpaymentItemHook($item, $invoice) {
		
		if ($invoice->getVar('iid')>0) {
			xoops_load('xoopsmailer');
			xoops_loadLanguage('main','xpayment');
			
			$xoopsMailer =& getMailer();
			$xoopsMailer->setHTML(true);
			$xoopsMailer->setTemplateDir($GLOBALS['xoops']->path('/modules/xpayment/language/'.$GLOBALS['xoopsConfig']['language'].'/mail_templates/'));
			$xoopsMailer->setTemplate('xpayment_invoice_unpaid_damaged.tpl');
			$xoopsMailer->setSubject(sprintf(_XPY_EMAIL_UNPAID_DAMAGED_SUBJECT, $invoice->getVar('grand'), $invoice->getVar('currency'), $invoice->getVar('drawto')));
			
			$xoopsMailer = setEmailXpaymentTags($xoopsMailer, $invoice, $item);
			$ttlgroups = setEmailXpaymentReceiever($xoopsMailer, $invoice, _XPY_ENUM_MODE_UNPAID+_XPY_ENUM_ITEMMODE_DAMAGED);
			
			$module_handler =& xoops_gethandler('module');
			$groupperm_handler =& xoops_gethandler('groupperm');
			$xpMod = $module_handler->getByDirname('xpayment');		
			if ($groupperm_handler->checkRight('email', _XPY_ENUM_MODE_UNPAID+_XPY_ENUM_ITEMMODE_DAMAGED, $ttlgroups, $xpMod->getVar('mid'))) 
				if (!$xoopsMailer->send())
					return false;
				else 
					return true;
		}
		return true;	
	}
	
	function DamagedCancelXpaymentItemHook($item, $invoice) {
		
		if ($invoice->getVar('iid')>0) {
			xoops_load('xoopsmailer');
			xoops_loadLanguage('main','xpayment');
			
			$xoopsMailer =& getMailer();
			$xoopsMailer->setHTML(true);
			$xoopsMailer->setTemplateDir($GLOBALS['xoops']->path('/modules/xpayment/language/'.$GLOBALS['xoopsConfig']['language'].'/mail_templates/'));
			$xoopsMailer->setTemplate('xpayment_invoice_canceled_damaged.tpl');
			$xoopsMailer->setSubject(sprintf(_XPY_EMAIL_CANCELED_DAMAGED_SUBJECT, $invoice->getVar('grand'), $invoice->getVar('currency'), $invoice->getVar('drawto')));
			
			$xoopsMailer = setEmailXpaymentTags($xoopsMailer, $invoice, $item);
			$ttlgroups = setEmailXpaymentReceiever($xoopsMailer, $invoice, _XPY_ENUM_MODE_CANCEL+_XPY_ENUM_ITEMMODE_DAMAGED);
			
			$module_handler =& xoops_gethandler('module');
			$groupperm_handler =& xoops_gethandler('groupperm');
			$xpMod = $module_handler->getByDirname('xpayment');		
			if ($groupperm_handler->checkRight('email', _XPY_ENUM_MODE_CANCEL+_XPY_ENUM_ITEMMODE_DAMAGED, $ttlgroups, $xpMod->getVar('mid'))) 
				if (!$xoopsMailer->send())
					return false;
				else 
					return true;
			
		}
		return true;
	}
	
	function ExpressPaidXpaymentItemHook($item, $invoice) {

		if ($invoice->getVar('iid')>0) {
			xoops_load('xoopsmailer');
			xoops_loadLanguage('main','xpayment');
			
			$xoopsMailer =& getMailer();
			$xoopsMailer->setHTML(true);
			$xoopsMailer->setTemplateDir($GLOBALS['xoops']->path('/modules/xpayment/language/'.$GLOBALS['xoopsConfig']['language'].'/mail_templates/'));
			$xoopsMailer->setTemplate('xpayment_invoice_paid_express.tpl');
			$xoopsMailer->setSubject(sprintf(_XPY_EMAIL_PAID_EXPRESS_SUBJECT, $invoice->getVar('grand'), $invoice->getVar('currency'), $invoice->getVar('drawto')));
			
			$xoopsMailer = setEmailXpaymentTags($xoopsMailer, $invoice, $item);
			$ttlgroups = setEmailXpaymentReceiever($xoopsMailer, $invoice, _XPY_ENUM_MODE_PAID+_XPY_ENUM_ITEMMODE_EXPRESS);
			
			$module_handler =& xoops_gethandler('module');
			$groupperm_handler =& xoops_gethandler('groupperm');
			$xpMod = $module_handler->getByDirname('xpayment');		
			if ($groupperm_handler->checkRight('email', _XPY_ENUM_MODE_PAID+_XPY_ENUM_ITEMMODE_EXPRESS, $ttlgroups, $xpMod->getVar('mid'))) 
				if (!$xoopsMailer->send())
					return false;
				else 
					return true;
			
		}
		return true;
	}
	
	function ExpressUnpaidXpaymentItemHook($item, $invoice) {
		
		if ($invoice->getVar('iid')>0) {
			xoops_load('xoopsmailer');
			xoops_loadLanguage('main','xpayment');
			
			$xoopsMailer =& getMailer();
			$xoopsMailer->setHTML(true);
			$xoopsMailer->setTemplateDir($GLOBALS['xoops']->path('/modules/xpayment/language/'.$GLOBALS['xoopsConfig']['language'].'/mail_templates/'));
			$xoopsMailer->setTemplate('xpayment_invoice_unpaid_express.tpl');
			$xoopsMailer->setSubject(sprintf(_XPY_EMAIL_UNPAID_EXPRESS_SUBJECT, $invoice->getVar('grand'), $invoice->getVar('currency'), $invoice->getVar('drawto')));
			
			$xoopsMailer = setEmailXpaymentTags($xoopsMailer, $invoice, $item);
			$ttlgroups = setEmailXpaymentReceiever($xoopsMailer, $invoice, _XPY_ENUM_MODE_UNPAID+_XPY_ENUM_ITEMMODE_EXPRESS);
			
			$module_handler =& xoops_gethandler('module');
			$groupperm_handler =& xoops_gethandler('groupperm');
			$xpMod = $module_handler->getByDirname('xpayment');		
			if ($groupperm_handler->checkRight('email', _XPY_ENUM_MODE_UNPAID+_XPY_ENUM_ITEMMODE_EXPRESS, $ttlgroups, $xpMod->getVar('mid'))) 
				if (!$xoopsMailer->send())
					return false;
				else 
					return true;
		}
		return true;	
	}
	
	function ExpressCancelXpaymentItemHook($item, $invoice) {
		
		if ($invoice->getVar('iid')>0) {
			xoops_load('xoopsmailer');
			xoops_loadLanguage('main','xpayment');
			
			$xoopsMailer =& getMailer();
			$xoopsMailer->setHTML(true);
			$xoopsMailer->setTemplateDir($GLOBALS['xoops']->path('/modules/xpayment/language/'.$GLOBALS['xoopsConfig']['language'].'/mail_templates/'));
			$xoopsMailer->setTemplate('xpayment_invoice_canceled_express.tpl');
			$xoopsMailer->setSubject(sprintf(_XPY_EMAIL_CANCELED_EXPRESS_SUBJECT, $invoice->getVar('grand'), $invoice->getVar('currency'), $invoice->getVar('drawto')));
			
			$xoopsMailer = setEmailXpaymentTags($xoopsMailer, $invoice, $item);
			$ttlgroups = setEmailXpaymentReceiever($xoopsMailer, $invoice, _XPY_ENUM_MODE_CANCEL+_XPY_ENUM_ITEMMODE_EXPRESS);
			
			$module_handler =& xoops_gethandler('module');
			$groupperm_handler =& xoops_gethandler('groupperm');
			$xpMod = $module_handler->getByDirname('xpayment');		
			if ($groupperm_handler->checkRight('email', _XPY_ENUM_MODE_CANCEL+_XPY_ENUM_ITEMMODE_EXPRESS, $ttlgroups, $xpMod->getVar('mid'))) 
				if (!$xoopsMailer->send())
					return false;
				else 
					return true;
		}
		return true;
	}
	
	//Transaction Plugin Functions
	function PaymentPaidXpaymentTransactionHook($transaction, $invoice) {

		if ($invoice->getVar('iid')>0) {
			xoops_load('xoopsmailer');
			xoops_loadLanguage('main','xpayment');
			
			$xoopsMailer =& getMailer();
			$xoopsMailer->setHTML(true);
			$xoopsMailer->setTemplateDir($GLOBALS['xoops']->path('/modules/xpayment/language/'.$GLOBALS['xoopsConfig']['language'].'/mail_templates/'));
			$xoopsMailer->setTemplate('xpayment_invoice_transaction_paid_payment.tpl');
			$xoopsMailer->setSubject(sprintf(_XPY_EMAIL_PAID_TRANSACTION_PAYMENT_SUBJECT, $invoice->getVar('grand'), $invoice->getVar('currency'), $invoice->getVar('drawto')));
			
			$xoopsMailer = setEmailXpaymentTags($xoopsMailer, $invoice, null, $transaction);
			$ttlgroups = setEmailXpaymentReceiever($xoopsMailer, $invoice, _XPY_ENUM_MODE_PAID+_XPY_ENUM_TRANSACTION_PAYMENT);
			
			$module_handler =& xoops_gethandler('module');
			$groupperm_handler =& xoops_gethandler('groupperm');
			$xpMod = $module_handler->getByDirname('xpayment');		
			if ($groupperm_handler->checkRight('email', _XPY_ENUM_MODE_PAID+_XPY_ENUM_TRANSACTION_PAYMENT, $ttlgroups, $xpMod->getVar('mid'))) 
				if (!$xoopsMailer->send())
					return false;
				else 
					return true;
		}
		return true;
	}
	
	function PaymentUnpaidXpaymentTransactionHook($transaction, $invoice) {
		
		if ($invoice->getVar('iid')>0) {
			xoops_load('xoopsmailer');
			xoops_loadLanguage('main','xpayment');
			
			$xoopsMailer =& getMailer();
			$xoopsMailer->setHTML(true);
			$xoopsMailer->setTemplateDir($GLOBALS['xoops']->path('/modules/xpayment/language/'.$GLOBALS['xoopsConfig']['language'].'/mail_templates/'));
			$xoopsMailer->setTemplate('xpayment_invoice_transaction_unpaid_payment.tpl');
			$xoopsMailer->setSubject(sprintf(_XPY_EMAIL_UNPAID_TRANSACTION_PAYMENT_SUBJECT, $invoice->getVar('grand'), $invoice->getVar('currency'), $invoice->getVar('drawto')));
			
			$xoopsMailer = setEmailXpaymentTags($xoopsMailer, $invoice, null, $transaction);
			$ttlgroups = setEmailXpaymentReceiever($xoopsMailer, $invoice, _XPY_ENUM_MODE_UNPAID+_XPY_ENUM_TRANSACTION_PAYMENT);
			
			$module_handler =& xoops_gethandler('module');
			$groupperm_handler =& xoops_gethandler('groupperm');
			$xpMod = $module_handler->getByDirname('xpayment');		
			if ($groupperm_handler->checkRight('email', _XPY_ENUM_MODE_UNPAID+_XPY_ENUM_TRANSACTION_PAYMENT, $ttlgroups, $xpMod->getVar('mid'))) 
				if (!$xoopsMailer->send())
					return false;
				else 
					return true;
		}
		return true;	
	}
	
	function PaymentCancelXpaymentTransactionHook($transaction, $invoice) {
		
		if ($invoice->getVar('iid')>0) {
			xoops_load('xoopsmailer');
			xoops_loadLanguage('main','xpayment');
			
			$xoopsMailer =& getMailer();
			$xoopsMailer->setHTML(true);
			$xoopsMailer->setTemplateDir($GLOBALS['xoops']->path('/modules/xpayment/language/'.$GLOBALS['xoopsConfig']['language'].'/mail_templates/'));
			$xoopsMailer->setTemplate('xpayment_invoice_transaction_canceled_payment.tpl');
			$xoopsMailer->setSubject(sprintf(_XPY_EMAIL_CANCELED_TRANSACTION_PAYMENT_SUBJECT, $invoice->getVar('grand'), $invoice->getVar('currency'), $invoice->getVar('drawto')));
			
			$xoopsMailer = setEmailXpaymentTags($xoopsMailer, $invoice, null, $transaction);
			$ttlgroups = setEmailXpaymentReceiever($xoopsMailer, $invoice, _XPY_ENUM_MODE_CANCEL+_XPY_ENUM_TRANSACTION_PAYMENT);
			
			$module_handler =& xoops_gethandler('module');
			$groupperm_handler =& xoops_gethandler('groupperm');
			$xpMod = $module_handler->getByDirname('xpayment');		
			if ($groupperm_handler->checkRight('email', _XPY_ENUM_MODE_CANCEL+_XPY_ENUM_TRANSACTION_PAYMENT, $ttlgroups, $xpMod->getVar('mid'))) 
				if (!$xoopsMailer->send())
					return false;
				else 
					return true;
		}
		return true;
	}

	function RefundPaidXpaymentTransactionHook($transaction, $invoice) {

		if ($invoice->getVar('iid')>0) {
			xoops_load('xoopsmailer');
			xoops_loadLanguage('main','xpayment');
			
			$xoopsMailer =& getMailer();
			$xoopsMailer->setHTML(true);
			$xoopsMailer->setTemplateDir($GLOBALS['xoops']->path('/modules/xpayment/language/'.$GLOBALS['xoopsConfig']['language'].'/mail_templates/'));
			$xoopsMailer->setTemplate('xpayment_invoice_transaction_paid_refund.tpl');
			$xoopsMailer->setSubject(sprintf(_XPY_EMAIL_PAID_TRANSACTION_REFUND_SUBJECT, $invoice->getVar('grand'), $invoice->getVar('currency'), $invoice->getVar('drawto')));
			
			$xoopsMailer = setEmailXpaymentTags($xoopsMailer, $invoice, null, $transaction);
			$ttlgroups = setEmailXpaymentReceiever($xoopsMailer, $invoice, _XPY_ENUM_MODE_PAID+_XPY_ENUM_TRANSACTION_REFUND);
			
			$module_handler =& xoops_gethandler('module');
			$groupperm_handler =& xoops_gethandler('groupperm');
			$xpMod = $module_handler->getByDirname('xpayment');		
			if ($groupperm_handler->checkRight('email', _XPY_ENUM_MODE_PAID+_XPY_ENUM_TRANSACTION_REFUND, $ttlgroups, $xpMod->getVar('mid'))) 
				if (!$xoopsMailer->send())
					return false;
				else 
					return true;
		}
		return true;
	}
	
	function RefundUnpaidXpaymentTransactionHook($transaction, $invoice) {
		
		if ($invoice->getVar('iid')>0) {
			xoops_load('xoopsmailer');
			xoops_loadLanguage('main','xpayment');
			
			$xoopsMailer =& getMailer();
			$xoopsMailer->setHTML(true);
			$xoopsMailer->setTemplateDir($GLOBALS['xoops']->path('/modules/xpayment/language/'.$GLOBALS['xoopsConfig']['language'].'/mail_templates/'));
			$xoopsMailer->setTemplate('xpayment_invoice_transaction_unpaid_refund.tpl');
			$xoopsMailer->setSubject(sprintf(_XPY_EMAIL_UNPAID_TRANSACTION_REFUND_SUBJECT, $invoice->getVar('grand'), $invoice->getVar('currency'), $invoice->getVar('drawto')));
			
			$xoopsMailer = setEmailXpaymentTags($xoopsMailer, $invoice, null, $transaction);
			$ttlgroups = setEmailXpaymentReceiever($xoopsMailer, $invoice, _XPY_ENUM_MODE_UNPAID+_XPY_ENUM_TRANSACTION_REFUND);
			
			$module_handler =& xoops_gethandler('module');
			$groupperm_handler =& xoops_gethandler('groupperm');
			$xpMod = $module_handler->getByDirname('xpayment');		
			if ($groupperm_handler->checkRight('email', _XPY_ENUM_MODE_UNPAID+_XPY_ENUM_TRANSACTION_REFUND, $ttlgroups, $xpMod->getVar('mid'))) 
				if (!$xoopsMailer->send())
					return false;
				else 
					return true;
		}
		return true;	
	}
	
	function RefundCancelXpaymentTransactionHook($transaction, $invoice) {
		
		if ($invoice->getVar('iid')>0) {
			xoops_load('xoopsmailer');
			xoops_loadLanguage('main','xpayment');
			
			$xoopsMailer =& getMailer();
			$xoopsMailer->setHTML(true);
			$xoopsMailer->setTemplateDir($GLOBALS['xoops']->path('/modules/xpayment/language/'.$GLOBALS['xoopsConfig']['language'].'/mail_templates/'));
			$xoopsMailer->setTemplate('xpayment_invoice_transaction_canceled_refund.tpl');
			$xoopsMailer->setSubject(sprintf(_XPY_EMAIL_CANCELED_TRANSACTION_REFUND_SUBJECT, $invoice->getVar('grand'), $invoice->getVar('currency'), $invoice->getVar('drawto')));
			
			$xoopsMailer = setEmailXpaymentTags($xoopsMailer, $invoice, null, $transaction);
			$ttlgroups = setEmailXpaymentReceiever($xoopsMailer, $invoice, _XPY_ENUM_MODE_CANCEL+_XPY_ENUM_TRANSACTION_REFUND);
			
			$module_handler =& xoops_gethandler('module');
			$groupperm_handler =& xoops_gethandler('groupperm');
			$xpMod = $module_handler->getByDirname('xpayment');		
			if ($groupperm_handler->checkRight('email', _XPY_ENUM_MODE_CANCEL+_XPY_ENUM_TRANSACTION_REFUND, $ttlgroups, $xpMod->getVar('mid'))) 
				if (!$xoopsMailer->send())
					return false;
				else 
					return true;
		}
		return true;
	}
	
	function PendingPaidXpaymentTransactionHook($transaction, $invoice) {

		if ($invoice->getVar('iid')>0) {
			xoops_load('xoopsmailer');
			xoops_loadLanguage('main','xpayment');
			
			$xoopsMailer =& getMailer();
			$xoopsMailer->setHTML(true);
			$xoopsMailer->setTemplateDir($GLOBALS['xoops']->path('/modules/xpayment/language/'.$GLOBALS['xoopsConfig']['language'].'/mail_templates/'));
			$xoopsMailer->setTemplate('xpayment_invoice_transaction_paid_pending.tpl');
			$xoopsMailer->setSubject(sprintf(_XPY_EMAIL_PAID_TRANSACTION_PENDING_SUBJECT, $invoice->getVar('grand'), $invoice->getVar('currency'), $invoice->getVar('drawto')));
			
			$xoopsMailer = setEmailXpaymentTags($xoopsMailer, $invoice, null, $transaction);
			$ttlgroups = setEmailXpaymentReceiever($xoopsMailer, $invoice, _XPY_ENUM_MODE_PAID+_XPY_ENUM_TRANSACTION_PENDING);
			
			$module_handler =& xoops_gethandler('module');
			$groupperm_handler =& xoops_gethandler('groupperm');
			$xpMod = $module_handler->getByDirname('xpayment');		
			if ($groupperm_handler->checkRight('email', _XPY_ENUM_MODE_PAID+_XPY_ENUM_TRANSACTION_PENDING, $ttlgroups, $xpMod->getVar('mid'))) 
				if (!$xoopsMailer->send())
					return false;
				else 
					return true;
		}
		return true;
	}
	
	function PendingUnpaidXpaymentTransactionHook($transaction, $invoice) {
		
		if ($invoice->getVar('iid')>0) {
			xoops_load('xoopsmailer');
			xoops_loadLanguage('main','xpayment');
			
			$xoopsMailer =& getMailer();
			$xoopsMailer->setHTML(true);
			$xoopsMailer->setTemplateDir($GLOBALS['xoops']->path('/modules/xpayment/language/'.$GLOBALS['xoopsConfig']['language'].'/mail_templates/'));
			$xoopsMailer->setTemplate('xpayment_invoice_transaction_unpaid_pending.tpl');
			$xoopsMailer->setSubject(sprintf(_XPY_EMAIL_UNPAID_TRANSACTION_PENDING_SUBJECT, $invoice->getVar('grand'), $invoice->getVar('currency'), $invoice->getVar('drawto')));
			
			$xoopsMailer = setEmailXpaymentTags($xoopsMailer, $invoice, null, $transaction);
			$ttlgroups = setEmailXpaymentReceiever($xoopsMailer, $invoice, _XPY_ENUM_MODE_UNPAID+_XPY_ENUM_TRANSACTION_PENDING);
			
			$module_handler =& xoops_gethandler('module');
			$groupperm_handler =& xoops_gethandler('groupperm');
			$xpMod = $module_handler->getByDirname('xpayment');		
			if ($groupperm_handler->checkRight('email', _XPY_ENUM_MODE_UNPAID+_XPY_ENUM_TRANSACTION_PENDING, $ttlgroups, $xpMod->getVar('mid'))) 
				if (!$xoopsMailer->send())
					return false;
				else 
					return true;
		}
		return true;	
	}
	
	function PendingCancelXpaymentTransactionHook($transaction, $invoice) {
		
		if ($invoice->getVar('iid')>0) {
			xoops_load('xoopsmailer');
			xoops_loadLanguage('main','xpayment');
			
			$xoopsMailer =& getMailer();
			$xoopsMailer->setHTML(true);
			$xoopsMailer->setTemplateDir($GLOBALS['xoops']->path('/modules/xpayment/language/'.$GLOBALS['xoopsConfig']['language'].'/mail_templates/'));
			$xoopsMailer->setTemplate('xpayment_invoice_transaction_canceled_pending.tpl');
			$xoopsMailer->setSubject(sprintf(_XPY_EMAIL_CANCELED_TRANSACTION_PENDING_SUBJECT, $invoice->getVar('grand'), $invoice->getVar('currency'), $invoice->getVar('drawto')));
			
			$xoopsMailer = setEmailXpaymentTags($xoopsMailer, $invoice, null, $transaction);
			$ttlgroups = setEmailXpaymentReceiever($xoopsMailer, $invoice, _XPY_ENUM_MODE_CANCEL+_XPY_ENUM_TRANSACTION_PENDING);
			
			$module_handler =& xoops_gethandler('module');
			$groupperm_handler =& xoops_gethandler('groupperm');
			$xpMod = $module_handler->getByDirname('xpayment');		
			if ($groupperm_handler->checkRight('email', _XPY_ENUM_MODE_CANCEL+_XPY_ENUM_TRANSACTION_PENDING, $ttlgroups, $xpMod->getVar('mid'))) 
				if (!$xoopsMailer->send())
					return false;
				else 
					return true;
		}
		return true;
	}
	
	function NoticePaidXpaymentTransactionHook($transaction, $invoice) {

		if ($invoice->getVar('iid')>0) {
			xoops_load('xoopsmailer');
			xoops_loadLanguage('main','xpayment');
			
			$xoopsMailer =& getMailer();
			$xoopsMailer->setHTML(true);
			$xoopsMailer->setTemplateDir($GLOBALS['xoops']->path('/modules/xpayment/language/'.$GLOBALS['xoopsConfig']['language'].'/mail_templates/'));
			$xoopsMailer->setTemplate('xpayment_invoice_transaction_paid_notice.tpl');
			$xoopsMailer->setSubject(sprintf(_XPY_EMAIL_PAID_TRANSACTION_NOTICE_SUBJECT, $invoice->getVar('grand'), $invoice->getVar('currency'), $invoice->getVar('drawto')));
			
			$xoopsMailer = setEmailXpaymentTags($xoopsMailer, $invoice, null, $transaction);
			$ttlgroups = setEmailXpaymentReceiever($xoopsMailer, $invoice, _XPY_ENUM_MODE_PAID+_XPY_ENUM_TRANSACTION_NOTICE);
			
			$module_handler =& xoops_gethandler('module');
			$groupperm_handler =& xoops_gethandler('groupperm');
			$xpMod = $module_handler->getByDirname('xpayment');		
			if ($groupperm_handler->checkRight('email', _XPY_ENUM_MODE_PAID+_XPY_ENUM_TRANSACTION_NOTICE, $ttlgroups, $xpMod->getVar('mid'))) 
				if (!$xoopsMailer->send())
					return false;
				else 
					return true;
		}
		return true;
	}
	
	function NoticeUnpaidXpaymentTransactionHook($transaction, $invoice) {
		
		if ($invoice->getVar('iid')>0) {
			xoops_load('xoopsmailer');
			xoops_loadLanguage('main','xpayment');
			
			$xoopsMailer =& getMailer();
			$xoopsMailer->setHTML(true);
			$xoopsMailer->setTemplateDir($GLOBALS['xoops']->path('/modules/xpayment/language/'.$GLOBALS['xoopsConfig']['language'].'/mail_templates/'));
			$xoopsMailer->setTemplate('xpayment_invoice_transaction_unpaid_notice.tpl');
			$xoopsMailer->setSubject(sprintf(_XPY_EMAIL_UNPAID_TRANSACTION_NOTICE_SUBJECT, $invoice->getVar('grand'), $invoice->getVar('currency'), $invoice->getVar('drawto')));
			
			$xoopsMailer = setEmailXpaymentTags($xoopsMailer, $invoice, null, $transaction);
			$ttlgroups = setEmailXpaymentReceiever($xoopsMailer, $invoice, _XPY_ENUM_MODE_UNPAID+_XPY_ENUM_TRANSACTION_NOTICE);
			
			$module_handler =& xoops_gethandler('module');
			$groupperm_handler =& xoops_gethandler('groupperm');
			$xpMod = $module_handler->getByDirname('xpayment');		
			if ($groupperm_handler->checkRight('email', _XPY_ENUM_MODE_UNPAID+_XPY_ENUM_TRANSACTION_NOTICE, $ttlgroups, $xpMod->getVar('mid'))) 
				if (!$xoopsMailer->send())
					return false;
				else 
					return true;
		}
		return true;	
	}
	
	function NoticeCancelXpaymentTransactionHook($transaction, $invoice) {
		
		if ($invoice->getVar('iid')>0) {
			xoops_load('xoopsmailer');
			xoops_loadLanguage('main','xpayment');
			
			$xoopsMailer =& getMailer();
			$xoopsMailer->setHTML(true);
			$xoopsMailer->setTemplateDir($GLOBALS['xoops']->path('/modules/xpayment/language/'.$GLOBALS['xoopsConfig']['language'].'/mail_templates/'));
			$xoopsMailer->setTemplate('xpayment_invoice_transaction_canceled_notice.tpl');
			$xoopsMailer->setSubject(sprintf(_XPY_EMAIL_CANCELED_TRANSACTION_NOTICE_SUBJECT, $invoice->getVar('grand'), $invoice->getVar('currency'), $invoice->getVar('drawto')));
			
			$xoopsMailer = setEmailXpaymentTags($xoopsMailer, $invoice, null, $transaction);
			$ttlgroups = setEmailXpaymentReceiever($xoopsMailer, $invoice, _XPY_ENUM_MODE_CANCEL+_XPY_ENUM_TRANSACTION_NOTICE);
			
			$module_handler =& xoops_gethandler('module');
			$groupperm_handler =& xoops_gethandler('groupperm');
			$xpMod = $module_handler->getByDirname('xpayment');		
			if ($groupperm_handler->checkRight('email', _XPY_ENUM_MODE_CANCEL+_XPY_ENUM_TRANSACTION_NOTICE, $ttlgroups, $xpMod->getVar('mid'))) 
				if (!$xoopsMailer->send())
					return false;
				else 
					return true;
		}
		return true;
	}
	
	function OtherPaidXpaymentTransactionHook($transaction, $invoice) {

		if ($invoice->getVar('iid')>0) {
			xoops_load('xoopsmailer');
			xoops_loadLanguage('main','xpayment');
			
			$xoopsMailer =& getMailer();
			$xoopsMailer->setHTML(true);
			$xoopsMailer->setTemplateDir($GLOBALS['xoops']->path('/modules/xpayment/language/'.$GLOBALS['xoopsConfig']['language'].'/mail_templates/'));
			$xoopsMailer->setTemplate('xpayment_invoice_transaction_paid_other.tpl');
			$xoopsMailer->setSubject(sprintf(_XPY_EMAIL_PAID_TRANSACTION_OTHER_SUBJECT, $invoice->getVar('grand'), $invoice->getVar('currency'), $invoice->getVar('drawto')));
			
			$xoopsMailer = setEmailXpaymentTags($xoopsMailer, $invoice, null, $transaction);
			$ttlgroups = setEmailXpaymentReceiever($xoopsMailer, $invoice, _XPY_ENUM_MODE_PAID+_XPY_ENUM_TRANSACTION_OTHER);
			
			$module_handler =& xoops_gethandler('module');
			$groupperm_handler =& xoops_gethandler('groupperm');
			$xpMod = $module_handler->getByDirname('xpayment');		
			if ($groupperm_handler->checkRight('email', _XPY_ENUM_MODE_PAID+_XPY_ENUM_TRANSACTION_OTHER, $ttlgroups, $xpMod->getVar('mid'))) 
				if (!$xoopsMailer->send())
					return false;
				else 
					return true;
		}
		return true;
	}
	
	function OtherUnpaidXpaymentTransactionHook($transaction, $invoice) {
		
		if ($invoice->getVar('iid')>0) {
			xoops_load('xoopsmailer');
			xoops_loadLanguage('main','xpayment');
			
			$xoopsMailer =& getMailer();
			$xoopsMailer->setHTML(true);
			$xoopsMailer->setTemplateDir($GLOBALS['xoops']->path('/modules/xpayment/language/'.$GLOBALS['xoopsConfig']['language'].'/mail_templates/'));
			$xoopsMailer->setTemplate('xpayment_invoice_transaction_unpaid_other.tpl');
			$xoopsMailer->setSubject(sprintf(_XPY_EMAIL_UNPAID_TRANSACTION_OTHER_SUBJECT, $invoice->getVar('grand'), $invoice->getVar('currency'), $invoice->getVar('drawto')));
			
			$xoopsMailer = setEmailXpaymentTags($xoopsMailer, $invoice, null, $transaction);
			$ttlgroups = setEmailXpaymentReceiever($xoopsMailer, $invoice, _XPY_ENUM_MODE_UNPAID+_XPY_ENUM_TRANSACTION_OTHER);
			
			$module_handler =& xoops_gethandler('module');
			$groupperm_handler =& xoops_gethandler('groupperm');
			$xpMod = $module_handler->getByDirname('xpayment');		
			if ($groupperm_handler->checkRight('email', _XPY_ENUM_MODE_UNPAID+_XPY_ENUM_TRANSACTION_OTHER, $ttlgroups, $xpMod->getVar('mid'))) 
				if (!$xoopsMailer->send())
					return false;
				else 
					return true;
		}
		return true;	
	}
	
	function OtherCancelXpaymentTransactionHook($transaction, $invoice) {
		
		if ($invoice->getVar('iid')>0) {
			xoops_load('xoopsmailer');
			xoops_loadLanguage('main','xpayment');
			
			$xoopsMailer =& getMailer();
			$xoopsMailer->setHTML(true);
			$xoopsMailer->setTemplateDir($GLOBALS['xoops']->path('/modules/xpayment/language/'.$GLOBALS['xoopsConfig']['language'].'/mail_templates/'));
			$xoopsMailer->setTemplate('xpayment_invoice_transaction_canceled_other.tpl');
			$xoopsMailer->setSubject(sprintf(_XPY_EMAIL_CANCELED_TRANSACTION_OTHER_SUBJECT, $invoice->getVar('grand'), $invoice->getVar('currency'), $invoice->getVar('drawto')));
			
			$xoopsMailer = setEmailXpaymentTags($xoopsMailer, $invoice, null, $transaction);
			$ttlgroups = setEmailXpaymentReceiever($xoopsMailer, $invoice, _XPY_ENUM_MODE_CANCEL+_XPY_ENUM_TRANSACTION_OTHER);
			
			$module_handler =& xoops_gethandler('module');
			$groupperm_handler =& xoops_gethandler('groupperm');
			$xpMod = $module_handler->getByDirname('xpayment');		
			if ($groupperm_handler->checkRight('email', _XPY_ENUM_MODE_CANCEL+_XPY_ENUM_TRANSACTION_OTHER, $ttlgroups, $xpMod->getVar('mid'))) 
				if (!$xoopsMailer->send())
					return false;
				else 
					return true;
		}
		return true;
	}
	//Generic functions for mail with Xpayment
	function setEmailXpaymentReceiever($xoopsMailer, $invoice, $itemid) {
		$user_handler =& xoops_gethandler('user');
		$module_handler =& xoops_gethandler('module');
		$groupperm_handler =& xoops_gethandler('groupperm');
		$xpMod = $module_handler->getByDirname('xpayment');
		$ttlgroups = array();
		
		foreach($invoice->getVar('broker_uids') as $id=>$uid) {
			$user = $user_handler->get($uid);
			if (is_object($user))
				$groups = $user->getGroups();
			else 
				$groups = XOOPS_GROUP_ANONYMOUS;
			if ($groupperm_handler->checkRight('email', $itemid, $groups, $xpMod->getVar('mid'))) {					
				$xoopsMailer->setToEmails($user->getVar('email'));
				if (is_array($groups))
					$ttlgroups = array_unique(array_merge($ttlgroups, $groups));
				else
					$ttlgroups = array_unique(array_merge($ttlgroups, array($groups)));
			}
		}
		
		foreach($invoice->getVar('accounts_uids') as $id=>$uid) {
			$user = $user_handler->get($uid);
			if (is_object($user))
				$groups = $user->getGroups();
			else 
				$groups = XOOPS_GROUP_ANONYMOUS;
			if ($groupperm_handler->checkRight('email', $itemid, $groups, $xpMod->getVar('mid'))) {					
				$xoopsMailer->setToEmails($user->getVar('email'));
				if (is_array($groups))
					$ttlgroups = array_unique(array_merge($ttlgroups, $groups));
				else
					$ttlgroups = array_unique(array_merge($ttlgroups, array($groups)));
				
			}
		}
		
		foreach($invoice->getVar('officer_uids') as $id=>$uid) {
			$user = $user_handler->get($uid);
			if (is_object($user))
				$groups = $user->getGroups();
			else 
				$groups = XOOPS_GROUP_ANONYMOUS;
			if ($groupperm_handler->checkRight('email', $itemid, $groups, $xpMod->getVar('mid'))) {					
				$xoopsMailer->setToEmails($user->getVar('email'));
				if (is_array($groups))
					$ttlgroups = array_unique(array_merge($ttlgroups, $groups));
				else
					$ttlgroups = array_unique(array_merge($ttlgroups, array($groups)));
				
			}
		}
		
		$user = $user_handler->get($invoice->getVar('user_uid'));
		
		if (is_object($user))
			$groups = $user->getGroups();
		else 
			$groups = XOOPS_GROUP_ANONYMOUS;
		
		if ($groupperm_handler->checkRight('email', $itemid, $groups, $xpMod->getVar('mid'))) {					
			if ($groups = XOOPS_GROUP_ANONYMOUS)
				$xoopsMailer->setToEmails($invoice->getVar('drawto_email'));
			else 
				$xoopsMailer->setToEmails($user->getVar('email'));
			if (is_array($groups))
				$ttlgroups = array_unique(array_merge($ttlgroups, $groups));
			else
				$ttlgroups = array_unique(array_merge($ttlgroups, array($groups)));
				
		}
		
		return $ttlgroups;
	}
	
	function setEmailXpaymentTags($xoopsMailer, $invoice, $item, $transaction) {
		
		if (is_object($transaction))
			$gross = $transaction->getVar('gross');
		else 
			$gross = 0;
		
		$xoopsMailer->assign("SITEURL", XOOPS_URL);
		$xoopsMailer->assign("SITENAME", $GLOBALS['xoopsConfig']['sitename']);
		$xoopsMailer->assign("INVOICENUMBER", $invoice->getVar('invoicenumber'));
		$xoopsMailer->assign("CURRENCY", $invoice->getVar('currency'));
		$xoopsMailer->assign("DRAWTO", $invoice->getVar('drawto'));
		$xoopsMailer->assign("DRAWTO_EMAIL", $invoice->getVar('drawto_email'));
		$xoopsMailer->assign("DRAWFOR", $invoice->getVar('drawfor'));
		$xoopsMailer->assign("GRAND", $invoice->getVar('grand'));
		$xoopsMailer->assign("AMOUNT", $invoice->getVar('amount'));
		$xoopsMailer->assign("SHIPPING", $invoice->getVar('shipping'));
		$xoopsMailer->assign("HANDLING", $invoice->getVar('handling'));
		$xoopsMailer->assign("TAX", $invoice->getVar('tax'));
		$xoopsMailer->assign("WEIGHT", $invoice->getVar('weight'));
		$xoopsMailer->assign("WEIGHTUNIT", $invoice->getVar('weight_unit'));
		$xoopsMailer->assign("ITEMS", $invoice->getVar('items'));
		$xoopsMailer->assign("SETTLEFOR", $invoice->getVar('remittion_settled'));
		$xoopsMailer->assign("INVURL", $invoice->getURL());
		$xoopsMailer->assign("PDFURL", $invoice->getPDFURL());
		$invoice_transactions_handler =& xoops_getmodulehandler('invoice_transactions', 'xpayment');
		$xoopsMailer->assign("PAID", $invoice_transactions_handler->sumOfGross($invoice->getVar('iid')))+$gross;
		$xoopsMailer->assign("LEFT", $invoice->getVar('grand') - ($invoice_transactions_handler->sumOfGross($invoice->getVar('iid'))+$gross));
		$xoopsMailer->assign("REOCCURENCE", $invoice->getVar('reoccurence'));
		$xoopsMailer->assign("REOCCURENCES", $invoice->getVar('reoccurences'));
		$xoopsMailer->assign("OCCURENCEPAIDGRAND", $invoice->getVar('occurence_grand'));
		$xoopsMailer->assign("OCCURENCEPAIDAMOUNT", $invoice->getVar('occurence_amount'));
		$xoopsMailer->assign("OCCURENCEPAIDSHIPPING", $invoice->getVar('occurence_shipping'));
		$xoopsMailer->assign("OCCURENCEPAIDHANDLING", $invoice->getVar('occurence_handling'));
		$xoopsMailer->assign("OCCURENCEPAIDTAX", $invoice->getVar('occurence_tax'));
		$xoopsMailer->assign("OCCURENCEPAIDWEIGHT", $invoice->getVar('occurence_weight'));
		$xoopsMailer->assign("OCCURENCELEFTGRAND", $invoice->getOccurencesLeftGrand());
		$xoopsMailer->assign("OCCURENCELEFTAMOUNT", $invoice->getOccurencesLeftAmount());
		$xoopsMailer->assign("OCCURENCELEFTSHIPPING", $invoice->getOccurencesLeftShipping());
		$xoopsMailer->assign("OCCURENCELEFTHANDLING", $invoice->getOccurencesLeftHandling());
		$xoopsMailer->assign("OCCURENCELEFTTAX", $invoice->getOccurencesLeftTax());
		$xoopsMailer->assign("OCCURENCELEFTWEIGHT", $invoice->getOccurencesLeftWeight());
		$xoopsMailer->assign("OCCURENCETOTALGRAND", $invoice->getOccurencesTotalGrand());
		$xoopsMailer->assign("OCCURENCETOTALAMOUNT", $invoice->getOccurencesTotalAmount());
		$xoopsMailer->assign("OCCURENCETOTALSHIPPING", $invoice->getOccurencesTotalShipping());
		$xoopsMailer->assign("OCCURENCETOTALHANDLING", $invoice->getOccurencesTotalHandling());
		$xoopsMailer->assign("OCCURENCETOTALTAX", $invoice->getOccurencesTotalTax());
		$xoopsMailer->assign("OCCURENCETOTALWEIGHT", $invoice->getOccurencesTotalWeight());
		$xoopsMailer->assign("REBILLDAYS", $invoice->getVar('reoccurence_period_days'));
		$xoopsMailer->assign("CREATED", date(_DATESTRING, $invoice->getVar('created')));
		$xoopsMailer->assign("UPDATED", date(_DATESTRING, $invoice->getVar('updated')));
		$xoopsMailer->assign("ACTIONED", date(_DATESTRING, $invoice->getVar('actioned')));
		$xoopsMailer->assign("OCCURENCE", date(_DATESTRING, $invoice->getVar('occurance')));
		$xoopsMailer->assign("PREVIOUS", date(_DATESTRING, $invoice->getVar('previous')));
		$xoopsMailer->assign("REMITTED", date(_DATESTRING, $invoice->getVar('remitted')));
		$xoopsMailer->assign("DUE", date(_DATESTRING, $invoice->getVar('due')));
		$xoopsMailer->assign("COLLECT", date(_DATESTRING, $invoice->getVar('collect')));
		$xoopsMailer->assign("WAIT", date(_DATESTRING, $invoice->getVar('wait')));
		$xoopsMailer->assign("OFFLINE", date(_DATESTRING, $invoice->getVar('offline')));
		$xoopsMailer->assign("USERIP", $invoice->getVar('user_ip'));
		$xoopsMailer->assign("USERUID", $invoice->getVar('user_uid'));
		$xoopsMailer->assign("MODE", $invoice->getVar('mode'));
		$xoopsMailer->assign("REMITTION", $invoice->getVar('remittion'));
		$xoopsMailer->assign("GROSS", $gross);
		
		if (is_object($item)) {
			foreach($item->toArray() as $key=>$value)
				$xoopsMailer->assign("ITEM_".strtoupper($key), $value);
		}
		
		if (is_object($transaction)) {
			foreach($transaction->toArray() as $key=>$value)
				$xoopsMailer->assign("TRANSACTION_".strtoupper($key), $value);
		}
		
		$invoice_items_handler =& xoops_getmodulehandler('invoice_items', 'xpayment');
		$items = $invoice_items_handler->getObjects(new Criteria('iid', $invoice->getVar('iid')), false, true);
		$i=0;
		foreach($items as $iid => $item){
			$i++;
			foreach($item as $key=>$value)
				$xoopsMailer->assign("ITEMS_".$i.'_'.strtoupper($key), $value);		
		}
		$xoopsMailer->assign("ITEMS_COUNT", $i);
		
		$user_handler =& xoops_gethandler('user');
		$module_handler =& xoops_gethandler('module');
		$groupperm_handler =& xoops_gethandler('groupperm');
		$xpMod = $module_handler->getByDirname('xpayment');
		
		$profile = $module_handler->getByDirname('profile');
		if (is_object($profile))
			$profile_handler =& xoops_getmodulehandler('profile', 'profile');
		$i=0;
		foreach($invoice->getVar('broker_uids') as $id=>$uid) {
			$user = $user_handler->get($uid);
			if (is_object($user)) {
				$i++;
				foreach($user->toArray() as $key=>$value)
					$xoopsMailer->assign("BROKERS_".$i.'_'.strtoupper($key), $value);
				
				if (is_object($profile)) {
					$userprofile = $profile_handler->get($uid);
					if (is_object($userprofile)) {	
						foreach($userprofile->toArray() as $key=>$value)
							$xoopsMailer->assign("BROKERS_".$i.'_'.strtoupper($key), $value);
					}	
				}		
			}
		}			
		$xoopsMailer->assign("BROKERS_COUNT",$i);
		
		$i=0;
		foreach($invoice->getVar('accounts_uids') as $id=>$uid) {
			$user = $user_handler->get($uid);
			if (is_object($user)) {
				$i++;
				foreach($user->toArray() as $key=>$value)
					$xoopsMailer->assign("ACCOUNTS_".$i.'_'.strtoupper($key), $value);
				if (is_object($profile)) {
					$userprofile = $profile_handler->get($uid);
					if (is_object($userprofile)) {	
						foreach($userprofile->toArray() as $key=>$value)
							$xoopsMailer->assign("ACCOUNTS_".$i.'_'.strtoupper($key), $value);
					}	
				}		
			}
		}
		$xoopsMailer->assign("ACCOUNTS_COUNT",$i);
		
		$i=0;
		foreach($invoice->getVar('officer_uids') as $id=>$uid) {
			$user = $user_handler->get($uid);
			if (is_object($user)) {
				$i++;
				foreach($user->toArray() as $key=>$value)
					$xoopsMailer->assign("OFFICERS_".$i.'_'.strtoupper($key), $value);
				if (is_object($profile)) {
					$userprofile = $profile_handler->get($uid);
					if (is_object($userprofile)) {	
						foreach($userprofile->toArray() as $key=>$value)
							$xoopsMailer->assign("OFFICERS_".$i.'_'.strtoupper($key), $value);
					}	
				}		
			}
		}
		$xoopsMailer->assign("OFFICERS_COUNT",$i);
		
		return $xoopsMailer;
	}
?>